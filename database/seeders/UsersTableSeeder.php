<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'testuser1',
            'user_id' => 'testuser1_id',
            'email' => 'testuser1@gmail.com',
            // 'password' => bcrypt('secret'),
            'password' => password_hash('secret', PASSWORD_DEFAULT), // 'secret'を、PASSWORD_DEFAULTアルゴリズムでハッシュ化
        ]);
    }
}
