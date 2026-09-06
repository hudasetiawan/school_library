<?php

namespace App\Http\Controllers\Testing;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * GtmetrixBypassController
 *
 * Controller khusus untuk pengujian performa ISO/IEC 25010:2023 menggunakan
 * GTmetrix dan Lighthouse. Setiap method publik merepresentasikan satu halaman
 * yang akan diuji, sehingga URL lebih bersih dan eksplisit.
 *
 * Flow:
 * 1. Crawler mengakses URL /gtmetrix/{halaman}
 * 2. Method memanggil helper loginAsRoleAndRedirect()
 * 3. Helper mencari user pertama dari DB berdasarkan role (dinamis, tanpa hardcode email)
 * 4. Auth::login() dilakukan secara programmatic
 * 5. Redirect ke route controller asli — query DB & rendering tetap terukur valid
 *
 * KEAMANAN:
 * - Route hanya terdaftar jika env('GTMETRIX_TESTING') === true
 * - Tanpa flag tersebut, route TIDAK ADA di routing table
 */
class GtmetrixBypassController extends Controller
{
    /**
     * Halaman Login — bersihkan session lalu redirect ke form login.
     *
     * Memastikan crawler mendapatkan halaman login dalam kondisi
     * fresh (tidak ada sesi aktif yang mengganggu pengukuran).
     */
    public function login(): RedirectResponse
    {
        // Bersihkan session secara total jika ada sesi aktif
        if (Auth::check()) {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
        }

        return redirect()->route('login');
    }

    /**
     * Dashboard Utama — auto-login sebagai Admin, redirect ke dashboard.
     *
     * Dashboard menampilkan statistik, grafik tren peminjaman,
     * dan antrian pengajuan buku (query-heavy page).
     */
    public function dashboard(): RedirectResponse
    {
        return $this->loginAsRoleAndRedirect('admin', 'dashboard');
    }

    /**
     * Katalog Buku (OPAC) — auto-login sebagai User/Siswa, redirect ke katalog.
     *
     * Halaman katalog menampilkan daftar buku dengan search, filter kategori,
     * dan paginasi (Eloquent + Eager Loading).
     */
    public function katalog(): RedirectResponse
    {
        return $this->loginAsRoleAndRedirect('user', 'books.index');
    }

    /**
     * Kelola Buku (Admin) — auto-login sebagai Admin, redirect ke manajemen buku.
     *
     * Halaman admin untuk CRUD buku perpustakaan dengan gambar sampul.
     */
    public function kelolaBuku(): RedirectResponse
    {
        return $this->loginAsRoleAndRedirect('admin', 'admin.books.index');
    }

    /**
     * Manajemen Peminjaman — auto-login sebagai Admin, redirect ke halaman sirkulasi.
     *
     * Halaman menampilkan seluruh data peminjaman dengan filter status,
     * kelas, dan search (query kompleks dengan relasi).
     */
    public function peminjaman(): RedirectResponse
    {
        return $this->loginAsRoleAndRedirect('admin', 'admin.borrowings.index');
    }

    /**
     * Manajemen Anggota — auto-login sebagai Admin, redirect ke halaman kelola user.
     *
     * Halaman menampilkan daftar seluruh anggota perpustakaan
     * dengan filter role, kelas, status, dan fitur pencarian.
     */
    public function anggota(): RedirectResponse
    {
        return $this->loginAsRoleAndRedirect('admin', 'admin.users.index');
    }

    /**
     * Helper: Login secara programmatic berdasarkan role, lalu redirect.
     *
     * Menggunakan Eloquent untuk mencari user PERTAMA yang memiliki role
     * sesuai parameter. Tidak ada hardcode email — sepenuhnya dinamis.
     *
     * @param  string  $role       Role user yang akan di-login-kan ('admin' atau 'user')
     * @param  string  $routeName  Nama route Laravel tujuan redirect
     * @return RedirectResponse
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *         Jika tidak ada user dengan role tersebut di database
     */
    private function loginAsRoleAndRedirect(string $role, string $routeName): RedirectResponse
    {
        $user = User::where('role', $role)->firstOrFail();

        Auth::login($user);

        return redirect()->route($routeName);
    }
}
