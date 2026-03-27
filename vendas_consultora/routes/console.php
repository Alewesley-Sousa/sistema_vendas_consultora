<?php

use App\Models\catalogos;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    catalogos::expirados()->update(['status_id' => '2']);
})->daily(); // Roda todo dia à meia-noite