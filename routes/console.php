<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Kebijakan Retensi: Hapus otomatis percakapan chat negosiasi yang sudah mencapai kesepakatan (Deal) setelah lewat 60 hari
Schedule::command('chat:prune-old --days=60')
    ->daily()
    ->at('02:00')
    ->name('prune-expired-deal-chats');
