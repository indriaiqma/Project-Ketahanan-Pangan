<?php

namespace App\Http\Controllers;

use App\Models\PermintaanResetPassword;
use App\Models\User;
use App\Support\Surel;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as AturanPassword;

/**
 * Lupa password untuk Admin & Petugas.
 *
 *  1. Tautan reset ke email (bila SMTP sudah dikonfigurasi, lihat Support\Surel).
 *  2. Cadangan: permintaan reset ke Administrator, yang membuatkan password
 *     sementara; pengguna wajib menggantinya saat login berikutnya.
 *
 * Demi keamanan, respons selalu sama baik email terdaftar maupun tidak
 * (tidak membocorkan daftar akun).
 */
class LupaPasswordController extends Controller
{
    private const PESAN_UMUM = 'Jika email tersebut terdaftar sebagai akun Admin/Petugas, permintaan Anda sudah kami proses.';

    public function form()
    {
        return view('auth.lupa-password', ['emailSiap' => Surel::siap()]);
    }

    /** Kirim tautan reset ke email. */
    public function kirimEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|max:255'], [], ['email' => 'email']);

        if (! Surel::siap()) {
            return back()->withInput()->withErrors(['email' => 'Pengiriman email belum tersedia. Gunakan "Minta reset ke Administrator".']);
        }

        if ($this->akun($request->email)) {
            try {
                Password::sendResetLink(['email' => $request->email]);
            } catch (\Throwable $e) {
                Log::error('Gagal mengirim email reset password: '.$e->getMessage());

                return back()->withInput()->withErrors(['email' => 'Email gagal dikirim. Coba lagi nanti atau minta reset ke Administrator.']);
            }
        }

        return back()->with('status', self::PESAN_UMUM.' Periksa kotak masuk (dan folder spam) email Anda. Tautan berlaku '.config('auth.passwords.users.expire').' menit.');
    }

    /** Kirim permintaan reset ke Administrator. */
    public function mintaAdmin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'catatan' => 'nullable|string|max:255',
        ], [], ['email' => 'email', 'catatan' => 'catatan']);

        if ($user = $this->akun($request->email)) {
            // Satu permintaan yang menunggu per akun sudah cukup
            PermintaanResetPassword::menunggu()->firstOrCreate(
                ['user_id' => $user->id],
                ['catatan' => $request->catatan, 'ip' => $request->ip()]
            );
        }

        return back()->with('status', self::PESAN_UMUM.' Administrator akan membuatkan password sementara dan menyampaikannya kepada Anda. Hubungi Administrator Bakorwil III Malang bila mendesak.');
    }

    /** Form password baru dari tautan email. */
    public function formReset(Request $request, string $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->query('email')]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', AturanPassword::min(8)->letters()->numbers()],
        ], [], ['password' => 'password baru']);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                    'wajib_ganti_password' => false,
                ])->save();
                PermintaanResetPassword::menunggu()->where('user_id', $user->id)
                    ->update(['status' => 'selesai', 'diproses_pada' => now()]);
                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Password berhasil diatur ulang. Silakan masuk dengan password baru.');
        }

        return back()->withInput($request->only('email'))->withErrors(['email' => match ($status) {
            Password::INVALID_TOKEN => 'Tautan reset tidak valid atau sudah kedaluwarsa. Minta tautan baru.',
            Password::INVALID_USER => 'Email tidak sesuai dengan tautan reset.',
            default => 'Password gagal diatur ulang. Coba lagi.',
        }]);
    }

    /** Akun Admin/Petugas dengan email tersebut (null bila tidak ada). */
    private function akun(string $email): ?User
    {
        return User::where('email', $email)->whereIn('role', array_keys(User::ROLES))->where('status_akun', 'aktif')->first();
    }
}
