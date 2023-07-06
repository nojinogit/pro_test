<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $param = [
        'id' => '1',
        'name' => 'admin',
        'email' => 'admin@admin',
        'email_verified_at' => now(),
        'password' => '123456789',
        'role' => '100',
        'created_at' => now(),
    ];DB::table('users')->insert($param);

    }

}
