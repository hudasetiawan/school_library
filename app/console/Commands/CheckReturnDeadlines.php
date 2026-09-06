<?php

namespace App\Console\Commands;

use App\Models\Borrowing;
use App\Notifications\ReminderPengembalian;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckReturnDeadlines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'library:check-deadlines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengirim notifikasi email pengingat bertahap (H-3 s/d H-0) kepada siswa yang bukunya mendekati jatuh tempo';

    /**
     * Rentang hari pengingat: H-3, H-2, H-1, H-0 (hari jatuh tempo).
     *
     * @var array<int>
     */
    private const REMINDER_DAYS = [3, 2, 1, 0];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $today = Carbon::now();

        // Hitung tanggal-tanggal target dari rentang pengingat
        $targetDates = collect(self::REMINDER_DAYS)
            ->map(fn (int $days): string => $today->copy()->addDays($days)->toDateString());

        $this->info('🔍 Memeriksa peminjaman dengan jatuh tempo pada:');
        $targetDates->each(function (string $date, int $index): void {
            $label = match (self::REMINDER_DAYS[$index]) {
                0 => 'Hari ini (H-0)',
                1 => 'Besok (H-1)',
                2 => 'Lusa (H-2)',
                3 => '3 hari lagi (H-3)',
            };
            $this->line("   📅 {$date} — {$label}");
        });

        $this->newLine();

        // Eager load relasi 'user' dan 'book' untuk mencegah N+1 query problem
        $borrowings = Borrowing::query()
            ->with(['user', 'book'])
            ->where('status', 'disetujui')
            ->whereIn(
                \Illuminate\Support\Facades\DB::raw('DATE(tanggal_jatuh_tempo)'),
                $targetDates->toArray()
            )
            ->get();

        if ($borrowings->isEmpty()) {
            $this->info('✅ Tidak ada peminjaman yang jatuh tempo dalam rentang H-3 s/d H-0.');
            Log::info('[CheckReturnDeadlines] Tidak ada peminjaman jatuh tempo dalam rentang ' . $targetDates->first() . ' s/d ' . $targetDates->last());

            return self::SUCCESS;
        }

        $this->info("📬 Ditemukan {$borrowings->count()} peminjaman. Mengirim notifikasi...");
        $this->newLine();

        $successCount = 0;
        $failCount = 0;

        foreach ($borrowings as $borrowing) {
            try {
                $user = $borrowing->user;

                // Skip jika user sudah dihapus (soft deleted) atau tidak memiliki email
                if (!$user || empty($user->email)) {
                    $this->warn("⚠️  Peminjaman #{$borrowing->id}: User tidak ditemukan atau email kosong. Dilewati.");
                    Log::warning("[CheckReturnDeadlines] Peminjaman #{$borrowing->id} dilewati: user null atau email kosong.");
                    $failCount++;
                    continue;
                }

                // Hitung sisa hari menuju jatuh tempo (berbasis tanggal, bukan jam)
                $daysRemaining = (int) $today->copy()->startOfDay()
                    ->diffInDays($borrowing->tanggal_jatuh_tempo->copy()->startOfDay(), false);

                $user->notify(new ReminderPengembalian($borrowing, $daysRemaining));

                $dayLabel = match (true) {
                    $daysRemaining === 0 => 'HARI INI',
                    $daysRemaining === 1 => 'H-1',
                    $daysRemaining === 2 => 'H-2',
                    $daysRemaining === 3 => 'H-3',
                    default               => "H-{$daysRemaining}",
                };

                $this->line("  ✉️  [{$dayLabel}] {$user->name} ({$user->email}) → Buku: {$borrowing->book?->judul}");
                $successCount++;
            } catch (\Throwable $e) {
                $failCount++;
                $this->error("  ❌ Gagal mengirim untuk Peminjaman #{$borrowing->id}: {$e->getMessage()}");
                Log::error("[CheckReturnDeadlines] Gagal mengirim notifikasi untuk Peminjaman #{$borrowing->id}", [
                    'error'   => $e->getMessage(),
                    'user_id' => $borrowing->user_id,
                    'trace'   => $e->getTraceAsString(),
                ]);
            }
        }

        $this->newLine();
        $this->info("📊 Ringkasan: {$successCount} berhasil, {$failCount} gagal dari total {$borrowings->count()} peminjaman.");

        Log::info("[CheckReturnDeadlines] Selesai. Berhasil: {$successCount}, Gagal: {$failCount}");

        return $failCount > 0 ? self::FAILURE : self::SUCCESS;
    }
}
