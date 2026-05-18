<x-app-layout>
    <x-slot name="title">Kelola Pengguna</x-slot>

    <div class="space-y-6">
        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-foreground tracking-tight">Kelola Pengguna</h1>
                <p class="text-sm text-muted-foreground mt-1">Daftar seluruh pengguna sistem perpustakaan.</p>
            </div>
            <a href="{{ route('admin.users.create') }}"
                class="inline-flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-primary/90 transition-colors shadow-sm self-start">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Pengguna
            </a>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="bg-primary/10 border border-primary/20 text-primary px-5 py-3.5 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
        @endif
        @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="bg-red-50 border border-red-200 text-red-800 px-5 py-3.5 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            <span class="text-sm font-medium">{{ session('error') }}</span>
        </div>
        @endif

        {{-- Search & Filter --}}
        <div class="bg-card rounded-2xl border border-border shadow-sm p-5">
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col lg:flex-row gap-3">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama, NIS, atau email..."
                        class="w-full pl-10 pr-4 py-2.5 border border-border rounded-xl text-sm focus:ring-2 focus:ring-ring/20 focus:border-ring focus:bg-card transition-all placeholder:text-muted-foreground">
                </div>

                <div class="sm:w-40">
                    <select name="role" class="w-full py-2.5 px-3.5 bg-card text-foreground border border-border rounded-xl text-sm transition-colors duration-200 cursor-pointer hover:bg-secondary/50 focus:bg-secondary focus:ring-2 focus:ring-ring/20 focus:border-ring appearance-none"
                        style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpath d=%27M6 9l6 6 6-6%27/%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;">
                        <option value="" class="bg-card text-foreground">Semua Role</option>
                        <option value="admin" class="bg-card text-foreground" {{ ($role ?? '') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" class="bg-card text-foreground" {{ ($role ?? '') === 'user' ? 'selected' : '' }}>Siswa</option>
                    </select>
                </div>

                <div class="sm:w-40">
                    <select name="status" class="w-full py-2.5 px-3.5 bg-card text-foreground border border-border rounded-xl text-sm transition-colors duration-200 cursor-pointer hover:bg-secondary/50 focus:bg-secondary focus:ring-2 focus:ring-ring/20 focus:border-ring appearance-none"
                        style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpath d=%27M6 9l6 6 6-6%27/%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;">
                        <option value="" class="bg-card text-foreground">Semua Status</option>
                        <option value="pending" class="bg-card text-foreground" {{ ($status ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" class="bg-card text-foreground" {{ ($status ?? '') === 'approved' ? 'selected' : '' }}>Approved</option>
                    </select>
                </div>

                <div class="sm:w-44">
                    <select name="kelas" class="w-full py-2.5 px-3.5 bg-card text-foreground border border-border rounded-xl text-sm transition-colors duration-200 cursor-pointer hover:bg-secondary/50 focus:bg-secondary focus:ring-2 focus:ring-ring/20 focus:border-ring appearance-none"
                        style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpath d=%27M6 9l6 6 6-6%27/%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;">
                        <option value="" class="bg-card text-foreground">Semua Kelas</option>
                        @foreach($kelasList as $k)
                        <option value="{{ $k }}" class="bg-card text-foreground" {{ ($kelas ?? '') === $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="cursor-pointer inline-flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-primary/90 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'role', 'kelas', 'status']))
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-1.5 bg-muted text-muted-foreground px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-muted transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Result Info --}}
        @if($search || $role || $kelas || $status)
            <div class="flex items-center gap-2 text-sm text-muted-foreground">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Menampilkan <strong class="text-foreground">{{ $users->total() }}</strong> hasil
                    @if($search) untuk "<strong class="text-foreground">{{ $search }}</strong>"@endif
                    @if($role) dengan role <strong class="text-foreground">{{ ucfirst($role) }}</strong>@endif
                    @if($status) status <strong class="text-foreground">{{ ucfirst($status) }}</strong>@endif
                    @if($kelas) kelas <strong class="text-foreground">{{ $kelas }}</strong>@endif
                </span>
            </div>
        @endif

        {{-- Users Table --}}
        <div class="bg-card rounded-2xl border border-border shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-border">
                    <thead>
                        <tr class="bg-muted">
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wider">Pengguna</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wider">NIS/NIP</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wider hidden md:table-cell">Email</th>
                            <th class="px-6 py-3.5 text-center text-xs font-semibold text-muted-foreground uppercase tracking-wider">Kelas</th>
                            <th class="px-6 py-3.5 text-center text-xs font-semibold text-muted-foreground uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3.5 text-center text-xs font-semibold text-muted-foreground uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3.5 text-right text-xs font-semibold text-muted-foreground uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border/50">
                        @forelse($users as $user)
                        <tr class="hover:bg-muted/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background={{ $user->isAdmin() ? 'd1fae5' : 'e0e7ff' }}&color={{ $user->isAdmin() ? '059669' : '4f46e5' }}&size=36&font-size=0.4&bold=true"
                                        alt="Avatar" class="w-9 h-9 rounded-full flex-shrink-0">
                                    <p class="text-sm font-semibold text-foreground">{{ $user->name }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-muted-foreground font-mono">{{ $user->nomor_induk }}</span>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                <span class="text-sm text-muted-foreground">{{ $user->email }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($user->kelas)
                                <span class="text-[10px] font-bold text-primary bg-primary/10 px-2 py-1 rounded-md">{{ $user->kelas }}</span>
                                @else
                                <span class="text-xs text-muted-foreground">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($user->isAdmin())
                                <span class="inline-flex items-center gap-1 bg-purple-50 text-purple-700 text-xs font-semibold px-2.5 py-1 rounded-lg border border-purple-200/50">
                                    <span class="w-1.5 h-1.5 bg-purple-500 rounded-full"></span> Admin
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 text-xs font-semibold px-2.5 py-1 rounded-lg border border-blue-200/50">
                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span> Siswa
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($user->status === 'approved')
                                <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 text-xs font-semibold px-2.5 py-1 rounded-lg border border-emerald-200/50">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Approved
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 text-xs font-semibold px-2.5 py-1 rounded-lg border border-amber-200/50">
                                    <span class="w-1.5 h-1.5 bg-amber-400 rounded-full animate-pulse"></span> Pending
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    @if($user->status === 'pending' && $user->id !== auth()->id())
                                    {{-- Approve / Reject buttons for pending users --}}
                                    <x-confirm-modal
                                        :action="route('admin.users.approve', $user)"
                                        title="Setujui Pendaftaran?"
                                        message="Setujui pendaftaran <strong class='text-foreground'>{{ $user->name }}</strong>?<br><br><span class='text-xs'>Akun akan aktif dan dapat mengakses sistem perpustakaan.</span>"
                                        confirmText="Ya, Setujui"
                                        confirmColor="emerald"
                                        iconType="check">
                                        <button type="button" class="cursor-pointer inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-emerald-100 transition-colors border border-emerald-200/50">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Setujui
                                        </button>
                                    </x-confirm-modal>
                                    <x-confirm-modal
                                        :action="route('admin.users.reject', $user)"
                                        title="Tolak Pendaftaran?"
                                        message="Tolak pendaftaran <strong class='text-foreground'>{{ $user->name }}</strong>?<br><br><span class='text-xs'>Data akun akan dihapus permanen dari sistem.</span>"
                                        confirmText="Ya, Tolak"
                                        confirmColor="red"
                                        iconType="x-circle">
                                        <button type="button" class="cursor-pointer inline-flex items-center gap-1 bg-red-50 text-red-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-red-100 transition-colors border border-red-200/50">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            Tolak
                                        </button>
                                    </x-confirm-modal>
                                    @else
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-amber-100 transition-colors border border-amber-200/50">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Edit
                                    </a>
                                    @if($user->id !== auth()->id())
                                    <x-confirm-modal
                                        :action="route('admin.users.destroy', $user)"
                                        method="DELETE"
                                        title="Hapus Pengguna?"
                                        message="Hapus pengguna <strong class='text-foreground'>{{ $user->name }}</strong>?<br><br><span class='text-xs'>Data akan diarsipkan (soft delete).</span>"
                                        confirmText="Ya, Hapus"
                                        confirmColor="red"
                                        iconType="trash">
                                        <button type="button" class="cursor-pointer inline-flex items-center gap-1 bg-red-50 text-red-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-red-100 transition-colors border border-red-200/50">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Hapus
                                        </button>
                                    </x-confirm-modal>
                                    @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-muted rounded-2xl flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-foreground">
                                        @if($search || $role || $kelas || $status)
                                            Tidak ada pengguna ditemukan
                                        @else
                                            Belum ada data pengguna
                                        @endif
                                    </p>
                                    <p class="text-xs text-muted-foreground mt-1">
                                        @if($search || $role || $kelas || $status)
                                            Coba ubah kata kunci pencarian atau filter.
                                        @else
                                            Mulai tambahkan pengguna ke sistem.
                                        @endif
                                    </p>
                                    @if($search || $role || $kelas || $status)
                                        <a href="{{ route('admin.users.index') }}" class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-primary hover:text-primary/80 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            Reset Pencarian
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-border bg-muted/50">
                <x-pagination :paginator="$users" :perPage="$perPage" />
            </div>
        </div>
    </div>
</x-app-layout>