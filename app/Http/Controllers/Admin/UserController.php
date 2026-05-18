<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of users with search & filter.
     */
    public function index(Request $request): View
    {
        $search  = $request->input('search');
        $role    = $request->input('role');
        $kelas   = $request->input('kelas');
        $status  = $request->input('status');
        $perPage = (int) $request->input('per_page', 10);

        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('nomor_induk', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($role, fn ($query, $role) => $query->where('role', $role))
            ->when($kelas, fn ($query, $kelas) => $query->where('kelas', $kelas))
            ->when($status, fn ($query, $status) => $query->where('status', $status))
            ->latest()
            ->paginate($perPage);

        $kelasList = User::whereNotNull('kelas')
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas');

        return view('admin.users.index', compact('users', 'search', 'role', 'kelas', 'status', 'kelasList', 'perPage'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nomor_induk' => ['required', 'string', 'max:20', 'unique:users,nomor_induk'],
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'kelas'       => ['nullable', 'string', 'max:20'],
            'role'        => ['required', 'in:admin,user'],
            'password'    => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'nomor_induk.required' => 'Nomor Induk wajib diisi.',
            'nomor_induk.unique'   => 'Nomor Induk sudah terdaftar.',
            'email.unique'         => 'Email sudah terdaftar.',
            'password.confirmed'   => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'nomor_induk' => $validated['nomor_induk'],
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'kelas'       => $validated['kelas'],
            'role'        => $validated['role'],
            'status'      => 'approved', // Admin membuat user = langsung approved
            'password'    => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'nomor_induk' => ['required', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'kelas'       => ['nullable', 'string', 'max:20'],
            'role'        => ['required', 'in:admin,user'],
            'password'    => ['nullable', 'confirmed', Rules\Password::defaults()],
        ], [
            'nomor_induk.unique' => 'Nomor Induk sudah terdaftar.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user->nomor_induk = $validated['nomor_induk'];
        $user->name        = $validated['name'];
        $user->email       = $validated['email'];
        $user->kelas       = $validated['kelas'];
        $user->role        = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Soft delete the specified user.
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    /**
     * Approve a pending user registration.
     */
    public function approve(User $user): RedirectResponse
    {
        $user->update(['status' => 'approved']);

        return redirect()->back()->with('success', "Akun \"{$user->name}\" berhasil disetujui.");
    }

    /**
     * Reject a pending user registration (hard delete).
     */
    public function reject(User $user): RedirectResponse
    {
        $name = $user->name;
        $user->forceDelete();

        return redirect()->back()->with('success', "Pendaftaran \"{$name}\" ditolak dan data akun telah dihapus dari sistem.");
    }
}
