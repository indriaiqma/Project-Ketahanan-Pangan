<?php

namespace App\Support;

/** Status konfigurasi pengiriman email aplikasi. */
class Surel
{
    /**
     * Email siap dipakai bila SMTP sudah diisi dengan server sungguhan
     * (bukan nilai bawaan Laravel/Mailpit) dan alamat pengirim sudah diatur.
     */
    public static function siap(): bool
    {
        $mailer = config('mail.default');
        if (in_array($mailer, ['log', 'array'], true)) {
            return false;
        }
        if ($mailer === 'smtp') {
            $host = (string) config('mail.mailers.smtp.host');
            if ($host === '' || in_array($host, ['mailpit', 'localhost', '127.0.0.1', 'smtp.mailgun.org'], true)) {
                return false;
            }
            // Username & password SMTP (mis. App Password Gmail) wajib terisi
            if (! config('mail.mailers.smtp.username') || ! config('mail.mailers.smtp.password')) {
                return false;
            }
        }

        $dari = (string) config('mail.from.address');

        return $dari !== '' && ! str_ends_with($dari, '@example.com');
    }
}
