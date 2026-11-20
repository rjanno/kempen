<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'anno@pb.com'],
            [
                'name' => 'Anno',
                'password' => Hash::make('Diluc214!'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@user.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password'),
                'role' => 'user'
            ]
        );
    }
}
