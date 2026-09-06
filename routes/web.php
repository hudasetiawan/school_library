<?php

use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\BorrowingController as AdminBorrowingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\User\BookController as UserBookController;
use App\Http\Controllers\User\BorrowingController as UserBorrowingController;
use App\Http\Controllers\Testing\GtmetrixBypassController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $books = \App\Models\Book::latest()->take(4)->get();

    // Statistik dinamis untuk landing page
    // Book::sum('total_eksemplar') — total semua eksemplar buku
    $totalBuku = \App\Models\Book::sum('total_eksemplar');
    // User approved dengan role 'user' — anggota aktif
    $totalAnggota = \App\Models\User::where('role', 'user')->where('status', 'approved')->count();
    // Borrowing::count() — total seluruh transaksi peminjaman
    $totalPeminjaman = \App\Models\Borrowing::count();

    return view('welcome', compact('books', 'totalBuku', 'totalAnggota', 'totalPeminjaman'));
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('books', AdminBookController::class);
        Route::resource('users', AdminUserController::class)->except(['show']);
        Route::post('/users/{user}/approve', [AdminUserController::class, 'approve'])->name('users.approve');
        Route::post('/users/{user}/reject', [AdminUserController::class, 'reject'])->name('users.reject');
        Route::post('/users/{user}/reset-account', [AdminUserController::class, 'resetAccount'])->name('users.resetAccount');
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->only(['index', 'store', 'update', 'destroy']);

        // Borrowing management
        Route::get('/borrowings', [AdminBorrowingController::class, 'index'])->name('borrowings.index');
        Route::post('/borrowings/{borrowing}/approve', [AdminBorrowingController::class, 'approve'])->name('borrowings.approve');
        Route::post('/borrowings/{borrowing}/reject', [AdminBorrowingController::class, 'reject'])->name('borrowings.reject');
        Route::post('/borrowings/{borrowing}/return', [AdminBorrowingController::class, 'returnBook'])->name('borrowings.return');

        // Book Requests
        Route::get('/requests', [\App\Http\Controllers\Admin\BookRequestController::class, 'index'])->name('requests.index');
        Route::patch('/requests/{bookRequest}', [\App\Http\Controllers\Admin\BookRequestController::class, 'update'])->name('requests.update');

        // Menfess Routes
        Route::get('/menfess', [\App\Http\Controllers\Admin\MenfessController::class, 'index'])->name('menfess.index');
        Route::patch('/menfess/{menfess}', [\App\Http\Controllers\Admin\MenfessController::class, 'update'])->name('menfess.update');
        Route::delete('/menfess/{menfess}', [\App\Http\Controllers\Admin\MenfessController::class, 'delete'])->name('menfess.destroy');
    });

    // User Routes
    Route::get('/books', [UserBookController::class, 'index'])->name('books.index');
    Route::get('/books/{book}', [UserBookController::class, 'show'])->name('books.show');
    Route::post('/borrow', [TransactionController::class, 'borrow'])->name('borrow.store');
    Route::get('/my-borrowings', [UserBorrowingController::class, 'index'])->name('borrowings.index');

    // User Request Routes
    Route::resource('requests', \App\Http\Controllers\User\BookRequestController::class)->only(['index', 'create', 'store']);

    // Menfess Routes
    Route::get('/menfess', [\App\Http\Controllers\User\MenfessController::class, 'index'])->name('menfess.index');
    Route::post('/menfess', [\App\Http\Controllers\User\MenfessController::class, 'store'])->name('menfess.store');
    Route::post('/menfess/{menfess}/report', [\App\Http\Controllers\User\MenfessController::class, 'report'])->name('menfess.report');
});

// ================================================================
// ROUTE PENGUJIAN PERFORMA GTmetrix (ISO/IEC 25010:2023)
// Aktif HANYA jika GTMETRIX_TESTING=true di file .env
// ================================================================
if (env('GTMETRIX_TESTING') === true) {
    Route::prefix('gtmetrix')->name('gtmetrix.')->group(function () {
        Route::get('/login', [GtmetrixBypassController::class, 'login'])->name('login');
        Route::get('/dashboard', [GtmetrixBypassController::class, 'dashboard'])->name('dashboard');
        Route::get('/katalog', [GtmetrixBypassController::class, 'katalog'])->name('katalog');
        Route::get('/kelola-buku', [GtmetrixBypassController::class, 'kelolaBuku'])->name('kelola-buku');
        Route::get('/peminjaman', [GtmetrixBypassController::class, 'peminjaman'])->name('peminjaman');
        Route::get('/anggota', [GtmetrixBypassController::class, 'anggota'])->name('anggota');
    });
}

require __DIR__ . '/auth.php';
