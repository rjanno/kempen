<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('users')->where('email', 'anno@pb.com')->update([
            'password' => Hash::make('Diluc214!')
        ]);

        // In case the email in DB was anno@admin.com
        DB::table('users')->where('email', 'anno@admin.com')->update([
            'email' => 'anno@pb.com',
            'password' => Hash::make('Diluc214!')
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->where('email', 'anno@pb.com')->update([
            'password' => Hash::make('admin123')
        ]);
    }
};
