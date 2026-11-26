<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menyesuaikan dengan kolom migration: id, nama, username, password, role
        User::updateOrCreate([
            'username' => 'admin@gmail.com',
        ],[
            'nama' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin', // Menggunakan 'admin' sesuai isi enum di migration kamu
        ]);
    }
}
