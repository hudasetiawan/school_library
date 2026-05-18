<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class BorrowingService
{
    /**
     * Get all borrowings with eager-loaded relations.
     * Supports search by student name / book title, and filter by status / kelas.
     * Uses whereHas for relational search at DB level.
     */
    public function getAllBorrowings(
        ?string $search = null,
        ?string $status = null,
        ?string $kelas = null,
        int $perPage = 10
    ): LengthAwarePaginator {
        return Borrowing::query()
            ->with(['user', 'book.category']) // Eager Loading — mencegah N+1
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    // Search by student name (relasi user)
                    $q->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    })
                    // Search by book title (relasi book)
                    ->orWhereHas('book', function ($bookQuery) use ($search) {
                        $bookQuery->where('judul', 'like', "%{$search}%");
                    });
                });
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($kelas, function ($query, $kelas) {
                $query->whereHas('user', function ($userQuery) use ($kelas) {
                    $userQuery->where('kelas', $kelas);
                });
            })
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get borrowings for a specific user (siswa).
     * Supports search by book title and filter by status.
     */
    public function getUserBorrowings(
        int $userId,
        ?string $search = null,
        ?string $status = null,
        int $perPage = 10
    ): LengthAwarePaginator {
        return Borrowing::query()
            ->with('book.category') // Eager Loading — mencegah N+1
            ->where('user_id', $userId)
            ->when($search, function ($query, $search) {
                $query->whereHas('book', function ($bookQuery) use ($search) {
                    $bookQuery->where('judul', 'like', "%{$search}%")
                              ->orWhere('penulis', 'like', "%{$search}%");
                });
            })
            ->when($status, fn ($query, $status) => $query->where('status', $status))
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Siswa mengajukan peminjaman buku.
     * Status awal = 'pending', stok BELUM dikurangi.
     */
    public function requestBorrow(User $user, Book $book, string $dueDate): Borrowing
    {
        if ($book->stok_tersedia < 1) {
            throw new Exception("Buku tidak tersedia (stok kosong).");
        }

        // Cek apakah user sudah punya peminjaman aktif untuk buku yang sama
        $hasActive = Borrowing::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->whereIn('status', ['pending', 'disetujui'])
            ->exists();

        if ($hasActive) {
            throw new Exception("Anda sudah mengajukan atau sedang meminjam buku ini.");
        }

        return Borrowing::create([
            'user_id'             => $user->id,
            'book_id'             => $book->id,
            'tanggal_pinjam'      => now(),
            'tanggal_jatuh_tempo' => $dueDate,
            'status'              => 'pending',
        ]);
    }

    /**
     * Admin menyetujui peminjaman.
     * Status: pending → disetujui, stok_tersedia dikurangi 1.
     * Menggunakan DB::transaction untuk konsistensi data.
     */
    public function approveBorrowing(Borrowing $borrowing): Borrowing
    {
        if ($borrowing->status !== 'pending') {
            throw new Exception("Hanya peminjaman berstatus 'pending' yang bisa disetujui.");
        }

        $book = $borrowing->book;

        if ($book->stok_tersedia < 1) {
            throw new Exception("Stok buku '{$book->judul}' sudah habis. Tidak bisa menyetujui peminjaman.");
        }

        return DB::transaction(function () use ($borrowing, $book) {
            $book->decrement('stok_tersedia');

            $borrowing->update([
                'status'         => 'disetujui',
                'tanggal_pinjam' => now(), // Tanggal pinjam resmi saat disetujui
            ]);

            return $borrowing->fresh();
        });
    }

    /**
     * Admin menolak peminjaman.
     * Status: pending → ditolak, stok TIDAK berubah.
     */
    public function rejectBorrowing(Borrowing $borrowing): Borrowing
    {
        if ($borrowing->status !== 'pending') {
            throw new Exception("Hanya peminjaman berstatus 'pending' yang bisa ditolak.");
        }

        $borrowing->update(['status' => 'ditolak']);

        return $borrowing->fresh();
    }

    /**
     * Admin memproses pengembalian buku.
     * Status: disetujui → dikembalikan, stok_tersedia bertambah 1.
     * Menghitung denda jika terlambat.
     */
    public function returnBook(Borrowing $borrowing, ?string $catatan = null): Borrowing
    {
        if ($borrowing->status !== 'disetujui') {
            throw new Exception("Hanya peminjaman berstatus 'disetujui' yang bisa dikembalikan.");
        }

        return DB::transaction(function () use ($borrowing, $catatan) {
            $borrowing->book->increment('stok_tersedia');

            $tanggalKembali = now();
            $denda = 0;

            // Hitung denda jika terlambat (Rp 1.000/hari)
            if ($tanggalKembali->gt($borrowing->tanggal_jatuh_tempo)) {
                $hariTerlambat = (int) ceil($tanggalKembali->diffInDays($borrowing->tanggal_jatuh_tempo));
                $denda = $hariTerlambat * 1000;
            }

            $borrowing->update([
                'status'                => 'dikembalikan',
                'tanggal_kembali'       => $tanggalKembali,
                'denda'                 => $denda,
                'catatan_pengembalian'  => $catatan,
            ]);

            return $borrowing->fresh();
        });
    }

    /**
     * Mark a borrowing as lost (hilang).
     */
    public function markAsLost(Borrowing $borrowing, ?string $catatan = null): Borrowing
    {
        if (in_array($borrowing->status, ['dikembalikan', 'hilang', 'ditolak'])) {
            return $borrowing;
        }

        return DB::transaction(function () use ($borrowing, $catatan) {
            $borrowing->update([
                'status'               => 'hilang',
                'catatan_pengembalian' => $catatan ?? 'Buku dilaporkan hilang',
            ]);

            return $borrowing;
        });
    }
}
