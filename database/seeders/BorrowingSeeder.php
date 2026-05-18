<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Database\Seeder;

class BorrowingSeeder extends Seeder
{
    /**
     * Seed sample borrowing data untuk testing.
     * Mencakup berbagai status: pending, disetujui, dikembalikan, ditolak.
     * Menggunakan data buku riil perpustakaan SMKN 2 Magelang.
     */
    public function run(): void
    {
        $students = User::where('role', 'user')->get();
        $books = Book::all()->keyBy('kode_buku');

        if ($students->isEmpty() || $books->isEmpty()) {
            return;
        }

        // 1. Peminjaman PENDING — Ahmad (XII PPLG 1) ajukan buku Pemrograman Web
        Borrowing::create([
            'user_id'             => $students[0]->id, // Ahmad
            'book_id'             => $books['2156']->id, // Pemrograman Web SMK/MAK
            'tanggal_pinjam'      => now(),
            'tanggal_jatuh_tempo' => now()->addDays(7),
            'status'              => 'pending',
        ]);

        // 2. Peminjaman PENDING — Siti (XI AKL 2) ajukan buku Atomic Habits
        Borrowing::create([
            'user_id'             => $students[1]->id, // Siti
            'book_id'             => $books['2451']->id, // Atomic Habits
            'tanggal_pinjam'      => now(),
            'tanggal_jatuh_tempo' => now()->addDays(10),
            'status'              => 'pending',
        ]);

        // 3. Peminjaman DISETUJUI — Budi (X MPLB 1) pinjam buku Komputer Akuntansi
        $bookAkuntansi = $books['4721']; // Komputer Akuntansi Accurate
        Borrowing::create([
            'user_id'             => $students[2]->id, // Budi
            'book_id'             => $bookAkuntansi->id,
            'tanggal_pinjam'      => now()->subDays(3),
            'tanggal_jatuh_tempo' => now()->addDays(4),
            'status'              => 'disetujui',
        ]);
        $bookAkuntansi->decrement('stok_tersedia'); // Stok berkurang karena sudah disetujui

        // 4. Peminjaman DISETUJUI (terlambat) — Ahmad pinjam buku Basis Data
        $bookBasisData = $books['1298']; // Basis Data SMK/MAK
        Borrowing::create([
            'user_id'             => $students[0]->id, // Ahmad
            'book_id'             => $bookBasisData->id,
            'tanggal_pinjam'      => now()->subDays(14),
            'tanggal_jatuh_tempo' => now()->subDays(2), // Sudah lewat jatuh tempo
            'status'              => 'disetujui',
        ]);
        $bookBasisData->decrement('stok_tersedia');

        // 5. Peminjaman DIKEMBALIKAN — Dewi (XII PM 1) sudah kembalikan buku Pulang-Pergi
        Borrowing::create([
            'user_id'             => $students[3]->id, // Dewi
            'book_id'             => $books['4109']->id, // Pulang-Pergi (Tere Liye)
            'tanggal_pinjam'      => now()->subDays(10),
            'tanggal_jatuh_tempo' => now()->subDays(3),
            'tanggal_kembali'     => now()->subDays(1), // Terlambat 2 hari
            'status'              => 'dikembalikan',
            'denda'               => 2000, // Rp 1.000 x 2 hari
        ]);

        // 6. Peminjaman DIKEMBALIKAN (tepat waktu) — Rizky (XI PPLG 2)
        Borrowing::create([
            'user_id'             => $students[4]->id, // Rizky
            'book_id'             => $books['3914']->id, // PBO SMK/MAK Kelas XI
            'tanggal_pinjam'      => now()->subDays(12),
            'tanggal_jatuh_tempo' => now()->subDays(5),
            'tanggal_kembali'     => now()->subDays(6), // Tepat waktu
            'status'              => 'dikembalikan',
            'denda'               => 0,
        ]);

        // 7. Peminjaman DITOLAK — Budi ajukan buku Digital Branding tapi ditolak
        Borrowing::create([
            'user_id'             => $students[2]->id, // Budi
            'book_id'             => $books['9087']->id, // Digital Branding
            'tanggal_pinjam'      => now()->subDays(5),
            'tanggal_jatuh_tempo' => now()->addDays(2),
            'status'              => 'ditolak',
        ]);
    }
}
