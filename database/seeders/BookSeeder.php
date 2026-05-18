<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Dataset riil Perpustakaan SMKN 2 Magelang (19 buku).
     * Menggunakan firstOrCreate pada Category untuk menghindari duplikasi.
     * Kolom stok_tersedia disamakan dengan total_eksemplar pada seeding pertama.
     */
    public function run(): void
    {
        // Hapus semua data buku lama agar tidak ada duplikasi
        Book::query()->delete();

        $books = [
            [
                'kode_buku'      => '4721',
                'judul'          => 'Komputer Akuntansi Accurate Online Untuk Perusahaan Jasa Dan Dagang',
                'penulis'        => 'Joko Pramono, S.Pd., M.Si.',
                'penerbit'       => 'PT. Sumber Media Kreasindo',
                'tahun_terbit'   => 2024,
                'kategori_nama'  => 'Akuntansi',
                'kode_rak'       => '1-Q',
                'isbn'           => '978-623-98595-6-5',
                'total_eksemplar' => 108,
            ],
            [
                'kode_buku'      => '8934',
                'judul'          => 'Pengelolaan Kearsipan SMK/MAK Kelas XI Fase F',
                'penulis'        => 'Sartono, S.Pd.',
                'penerbit'       => 'Penerbit ANDI',
                'tahun_terbit'   => 2023,
                'kategori_nama'  => 'Manajemen Perkantoran',
                'kode_rak'       => '2-O',
                'isbn'           => '978-623-01-3572-9',
                'total_eksemplar' => 72,
            ],
            [
                'kode_buku'      => '2156',
                'judul'          => 'Pengembangan Perangkat Lunak dan Gim: Pemrograman Web untuk Siswa SMK/MAK Fase F',
                'penulis'        => 'Agastia Dewangga Tri Hantoro, dkk.',
                'penerbit'       => 'CV. Media Karya Putra',
                'tahun_terbit'   => 2023,
                'kategori_nama'  => 'Pemrograman',
                'kode_rak'       => '7-X',
                'isbn'           => '978-623-287-349-0',
                'total_eksemplar' => 108,
            ],
            [
                'kode_buku'      => '7690',
                'judul'          => 'Komunikasi di Tempat Kerja SMK/MAK Kelas XI Fase F',
                'penulis'        => 'Sartono, S.Pd. & Handrito Alwi, S.Pd.',
                'penerbit'       => 'Penerbit ANDI',
                'tahun_terbit'   => 2023,
                'kategori_nama'  => 'Manajemen Perkantoran',
                'kode_rak'       => '2-O',
                'isbn'           => '978-623-01-3649-8',
                'total_eksemplar' => 72,
            ],
            [
                'kode_buku'      => '3412',
                'judul'          => 'Esensi Bahasa Inggris untuk SMA/MA/SMK Kelas XI (Fase F)',
                'penulis'        => 'Yuni Prihartanti & Sari Ratnaningsih',
                'penerbit'       => 'CV Mediatama',
                'tahun_terbit'   => 2023,
                'kategori_nama'  => 'Bahasa',
                'kode_rak'       => '8-20',
                'isbn'           => '978-602-488-582-3',
                'total_eksemplar' => 396,
            ],
            [
                'kode_buku'      => '9087',
                'judul'          => 'Digital Branding untuk SMK/MAK Fase F Kelas XI',
                'penulis'        => 'Dr. Devi Puspitasari M.Pd.',
                'penerbit'       => 'Penerbit Erlangga',
                'tahun_terbit'   => 2022,
                'kategori_nama'  => 'Pemasaran',
                'kode_rak'       => '4-12',
                'isbn'           => '-',
                'total_eksemplar' => 108,
            ],
            [
                'kode_buku'      => '5623',
                'judul'          => 'Bisnis Online (C3) Kelas XI',
                'penulis'        => 'Rudi Nurcahyo, S.Kom',
                'penerbit'       => 'PT. Kuantum Buku Sejahtera',
                'tahun_terbit'   => 2019,
                'kategori_nama'  => 'Pemasaran',
                'kode_rak'       => '4-12',
                'isbn'           => '978-623-7398-11-0',
                'total_eksemplar' => 36,
            ],
            [
                'kode_buku'      => '1298',
                'judul'          => 'Pengembangan Perangkat Lunak dan Gim: Basis Data untuk Siswa SMK/MAK Fase F',
                'penulis'        => 'Indah Widiningrum, dkk.',
                'penerbit'       => 'CV. Media Karya Putra',
                'tahun_terbit'   => 2023,
                'kategori_nama'  => 'Pemrograman',
                'kode_rak'       => '7-X',
                'isbn'           => '978-623-287-348-3',
                'total_eksemplar' => 72,
            ],
            [
                'kode_buku'      => '6745',
                'judul'          => 'Bahasa Indonesia SMA/MA/SMK/MAK Kelas XI',
                'penulis'        => 'Suherli, dkk.',
                'penerbit'       => 'Kementerian Pendidikan dan Kebudayaan',
                'tahun_terbit'   => 2017,
                'kategori_nama'  => 'Bahasa',
                'kode_rak'       => '8-20',
                'isbn'           => '978-602-427-100-8',
                'total_eksemplar' => 396,
            ],
            [
                'kode_buku'      => '8319',
                'judul'          => 'Projek Kreatif dan Kewirausahaan Akuntansi dan Keuangan Lembaga SMK/MAK Kelas XI',
                'penulis'        => 'Muh. Nur Eli Brahim, M.Si.',
                'penerbit'       => 'Penerbit ANDI',
                'tahun_terbit'   => 2023,
                'kategori_nama'  => 'Akuntansi',
                'kode_rak'       => '1-Q',
                'isbn'           => '978-623-01-3299-5',
                'total_eksemplar' => 72,
            ],
            [
                'kode_buku'      => '4109',
                'judul'          => 'Pulang-Pergi',
                'penulis'        => 'Tere Liye',
                'penerbit'       => 'PT Sabak Grip Nusantara',
                'tahun_terbit'   => 2025,
                'kategori_nama'  => 'Fiksi',
                'kode_rak'       => '5-F',
                'isbn'           => '978-623-95545-2-1',
                'total_eksemplar' => 5,
            ],
            [
                'kode_buku'      => '3149',
                'judul'          => 'The Master Book of Soekarno',
                'penulis'        => 'The Syaeful Cahyadi',
                'penerbit'       => 'Roemah Soekarno',
                'tahun_terbit'   => 2021,
                'kategori_nama'  => 'Sejarah',
                'kode_rak'       => '9-S',
                'isbn'           => '9786025907081',
                'total_eksemplar' => 3,
            ],
            [
                'kode_buku'      => '4070',
                'judul'          => 'Kerajaan Islam Nusantara',
                'penulis'        => 'Ahmad Asnawi',
                'penerbit'       => 'Alexander Books',
                'tahun_terbit'   => 2019,
                'kategori_nama'  => 'Agama',
                'kode_rak'       => '2-A',
                'isbn'           => '9786025740039',
                'total_eksemplar' => 3,
            ],
            [
                'kode_buku'      => '7410',
                'judul'          => 'Kamus Besar Bahasa Prancis',
                'penulis'        => 'Frank Lefort',
                'penerbit'       => 'Pustaka Baru Press',
                'tahun_terbit'   => 2022,
                'kategori_nama'  => 'Bahasa',
                'kode_rak'       => '8-20',
                'isbn'           => '9786020874678',
                'total_eksemplar' => 3,
            ],
            [
                'kode_buku'      => '6446',
                'judul'          => 'Gagal Bukan Berarti Sia-Sia',
                'penulis'        => 'Teo Sultan',
                'penerbit'       => 'Trans Idea Publishing',
                'tahun_terbit'   => 2020,
                'kategori_nama'  => 'Psikologi',
                'kode_rak'       => '1-P',
                'isbn'           => '978-602-0808-3',
                'total_eksemplar' => 4,
            ],
            [
                'kode_buku'      => '1845',
                'judul'          => 'Matematika untuk SMA/SMK Kelas XI',
                'penulis'        => 'Dicky Susanto, dkk.',
                'penerbit'       => 'Pusat Kurikulum dan Perbukuan, Kemendikbudristek',
                'tahun_terbit'   => 2021,
                'kategori_nama'  => 'Matematika',
                'kode_rak'       => '3-M',
                'isbn'           => '978-602-244-536-4',
                'total_eksemplar' => 396,
            ],
            [
                'kode_buku'      => '3914',
                'judul'          => 'Pemrograman Berorientasi Objek SMK/MAK Kelas XI',
                'penulis'        => 'Patwiyanto, S.Kom., dkk.',
                'penerbit'       => 'Penerbit ANDI',
                'tahun_terbit'   => 2017,
                'kategori_nama'  => 'Pemrograman',
                'kode_rak'       => '7-X',
                'isbn'           => '978-979-29-6951-1',
                'total_eksemplar' => 36,
            ],
            [
                'kode_buku'      => '8172',
                'judul'          => 'Rudy: Kisah Masa Muda Sang Visioner (Biografi B.J. Habibie)',
                'penulis'        => 'Gina S. Noer',
                'penerbit'       => 'Bentang Pustaka',
                'tahun_terbit'   => 2015,
                'kategori_nama'  => 'Biografi',
                'kode_rak'       => '9-B',
                'isbn'           => '978-602-291-111-1',
                'total_eksemplar' => 4,
            ],
            [
                'kode_buku'      => '2451',
                'judul'          => 'Atomic Habits: Perubahan Kecil yang Memberikan Hasil Luar Biasa',
                'penulis'        => 'James Clear',
                'penerbit'       => 'Gramedia Pustaka Utama',
                'tahun_terbit'   => 2019,
                'kategori_nama'  => 'Pengembangan Diri',
                'kode_rak'       => '1-S',
                'isbn'           => '978-602-06-3317-6',
                'total_eksemplar' => 6,
            ],
        ];

        foreach ($books as $bookData) {
            // Ambil category_id dari nama kategori menggunakan firstOrCreate
            $category = Category::firstOrCreate(
                ['nama_kategori' => $bookData['kategori_nama']],
            );

            Book::create([
                'kode_buku'       => $bookData['kode_buku'],
                'judul'           => $bookData['judul'],
                'penulis'         => $bookData['penulis'],
                'penerbit'        => $bookData['penerbit'],
                'tahun_terbit'    => $bookData['tahun_terbit'],
                'category_id'    => $category->id,
                'kode_rak'        => $bookData['kode_rak'],
                'isbn'            => $bookData['isbn'],
                'total_eksemplar' => $bookData['total_eksemplar'],
                'stok_tersedia'   => $bookData['total_eksemplar'], // Stok = total pada seeding pertama
            ]);
        }
    }
}
