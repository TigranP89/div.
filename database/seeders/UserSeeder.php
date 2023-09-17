<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $data = [];



      $cPassword = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
      $data[] = [
          'name' => 'Admin',
          'email' => 'admin@admin.com',
          'email_verified_at' => now(),
          'password' => $cPassword,
          'isAdmin' => 1,
          'remember_token' => Str::random(10),
      ];

      DB::table('users')->insert($data);
    }
}
