<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class NotificationTestSeeder extends Seeder
{
    /**
     * Seeder khusus untuk menguji fitur notifikasi email pengingat.
     *
     * Membuat 4 data peminjaman aktif (status 'disetujui') dengan tanggal
     * jatuh tempo pada H-0, H-1, H-2, dan H-3 dari hari ini, sehingga
     * command `library:check-deadlines` akan menemukan dan mengirim notifikasi.
     *
     * CARA PAKAI:
     *   php artisan db:seed --class=NotificationTestSeeder
     *   php artisan library:check-deadlines
     */
    public function run(): void
    {
        $today = Carbon::now();

        // Ambil siswa pertama yang sudah approved sebagai target pengujian
        $student = User::where('role', 'user')
            ->where('status', 'approved')
            ->first();

        if (!$student) {
            $this->command->error('❌ Tidak ada siswa dengan status approved. Jalankan DatabaseSeeder terlebih dahulu.');
            return;
        }

        // Ambil 4 buku yang tersedia (stok > 0)
        $books = Book::where('stok_tersedia', '>', 0)->take(4)->get();

        if ($books->count() < 4) {
            $this->command->error('❌ Tidak cukup buku tersedia (minimal 4). Jalankan BookSeeder terlebih dahulu.');
            return;
        }

        $this->command->info("📧 Target siswa: {$student->name} ({$student->email})");
        $this->command->newLine();

        $scenarios = [
            ['days' => 0, 'label' => 'H-0 (Hari ini — batas akhir)'],
            ['days' => 1, 'label' => 'H-1 (Besok)'],
            ['days' => 2, 'label' => 'H-2 (Lusa)'],
            ['days' => 3, 'label' => 'H-3 (3 hari lagi)'],
        ];

        foreach ($scenarios as $index => $scenario) {
            $book = $books[$index];
            $dueDate = $today->copy()->addDays($scenario['days']);

            $borrowing = Borrowing::create([
                'user_id'             => $student->id,
                'book_id'             => $book->id,
                'tanggal_pinjam'      => $today->copy()->subDays(7),
                'tanggal_jatuh_tempo' => $dueDate,
                'status'              => 'disetujui',
            ]);

            // Kurangi stok buku
            $book->decrement('stok_tersedia');

            $this->command->line(
                "  ✅ [{$scenario['label']}] Peminjaman #{$borrowing->id} — \"{$book->judul}\" → jatuh tempo: {$dueDate->toDateString()}"
            );
        }

        $this->command->newLine();
        $this->command->info('🎉 4 data peminjaman test berhasil dibuat!');
        $this->command->newLine();
        $this->command->line('Langkah selanjutnya:');
        $this->command->line('  1. Jalankan:  php artisan library:check-deadlines');
        $this->command->line('  2. Cek log:   storage/logs/laravel.log');
        $this->command->line('  3. Jika queue aktif, jalankan: php artisan queue:work');
    }
}
