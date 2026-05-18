<x-app-layout>
    <x-slot name="title">Peminjaman Saya</x-slot>

    <div class="space-y-6">
        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-foreground tracking-tight">Peminjaman Saya</h1>
                <p class="text-sm text-muted-foreground mt-1">Riwayat dan status peminjaman buku Anda.</p>
            </div>
            <a href="{{ route('books.index') }}"
               class="inline-flex items-center gap-2 cursor-pointer bg-primary text-background px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-primary/90 transition-all duration-200 shadow-sm hover:shadow-md self-start">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Pinjam Buku
            </a>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                 x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="bg-primary/10 border border-primary/20 text-primary px-5 py-3.5 rounded-xl flex items-center gap-3" role="alert">
                <svg class="w-5 h-5 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                 x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="bg-red-50 border border-red-200 text-red-800 px-5 py-3.5 rounded-xl flex items-center gap-3" role="alert">
                <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Search & Filter --}}
        <div class="bg-card rounded-2xl border border-border shadow-sm p-5">
            <form action="{{ route('borrowings.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                {{-- Search --}}
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           placeholder="Cari judul buku..."
                           class="w-full pl-10 pr-4 py-2.5 border border-border rounded-xl text-sm focus:ring-2 focus:ring-ring/20 focus:border-primary focus:bg-card transition-all placeholder:text-muted-foreground">
                </div>

                {{-- Status Filter --}}
                <div class="sm:w-48">
                    <select name="status"
                            class="w-full py-2.5 px-3.5 bg-card text-foreground border border-border rounded-xl text-sm transition-colors duration-200 cursor-pointer hover:bg-secondary/50 focus:bg-secondary focus:ring-2 focus:ring-ring/20 focus:border-ring appearance-none"
                            style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpath d=%27M6 9l6 6 6-6%27/%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ ($status ?? '') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="disetujui" {{ ($status ?? '') === 'disetujui' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="dikembalikan" {{ ($status ?? '') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        <option value="ditolak" {{ ($status ?? '') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="flex gap-2">
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-primary cursor-pointer text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-primary/90 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter
                    </button>
                    @if(request('search') || request('status'))
                        <a href="{{ route('borrowings.index') }}"
                           class="inline-flex items-center gap-1.5 bg-muted text-muted-foreground px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-muted transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Result Info --}}
        @if($search || $status)
            <div class="flex items-center gap-2 text-sm text-muted-foreground">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Menampilkan <strong class="text-foreground">{{ $borrowings->total() }}</strong> hasil
                    @if($search) untuk "<strong class="text-foreground">{{ $search }}</strong>"@endif
                    @if($status) dengan status <strong class="text-foreground">{{ ucfirst($status) }}</strong>@endif
                </span>
            </div>
        @endif

        {{-- Borrowings Table --}}
        <div class="bg-card rounded-2xl border border-border shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead>
                        <tr class="bg-muted/80">
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wider">Buku</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wider hidden sm:table-cell">Tanggal Pinjam</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wider">Jatuh Tempo</th>
                            <th class="px-6 py-3.5 text-center text-xs font-semibold text-muted-foreground uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3.5 text-right text-xs font-semibold text-muted-foreground uppercase tracking-wider">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($borrowings as $borrowing)
                            <tr class="hover:bg-muted/50 transition-colors duration-150">
                                {{-- Book Info --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-14 rounded-lg overflow-hidden bg-muted flex-shrink-0 border border-border/50">
                                            @if($borrowing->book->cover_image)
                                                <img src="{{ asset('storage/' . $borrowing->book->cover_image) }}" alt="{{ $borrowing->book->judul }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-muted-foreground">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-foreground truncate max-w-[200px]">{{ $borrowing->book->judul }}</p>
                                            <p class="text-xs text-muted-foreground mt-0.5 font-mono">{{ $borrowing->book->kode_buku }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Tanggal Pinjam --}}
                                <td class="px-6 py-4 hidden sm:table-cell">
                                    <span class="text-sm text-muted-foreground">{{ $borrowing->tanggal_pinjam->format('d M Y') }}</span>
                                </td>

                                {{-- Jatuh Tempo --}}
                                <td class="px-6 py-4">
                                    <span class="text-sm text-muted-foreground">{{ $borrowing->tanggal_jatuh_tempo->format('d M Y') }}</span>
                                    @if($borrowing->status === 'disetujui' && now()->gt($borrowing->tanggal_jatuh_tempo))
                                        <p class="text-[10px] text-red-600 font-bold mt-0.5 flex items-center gap-0.5">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                                            Terlambat {{ (int) now()->diffInDays($borrowing->tanggal_jatuh_tempo) }} hari
                                        </p>
                                    @endif
                                </td>

                                {{-- Status Badge --}}
                                <td class="px-6 py-4 text-center">
                                    @switch($borrowing->status)
                                        @case('pending')
                                            <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 text-xs font-semibold px-2.5 py-1 rounded-lg border border-amber-200/50">
                                                <span class="w-1.5 h-1.5 bg-amber-400 rounded-full animate-pulse"></span>
                                                Menunggu
                                            </span>
                                            @break
                                        @case('disetujui')
                                            <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 text-xs font-semibold px-2.5 py-1 rounded-lg border border-blue-200/50">
                                                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                                                Dipinjam
                                            </span>
                                            @break
                                        @case('dikembalikan')
                                            <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 text-xs font-semibold px-2.5 py-1 rounded-lg border border-emerald-200/50">
                                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                                Dikembalikan
                                            </span>
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

                                {{-- Keterangan --}}
                                <td class="px-6 py-4 text-right">
                                    @if($borrowing->status === 'pending')
                                        <span class="text-xs text-muted-foreground">Menunggu persetujuan petugas</span>
                                    @elseif($borrowing->status === 'disetujui')
                                        <span class="text-xs text-blue-600 font-medium">Sedang dipinjam</span>
                                    @elseif($borrowing->status === 'dikembalikan')
                                        <div class="space-y-0.5">
                                            <span class="text-xs text-muted-foreground">Kembali: {{ $borrowing->tanggal_kembali?->format('d M Y') }}</span>
                                            @if($borrowing->denda > 0)
                                                <p class="text-xs text-red-500 font-bold">Denda: Rp {{ number_format($borrowing->denda, 0, ',', '.') }}</p>
                                            @endif
                                        </div>
                                    @elseif($borrowing->status === 'ditolak')
                                        <span class="text-xs text-red-500">Pengajuan ditolak oleh petugas</span>
                                    @else
                                        <span class="text-xs text-muted-foreground">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-muted rounded-2xl flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                        </div>
                                        <p class="text-sm font-medium text-foreground">
                                            @if($search || $status)
                                                Tidak ada peminjaman ditemukan
                                            @else
                                                Belum ada peminjaman
                                            @endif
                                        </p>
                                        <p class="text-xs text-muted-foreground mt-1">
                                            @if($search || $status)
                                                Coba ubah kata kunci pencarian atau filter status.
                                            @else
                                                Mulai pinjam buku dari katalog perpustakaan.
                                            @endif
                                        </p>
                                        @if($search || $status)
                                            <a href="{{ route('borrowings.index') }}" class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-primary hover:text-primary transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                Reset Pencarian
                                            </a>
                                        @else
                                            <a href="{{ route('books.index') }}" class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-primary hover:text-primary transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                Jelajahi Buku
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
