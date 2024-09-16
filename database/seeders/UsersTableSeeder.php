<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert(
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin@123'),
                'role' => 'admin',
                'last_signed_in' => Carbon::now()->format('Y-m-d H:i:s'),
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]
        );

        DB::table('users')->insert(
            [
                'name' => 'Moderator User',
                'email' => 'moderator@example.com',
                'password' => Hash::make('moderator@123'),
                'role' => 'moderator',
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        );

        DB::table('users')->insert(
            [
                'name' => 'Sample User',
                'email' => 'user@example.com',
                'password' => Hash::make('user@123'),
                'role' => 'user',
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        );
    }
}
