<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // ==========================================
    // TAMPILKAN PROFIL
    // ==========================================
    public function index()
    {
        $user = auth()->user();

        return view('profile.index', compact('user'));
    }


    // ==========================================
    // UPDATE PROFIL
    // ==========================================
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect('/profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }


    // ==========================================
    // UPDATE PASSWORD
    // ==========================================
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors([
                'password_lama' => 'Password lama tidak sesuai.'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password_baru),
        ]);

        return redirect('/profile')
            ->with('success', 'Password berhasil diperbarui.');
    }
}