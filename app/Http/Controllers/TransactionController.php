<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBorrowingRequest;
use App\Models\Book;
use App\Services\BorrowingService;
use Exception;

class TransactionController extends Controller
{
    public function __construct(protected BorrowingService $borrowingService)
    {
    }

    /**
     * Siswa mengajukan peminjaman buku.
     * Status awal = 'pending', stok belum dikurangi.
     */
    public function borrow(StoreBorrowingRequest $request)
    {
        $book = Book::findOrFail($request->book_id);

        try {
            $this->borrowingService->requestBorrow(
                $request->user(),
                $book,
                $request->tanggal_jatuh_tempo
            );
            return redirect()->back()->with('success', 'Pengajuan peminjaman berhasil dikirim. Menunggu persetujuan petugas.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
