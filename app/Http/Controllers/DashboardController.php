<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookRequest;
use App\Models\Borrowing;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            return $this->adminDashboard();
        }

        return $this->userDashboard();
    }

    /**
     * Dashboard Admin:
     * - Statistik ringkas (total user, buku, peminjaman aktif)
     * - Grafik tren peminjaman (bulanan & mingguan)
     * - Antrean pengajuan buku pending
     */
    private function adminDashboard()
    {
        // ---- Statistik Kartu ----
        $totalBooks = Book::count();
        $totalUsers = User::where('role', 'user')->count();
        $activeBorrowings = Borrowing::where('status', 'disetujui')->count();
        $pendingBorrowings = Borrowing::where('status', 'pending')->count();

        // ---- Pengajuan Buku Pending (max 5) ----
        $pendingRequests = BookRequest::with('user')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // ---- Grafik Bulanan (tahun berjalan) ----
        $currentYear = Carbon::now()->year;
        $monthlyData = Borrowing::select(
                DB::raw('MONTH(tanggal_pinjam) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('tanggal_pinjam', $currentYear)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        $monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $monthTotals = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthTotals[] = $monthlyData[$i] ?? 0;
        }

        // ---- Grafik Mingguan (7 hari terakhir) ----
        $weeklyData = Borrowing::select(
                DB::raw('DATE(tanggal_pinjam) as tanggal'),
                DB::raw('COUNT(*) as total')
            )
            ->where('tanggal_pinjam', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->pluck('total', 'tanggal')
            ->toArray();

        $weekLabels = [];
        $weekTotals = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $weekLabels[] = $date->translatedFormat('D, d M');
            $weekTotals[] = $weeklyData[$date->toDateString()] ?? 0;
        }

        return view('dashboard', compact(
            'totalBooks', 'totalUsers', 'activeBorrowings', 'pendingBorrowings',
            'pendingRequests',
            'monthLabels', 'monthTotals',
            'weekLabels', 'weekTotals'
        ));
    }

    /**
     * Dashboard User (Siswa):
     * - Statistik pribadi (sedang dipinjam, request buku)
     * - Peringatan buku mendekati jatuh tempo (<= 2 hari)
     * - Koleksi buku terbaru
     */
    private function userDashboard()
    {
        $userId = Auth::id();

        $myActiveBorrowings = Borrowing::where('user_id', $userId)
            ->whereIn('status', ['pending', 'disetujui'])
            ->count();

        // Peringatan jatuh tempo: buku yang statusnya 'disetujui' dan jatuh tempo <= 2 hari dari sekarang
        $dueSoonBorrowings = Borrowing::with('book')
            ->where('user_id', $userId)
            ->where('status', 'disetujui')
            ->where('tanggal_jatuh_tempo', '<=', Carbon::now()->addDays(2))
            ->where('tanggal_jatuh_tempo', '>=', Carbon::now()->startOfDay())
            ->get();

        // Buku yang sudah lewat jatuh tempo (overdue)
        $overdueBorrowings = Borrowing::with('book')
            ->where('user_id', $userId)
            ->where('status', 'disetujui')
            ->where('tanggal_jatuh_tempo', '<', Carbon::now()->startOfDay())
            ->get();

        // Koleksi terbaru
        $latestBooks = Book::latest()->take(5)->get();

        return view('dashboard', compact(
            'myActiveBorrowings',
            'dueSoonBorrowings',
            'overdueBorrowings',
            'latestBooks'
        ));
    }
}
