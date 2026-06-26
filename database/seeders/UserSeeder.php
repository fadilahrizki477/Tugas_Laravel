<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Mahasiswa;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Admin
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Buat akun untuk SETIAP data mahasiswa yang sudah ada
        $semuaMahasiswa = Mahasiswa::all();

        foreach ($semuaMahasiswa as $mhs) {
            User::create([
                'name'     => $mhs->nama,
                'email'    => $mhs->npm . '@gmail.com',
                'password' => Hash::make('password'),
                'role'     => 'mahasiswa',
                'npm'      => $mhs->npm,
            ]);
        }
    }
}
