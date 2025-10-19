<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('app:delete-old-task', function () {
    $this->info('Lệnh đã được chạy!');
})->describe('Command to delete old tasks.');
