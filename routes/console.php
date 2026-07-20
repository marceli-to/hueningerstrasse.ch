<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Email the new registrations to the client every Monday at 08:00.
// TEMPORÄR auf 16:00 gesetzt zum Testen des Cron-Laufs — zurück auf '08:00'!
Schedule::command('registrations:export-weekly')
    ->weeklyOn(1, '16:00')
    ->timezone('Europe/Zurich');
