<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Jalankan perintah pengecekan pesanan setiap 1 jam (hourly)
Schedule::command('app:auto-batal-pesanan')->hourly();
