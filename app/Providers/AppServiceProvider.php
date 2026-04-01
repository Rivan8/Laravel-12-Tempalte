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
        // Share jumlah request kelas PENDING ke seluruh views (untuk badge notifikasi sidebar)
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            if (auth()->check()) {
                $user = auth()->user();
                if ($user->role === 'Admin') {
                    // Untuk Admin: total REQUEST dari semua user yang menunggu konfirmasi
                    $pendingRequestCount = \Illuminate\Support\Facades\DB::table('kelas_users')
                        ->where('status', 'requested')
                        ->count();
                    $view->with('pendingRequestCount', $pendingRequestCount);
                    $view->with('myPendingKelasCount', 0);
                } else {
                    // Untuk User biasa: jumlah kelas MEREKA SENDIRI yang menunggu konfirmasi
                    $myPendingKelasCount = \Illuminate\Support\Facades\DB::table('kelas_users')
                        ->where('user_id', $user->id)
                        ->where('status', 'requested')
                        ->count();
                    $view->with('pendingRequestCount', 0);
                    $view->with('myPendingKelasCount', $myPendingKelasCount);
                }
            } else {
                $view->with('pendingRequestCount', 0);
                $view->with('myPendingKelasCount', 0);
            }
        });

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
