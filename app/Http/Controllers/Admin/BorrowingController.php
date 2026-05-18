<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\User;
use App\Services\BorrowingService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BorrowingController extends Controller
{
    public function __construct(protected BorrowingService $borrowingService)
    {
    }

    /**
     * Display a listing of all borrowings with search & filter.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $kelas  = $request->input('kelas');
        $perPage = (int) $request->input('per_page', 10);

        $borrowings = $this->borrowingService->getAllBorrowings($search, $status, $kelas, $perPage);

        // Ambil daftar kelas unik untuk dropdown filter
        $kelasList = User::whereNotNull('kelas')
            ->where('role', 'user')
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas');

        return view('admin.borrowings.index', compact(
            'borrowings', 'search', 'status', 'kelas', 'kelasList', 'perPage'
        ));
    }

    /**
     * Admin menyetujui peminjaman (pending → disetujui).
     */
    public function approve(Borrowing $borrowing): RedirectResponse
    {
        try {
            $this->borrowingService->approveBorrowing($borrowing);
            return redirect()->back()->with('success', 'Peminjaman berhasil disetujui.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Admin menolak peminjaman (pending → ditolak).
     */
    public function reject(Borrowing $borrowing): RedirectResponse
    {
        try {
            $this->borrowingService->rejectBorrowing($borrowing);
            return redirect()->back()->with('success', 'Peminjaman berhasil ditolak.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Admin memproses pengembalian (disetujui → dikembalikan).
     */
    public function returnBook(Borrowing $borrowing): RedirectResponse
    {
        try {
            $this->borrowingService->returnBook($borrowing);
            return redirect()->back()->with('success', 'Buku berhasil dikembalikan.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
