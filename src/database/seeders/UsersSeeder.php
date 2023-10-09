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
        'password' => bcrypt('123456789'),
        'role' => '100',
        'created_at' => now(),
    ];DB::table('users')->insert($param);
    $param = [
        'id' => '2',
        'name' => 'aaa',
        'email' => 'aaa@aaa',
        'email_verified_at' => now(),
        'password' => bcrypt('123456789'),
        'role' => '10',
        'created_at' => now(),
    ];DB::table('users')->insert($param);
    $param = [
        'id' => '3',
        'name' => 'bbb',
        'email' => 'bbb@bbb',
        'email_verified_at' => now(),
        'password' => bcrypt('123456789'),
        'role' => '1',
        'created_at' => now(),
    ];DB::table('users')->insert($param);
    $param = [
        'id' => '4',
        'name' => 'ccc',
        'email' => 'ccc@ccc',
        'email_verified_at' => now(),
        'password' => bcrypt('123456789'),
        'role' => '1',
        'created_at' => now(),
    ];DB::table('users')->insert($param);
    $param = [
        'id' => '5',
        'name' => 'ddd',
        'email' => 'ddd@ddd',
        'email_verified_at' => now(),
        'password' => bcrypt('123456789'),
        'role' => '1',
        'created_at' => now(),
    ];DB::table('users')->insert($param);

    }

}
