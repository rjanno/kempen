<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('user:reset-anno-password', function () {
    $updated = \App\Models\User::where('email', 'anno@pb.com')->update([
        'password' => \Illuminate\Support\Facades\Hash::make('Diluc214!')
    ]);

    if (!$updated) {
        $updated = \App\Models\User::where('email', 'anno@admin.com')->update([
            'email' => 'anno@pb.com',
            'password' => \Illuminate\Support\Facades\Hash::make('Diluc214!')
        ]);
    }

    if ($updated) {
        $this->info("Password user anno@pb.com berhasil diperbarui menjadi: Diluc214!");
    } else {
        $this->error("User anno@pb.com tidak ditemukan di database.");
    }
})->purpose('Update password for anno@pb.com to Diluc214!');
