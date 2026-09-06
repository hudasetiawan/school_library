<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Scheduled Commands
|--------------------------------------------------------------------------
|
| Perintah terjadwal untuk background worker perpustakaan.
| Jalankan scheduler dengan: php artisan schedule:run
| Untuk produksi, pastikan cron entry berikut telah ditambahkan:
| * * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
|
*/

Schedule::command('library:check-deadlines')
    ->dailyAt('07:00')
    ->withoutOverlapping()
    ->onOneServer()
    ->appendOutputTo(storage_path('logs/check-deadlines.log'))
    ->description('Cek dan kirim pengingat pengembalian buku H-3 jatuh tempo');
