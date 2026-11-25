<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/** Email tautan reset password berbahasa Indonesia. */
class ResetPasswordNotification extends Notification
{
    public function __construct(public string $token)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $url = route('password.reset', ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()]);
        $menit = config('auth.passwords.users.expire');

        return (new MailMessage)
            ->subject('Atur Ulang Password · SIKP Malang Selatan')
            ->greeting('Halo, '.$notifiable->name)
            ->line('Kami menerima permintaan untuk mengatur ulang password akun Anda di Sistem Informasi Ketahanan Pangan Malang Selatan.')
            ->action('Atur Ulang Password', $url)
            ->line("Tautan ini berlaku selama {$menit} menit dan hanya dapat digunakan satu kali.")
            ->line('Jika Anda tidak merasa meminta reset password, abaikan email ini. Password Anda tidak akan berubah.')
            ->salutation('Salam, Bakorwil III Malang');
    }
}
