<x-app-layout>
    <x-slot name="title">Transaksi Peminjaman</x-slot>

    <div class="space-y-6">
        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-foreground tracking-tight">Transaksi Peminjaman</h1>
                <p class="text-sm text-muted-foreground mt-1">Kelola seluruh peminjaman buku perpustakaan.</p>
            </div>
            <div class="flex items-center gap-2 bg-card border border-border rounded-xl px-4 py-2 shadow-sm">
                <div class="w-2 h-2 bg-amber-400 rounded-full animate-pulse"></div>
                <span class="text-sm font-semibold text-muted-foreground">
                    {{ $borrowings->total() }} Total Transaksi
                </span>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="bg-primary/10 border border-primary/20 text-primary px-5 py-3.5 rounded-xl flex items-center gap-3" role="alert">
                <div class="flex-shrink-0 p-1 bg-primary/15 rounded-lg">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="bg-red-50 border border-red-200 text-red-800 px-5 py-3.5 rounded-xl flex items-center gap-3" role="alert">
                <div class="flex-shrink-0 p-1 bg-red-100 rounded-lg">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Search & Filter Bar --}}
        <div class="bg-card rounded-2xl border border-border shadow-sm p-5">
            <form action="{{ route('admin.borrowings.index') }}" method="GET" class="flex flex-col lg:flex-row gap-3">
                {{-- Search Input --}}
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           placeholder="Cari nama siswa atau judul buku..."
                           class="w-full pl-10 pr-4 py-2.5 border border-border rounded-xl text-sm focus:ring-2 focus:ring-ring/20 focus:border-ring focus:bg-card transition-all placeholder:text-muted-foreground">
                </div>

                {{-- Status Filter --}}
                <div class="sm:w-48">
                    <select name="status"
                            class="w-full py-2.5 px-3.5 bg-card text-foreground border border-border rounded-xl text-sm transition-colors duration-200 cursor-pointer hover:bg-secondary/50 focus:bg-secondary focus:ring-2 focus:ring-ring/20 focus:border-ring appearance-none"
                            style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpath d=%27M6 9l6 6 6-6%27/%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ ($status ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="disetujui" {{ ($status ?? '') === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="dikembalikan" {{ ($status ?? '') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        <option value="ditolak" {{ ($status ?? '') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                {{-- Kelas Filter --}}
                <div class="sm:w-44">
                    <select name="kelas"
                            class="w-full py-2.5 px-3.5 bg-card text-foreground border border-border rounded-xl text-sm transition-colors duration-200 cursor-pointer hover:bg-secondary/50 focus:bg-secondary focus:ring-2 focus:ring-ring/20 focus:border-ring appearance-none"
                            style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpath d=%27M6 9l6 6 6-6%27/%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k }}" {{ ($kelas ?? '') === $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-2">
                    <button type="submit"
                            class="inline-flex items-center gap-2 cursor-pointer bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-primary/90 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter
                    </button>
                    @if(request('search') || request('status') || request('kelas'))
                        <a href="{{ route('admin.borrowings.index') }}"
                           class="inline-flex items-center gap-1.5 bg-muted text-muted-foreground px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-muted transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Result Info --}}
        @if($search || $status || $kelas)
            <div class="flex items-center gap-2 text-sm text-muted-foreground">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Menampilkan <strong class="text-foreground">{{ $borrowings->total() }}</strong> hasil
                    @if($search) untuk "<strong class="text-foreground">{{ $search }}</strong>"@endif
                    @if($status) dengan status <strong class="text-foreground">{{ ucfirst($status) }}</strong>@endif
                    @if($kelas) kelas <strong class="text-foreground">{{ $kelas }}</strong>@endif
                </span>
            </div>
        @endif

        {{-- Borrowings Table --}}
        <div class="bg-card rounded-2xl border border-border shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-border">
                    <thead>
                        <tr class="bg-muted/80">
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wider">Peminjam</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wider">Buku</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wider hidden lg:table-cell">Tanggal Pinjam</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wider">Jatuh Tempo</th>
                            <th class="px-6 py-3.5 text-center text-xs font-semibold text-muted-foreground uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3.5 text-right text-xs font-semibold text-muted-foreground uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border/50">
                        @forelse($borrowings as $borrowing)
                            <tr class="hover:bg-muted/50 transition-colors duration-150">
                                {{-- Borrower Info --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($borrowing->user->name) }}&background=e0e7ff&color=4f46e5&size=36&font-size=0.4&bold=true"
                                             alt="Avatar" class="w-9 h-9 rounded-full flex-shrink-0">
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-foreground truncate">{{ $borrowing->user->name }}</p>
                                            <div class="flex items-center gap-1.5 mt-0.5">
                                                @if($borrowing->user->kelas)
                                                    <span class="text-[10px] font-bold text-primary bg-primary/10 px-1.5 py-0.5 rounded">{{ $borrowing->user->kelas }}</span>
                                                @endif
                                                <span class="text-xs text-muted-foreground truncate">{{ $borrowing->user->nomor_induk }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Book Info --}}
                                <td class="px-6 py-4">
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-foreground truncate max-w-[200px]">{{ $borrowing->book->judul }}</p>
                                        <p class="text-xs text-muted-foreground mt-0.5 font-mono">{{ $borrowing->book->kode_buku }}</p>
                                    </div>
                                </td>

                                {{-- Tanggal Pinjam --}}
                                <td class="px-6 py-4 hidden lg:table-cell">
                                    <span class="text-sm text-muted-foreground">{{ $borrowing->tanggal_pinjam->format('d M Y') }}</span>
                                </td>

                                {{-- Jatuh Tempo --}}
                                <td class="px-6 py-4">
                                    <span class="text-sm text-muted-foreground">{{ $borrowing->tanggal_jatuh_tempo->format('d M Y') }}</span>
                                    @if($borrowing->status === 'disetujui' && now()->gt($borrowing->tanggal_jatuh_tempo))
                                        <p class="text-[10px] text-red-500 font-bold mt-0.5">⚠ Terlambat</p>
                                    @endif
                                </td>

                                {{-- Status Badge --}}
                                <td class="px-6 py-4 text-center">
                                    @switch($borrowing->status)
                                        @case('pending')
                                            <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 text-xs font-semibold px-2.5 py-1 rounded-lg border border-amber-200/50">
                                                <span class="w-1.5 h-1.5 bg-amber-400 rounded-full animate-pulse"></span>
                                                Pending
                                            </span>
                                            @break
                                        @case('disetujui')
                                            <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 text-xs font-semibold px-2.5 py-1 rounded-lg border border-blue-200/50">
                                                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                                                Disetujui
                                            </span>
                                            @break
                                        @case('dikembalikan')
                                            <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 text-xs font-semibold px-2.5 py-1 rounded-lg border border-emerald-200/50">
                                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                                Dikembalikan
                                            </span>
                                            @if($borrowing->denda > 0)
                                                <p class="text-[10px] text-red-500 font-bold mt-1">Denda: Rp {{ number_format($borrowing->denda, 0, ',', '.') }}</p>
                                            @endif
                                            @break
                                        @case('ditolak')
                                            <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 text-xs font-semibold px-2.5 py-1 rounded-lg border border-red-200/50">
                                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                                Ditolak
                                            </span>
                                            @break
                                        @default
                                            <span class="inline-flex items-center bg-muted text-muted-foreground text-xs font-semibold px-2.5 py-1 rounded-lg">
                                                {{ ucfirst($borrowing->status) }}
                                            </span>
                                    @endswitch
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        @if($borrowing->status === 'pending')
                                            {{-- Approve --}}
                                            <x-confirm-modal
                                                :action="route('admin.borrowings.approve', $borrowing)"
                                                title="Setujui Peminjaman?"
                                                message="Setujui peminjaman buku <strong class='text-foreground'>{{ $borrowing->book->judul }}</strong> oleh <strong class='text-foreground'>{{ $borrowing->user->name }}</strong>?<br><br><span class='text-xs'>Stok buku akan berkurang 1.</span>"
                                                confirmText="Ya, Setujui"
                                                confirmColor="emerald"
                                                iconType="check">
                                                <button type="button"
                                                        class="cursor-pointer inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-emerald-100 transition-colors border border-emerald-200/50">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    Setujui
                                                </button>
                                            </x-confirm-modal>
                                            {{-- Reject --}}
                                            <x-confirm-modal
                                                :action="route('admin.borrowings.reject', $borrowing)"
                                                title="Tolak Peminjaman?"
                                                message="Tolak peminjaman oleh <strong class='text-foreground'>{{ $borrowing->user->name }}</strong>?"
                                                confirmText="Ya, Tolak"
                                                confirmColor="red"
                                                iconType="x-circle">
                                                <button type="button"
                                                        class="cursor-pointer inline-flex items-center gap-1 bg-red-50 text-red-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-red-100 transition-colors border border-red-200/50">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    Tolak
                                                </button>
                                            </x-confirm-modal>

                                        @elseif($borrowing->status === 'disetujui')
                                            {{-- Return --}}
                                            <x-confirm-modal
                                                :action="route('admin.borrowings.return', $borrowing)"
                                                title="Proses Pengembalian?"
                                                message="Proses pengembalian buku <strong class='text-foreground'>{{ $borrowing->book->judul }}</strong>?<br><br><span class='text-xs'>Stok buku akan bertambah 1.</span>"
                                                confirmText="Ya, Kembalikan"
                                                confirmColor="blue"
                                                iconType="return">
                                                <button type="button"
                                                        class="cursor-pointer inline-flex items-center gap-1 bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-blue-100 transition-colors border border-blue-200/50">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                                    Kembalikan
                                                </button>
                                            </x-confirm-modal>

                                        @elseif($borrowing->status === 'dikembalikan')
                                            <span class="text-xs text-muted-foreground">
                                                {{ $borrowing->tanggal_kembali?->format('d M Y') }}
                                            </span>
                                        @else
                                            <span class="text-xs text-muted-foreground">—</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-muted rounded-2xl flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                        </div>
                                        <p class="text-sm font-medium text-foreground">
                                            @if($search || $status || $kelas)
                                                Tidak ada transaksi ditemukan
                                            @else
                                                Belum ada transaksi peminjaman
                                            @endif
                                        </p>
                                        <p class="text-xs text-muted-foreground mt-1">
                                            @if($search || $status || $kelas)
                                                Coba ubah kata kunci pencarian atau filter.
                                            @else
                                                Data peminjaman akan muncul di sini setelah siswa mengajukan peminjaman.
                                            @endif
                                        </p>
                                        @if($search || $status || $kelas)
                                            <a href="{{ route('admin.borrowings.index') }}" class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-primary hover:text-primary/80 transition-colors">
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

            {{-- Pagination --}}
                <div class="px-6 py-4 border-t border-border bg-muted/50">
                    <x-pagination :paginator="$borrowings" :perPage="$perPage" />
                </div>
        </div>
    </div>
</x-app-layout>
