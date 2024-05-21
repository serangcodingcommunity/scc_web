<?php

use Carbon\Carbon;
use App\Models\RegistrasiEvent;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    $oneHourAgo = Carbon::now()->subHour();
    $registrasiTanpaPembayaran = RegistrasiEvent::whereDoesntHave('pembayaran')->where('created_at', '<', $oneHourAgo)->get();
    foreach ($registrasiTanpaPembayaran as $registrasi) {
        $registrasi->delete();
    }
})->everySecond();
