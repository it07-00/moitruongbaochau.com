<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('ghg-sheets:sync --limit=20')->everyFiveMinutes()->withoutOverlapping(10);
Schedule::command('report:daily-sheet')->dailyAt('23:55')->timezone('Asia/Ho_Chi_Minh')->withoutOverlapping(10);
