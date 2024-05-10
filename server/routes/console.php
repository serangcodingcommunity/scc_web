<?php

use Carbon\Carbon;
use App\Models\RegistrasiEvent;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    $oneMinuteAgo = Carbon::now()->subMinute();
    $registrasiTanpaPembayaran = RegistrasiEvent::whereDoesntHave('pembayaran')->where('created_at', '<', $oneMinuteAgo)->get();
    foreach ($registrasiTanpaPembayaran as $registrasi) {
        $registrasi->delete();
    }
})->everySecond();
