<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nomor_induk' => ['required', 'string', 'max:20', 'unique:users,nomor_induk'],
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'kelas'       => ['required', 'string', 'max:20'],
            'password'    => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'nomor_induk.required' => 'Nomor Induk Siswa (NIS) wajib diisi.',
            'nomor_induk.unique'   => 'Nomor Induk sudah terdaftar di sistem.',
            'nomor_induk.max'      => 'Nomor Induk maksimal 20 karakter.',
            'name.required'        => 'Nama lengkap wajib diisi.',
            'email.required'       => 'Alamat email wajib diisi.',
            'email.unique'         => 'Email sudah terdaftar di sistem.',
            'kelas.required'       => 'Kelas wajib dipilih.',
            'password.required'    => 'Password wajib diisi.',
            'password.confirmed'   => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'nomor_induk' => $request->nomor_induk,
            'name'        => $request->name,
            'email'       => $request->email,
            'kelas'       => $request->kelas,
            'role'        => 'user',
            'status'      => 'pending', // Akun menunggu persetujuan admin
            'password'    => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Jangan login otomatis — redirect ke halaman login dengan pesan
        return redirect()->route('login')->with('status', 'Pendaftaran berhasil! Akun Anda sedang menunggu persetujuan dari Admin. Anda belum bisa login.');
    }
}
