<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Akuntansi',
            'Manajemen Perkantoran',
            'Pemrograman',
            'Bahasa',
            'Pemasaran',
            'Fiksi',
            'Sejarah',
            'Agama',
            'Psikologi',
            'Matematika',
            'Biografi',
            'Pengembangan Diri',
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate(
                ['nama_kategori' => $name],
            );
        }
    }
}
