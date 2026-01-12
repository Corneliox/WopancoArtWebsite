<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Schedule;
use App\Models\User;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('What doesn\'t kill you makes you stronger. Remember that!! GodBless!');

Schedule::call(function () {
    User::whereNull('email_verified_at')
        ->where('created_at', '<', now()->subHours(48))
        ->delete();
})->daily();