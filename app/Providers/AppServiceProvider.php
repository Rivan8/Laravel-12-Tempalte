<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject('Pemberitahuan Reset Password - Elshaddai')
                ->greeting('Shalom, ' . ($notifiable->nama_lengkap ?? 'Member') . '!')
                ->line('Anda menerima email ini karena kami menerima permintaan untuk mengatur ulang (reset) kata sandi untuk akun Anda.')
                ->action('Reset Kata Sandi', $url)
                ->line('Tautan reset kata sandi ini akan kedaluwarsa dalam 60 menit.')
                ->line('Jika Anda merasa tidak pernah meminta reset kata sandi, abaikan email ini dan pastikan akun Anda tetap aman.')
                ->salutation('Tuhan Yesus Memberkati, Tim Elshaddai Learning Center');
        });
    }
}
