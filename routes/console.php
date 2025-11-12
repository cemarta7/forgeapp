<?php

use App\Models\Log;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use KnotsPHP\PublicIP\Finders\PublicIPv4;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('get:public-ip', function () {
    $ip_address = PublicIPv4::get();

    Log::create([
        'message' => 'Obtained public IP address',
        'ip_address' => $ip_address,
        'server_name' => gethostname(),
    ]);
});

Schedule::command('get:public-ip')->onOneServer()->withoutOverlapping()->everyMinute();
