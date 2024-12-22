<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder Prodi
        \App\Models\Prodi::updateOrCreate(
            ['id_prodi' => 'prodi1'],
            ['nama_prodi' => 'teknik Informatika']
        );

        // Seeder User
        \App\Models\User::updateOrCreate(
            ['id' => '197902242005011001'], // Kondisi unik berdasarkan kolom ID
            [
                'nama_pengguna' => 'Azwar Faridi, S.T.',
                'password' => bcrypt('password123'),
                'remember_token' => \Illuminate\Support\Str::random(10),
                'id_prodi' => 'prodi1',
            ]
        );

        // Tambahkan Seeder Lain jika diperlukan
        \App\Models\User::updateOrCreate(
            ['id' => '197902242005011002'],
            [
                'nama_pengguna' => 'User Example',
                'password' => bcrypt('example123'),
                'remember_token' => \Illuminate\Support\Str::random(10),
                'id_prodi' => 'prodi1',
            ]
        );
    }
}
