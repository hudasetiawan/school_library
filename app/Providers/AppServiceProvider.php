<?php

namespace App\Providers;

use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;

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
        $this->configureMailInterceptor();
    }

    /**
     * Konfigurasi global mail interceptor untuk lingkungan staging/testing.
     *
     * Jika variabel MAIL_TEST_RECIPIENT diisi dan aplikasi BUKAN di environment
     * production, maka SEMUA email keluar akan dialihkan ke alamat tersebut.
     * Ini mencegah pengiriman email ke alamat asli siswa saat pengujian.
     */
    private function configureMailInterceptor(): void
    {
        $testRecipient = config('mail.test_recipient');

        if (!app()->environment('production') && !empty($testRecipient)) {
            Mail::alwaysTo($testRecipient);
        }
    }
}
