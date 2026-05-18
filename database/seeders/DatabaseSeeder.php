<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // =============================================
        // ADMIN (Petugas Perpustakaan)
        // =============================================
        User::create([
            'nomor_induk' => 'NIP001',
            'name'        => 'Admin Perpustakaan',
            'email'       => 'admin@example.com',
            'password'    => bcrypt('password'),
            'role'        => 'admin',
            'status'      => 'approved',
            'kelas'       => null,
        ]);

        // =============================================
        // SISWA — Status: APPROVED (sudah diverifikasi)
        // =============================================
        User::create([
            'nomor_induk' => '24010001',
            'name'        => 'Ahmad Fauzi',
            'email'       => 'ahmad@example.com',
            'password'    => bcrypt('password'),
            'role'        => 'user',
            'status'      => 'approved',
            'kelas'       => 'XII PPLG 1',
        ]);

        User::create([
            'nomor_induk' => '24010002',
            'name'        => 'Siti Nurhaliza',
            'email'       => 'siti@example.com',
            'password'    => bcrypt('password'),
            'role'        => 'user',
            'status'      => 'approved',
            'kelas'       => 'XI AKL 2',
        ]);

        User::create([
            'nomor_induk' => '24010003',
            'name'        => 'Budi Santoso',
            'email'       => 'budi@example.com',
            'password'    => bcrypt('password'),
            'role'        => 'user',
            'status'      => 'approved',
            'kelas'       => 'X MPLB 1',
        ]);

        User::create([
            'nomor_induk' => '24010004',
            'name'        => 'Dewi Lestari',
            'email'       => 'dewi@example.com',
            'password'    => bcrypt('password'),
            'role'        => 'user',
            'status'      => 'approved',
            'kelas'       => 'XII PM 1',
        ]);

        User::create([
            'nomor_induk' => '24010005',
            'name'        => 'Rizky Pratama',
            'email'       => 'rizky@example.com',
            'password'    => bcrypt('password'),
            'role'        => 'user',
            'status'      => 'approved',
            'kelas'       => 'XI PPLG 2',
        ]);

        User::create([
            'nomor_induk' => '24010006',
            'name'        => 'Nadia Putri Ramadhani',
            'email'       => 'nadia@example.com',
            'password'    => bcrypt('password'),
            'role'        => 'user',
            'status'      => 'approved',
            'kelas'       => 'XII AKL 1',
        ]);

        User::create([
            'nomor_induk' => '24010007',
            'name'        => 'Fajar Dwi Nugroho',
            'email'       => 'fajar@example.com',
            'password'    => bcrypt('password'),
            'role'        => 'user',
            'status'      => 'approved',
            'kelas'       => 'XI PM 2',
        ]);

        User::create([
            'nomor_induk' => '24010008',
            'name'        => 'Anisa Fitri Handayani',
            'email'       => 'anisa@example.com',
            'password'    => bcrypt('password'),
            'role'        => 'user',
            'status'      => 'approved',
            'kelas'       => 'X PPLG 1',
        ]);

        User::create([
            'nomor_induk' => '24010009',
            'name'        => 'Galih Setiawan',
            'email'       => 'galih@example.com',
            'password'    => bcrypt('password'),
            'role'        => 'user',
            'status'      => 'pending',
            'kelas'       => 'X AKL 1',
        ]);

        User::create([
            'nomor_induk' => '24010010',
            'name'        => 'Ratna Sari Dewi',
            'email'       => 'ratna@example.com',
            'password'    => bcrypt('password'),
            'role'        => 'user',
            'status'      => 'pending',
            'kelas'       => 'X PM 1',
        ]);

        User::create([
            'nomor_induk' => '24010011',
            'name'        => 'Muhammad Iqbal',
            'email'       => 'iqbal@example.com',
            'password'    => bcrypt('password'),
            'role'        => 'user',
            'status'      => 'pending',
            'kelas'       => 'XI MPLB 1',
        ]);

        User::create([
            'nomor_induk' => '24010012',
            'name'        => 'Putri Ayu Wulandari',
            'email'       => 'putri@example.com',
            'password'    => bcrypt('password'),
            'role'        => 'user',
            'status'      => 'pending',
            'kelas'       => 'X PPLG 2',
        ]);

        // =============================================
        // Panggil Seeder lainnya
        // =============================================
        $this->call([
            CategorySeeder::class,
            BookSeeder::class,
            BorrowingSeeder::class,
        ]);
    }
}
