<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Email terkait pendaftaran akun:
 *  - 'masuk'     : ke Administrator, ada pendaftar baru yang menunggu persetujuan
 *  - 'disetujui' : ke pendaftar, akun sudah aktif
 *  - 'ditolak'   : ke pendaftar, pendaftaran ditolak (beserta alasan)
 */
class PendaftaranAkunNotification extends Notification
{
    public function __construct(public string $jenis, public User $pendaftar)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $p = $this->pendaftar;
        $pesan = (new MailMessage)->salutation('Salam, Bakorwil III Malang');

        return match ($this->jenis) {
            'masuk' => $pesan
                ->subject('Pendaftaran Akun Baru Menunggu Persetujuan · SIKP Malang Selatan')
                ->greeting('Halo, '.$notifiable->name)
                ->line("Ada pendaftaran akun Petugas baru: {$p->name} ({$p->email}), {$p->jabatan}.")
                ->line('Periksa data pendaftar sebelum menyetujui.')
                ->action('Tinjau Pendaftaran', route('admin.users.index')),
            'disetujui' => $pesan
                ->subject('Akun Anda Telah Disetujui · SIKP Malang Selatan')
                ->greeting('Halo, '.$p->name)
                ->line('Pendaftaran akun Anda telah disetujui Administrator. Anda sekarang dapat masuk ke Panel Pengelola.')
                ->action('Masuk ke Panel Pengelola', route('login')),
            default => $pesan
                ->subject('Pendaftaran Akun Tidak Disetujui · SIKP Malang Selatan')
                ->greeting('Halo, '.$p->name)
                ->line('Mohon maaf, pendaftaran akun Anda tidak disetujui Administrator.')
                ->line($p->alasan_ditolak ? 'Alasan: '.$p->alasan_ditolak : 'Hubungi Administrator Bakorwil III Malang untuk informasi lebih lanjut.'),
        };
    }
}
