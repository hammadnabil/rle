<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User; // Sesuaikan namespace model User Anda

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // User dengan jabatan = tata usaha
        User::create([
            'name' => 'Tata Usaha',
            'email' => 'tatausaha@gmail.com',
            'no_wa' => '081234567890',
            'umur' => 25,
            'tanggal_bergabung' => now()->subYears(2),
            'gender' => 'L',
            'password' => Hash::make('tatausaha'), // Ganti sesuai kebutuhan
            'jabatan' => 'tata usaha',
            'remember_token' => Str::random(10),
            'fonnte_token' => 'XMadsHrbVhi2bSKcLHE4',
        ]);

        // User dengan jabatan = pegawai
        User::create([
            'name' => 'Pegawai Biasa',
            'email' => 'pegawai@example.com',
            'no_wa' => '085172142148',
            'umur' => 28,
            'tanggal_bergabung' => now()->subYear(),
            'gender' => 'P',
            'password' => Hash::make('password'), // Ganti sesuai kebutuhan
            'jabatan' => 'pegawai',
            'remember_token' => Str::random(10),
            'fonnte_token' => null,
        ]);
    }
}
