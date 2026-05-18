<x-app-layout>
    <x-slot name="title">Detail Buku: {{ $book->judul }}</x-slot>

    <div class="space-y-6">
        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.books.index') }}"
                   class="p-2 text-muted-foreground hover:text-muted-foreground hover:bg-card rounded-xl transition-all duration-200 border border-transparent hover:border-border hover:shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-foreground tracking-tight">Detail Buku</h1>
                    <p class="text-sm text-muted-foreground mt-0.5">Informasi lengkap untuk <strong class="text-foreground">{{ $book->judul }}</strong></p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.books.edit', $book) }}"
                   class="inline-flex items-center gap-2 bg-primary text-background px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-primary/90 transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit Buku
                </a>
            </div>
        </div>

        {{-- Book Detail Card --}}
        <div class="bg-card rounded-2xl border border-border shadow-sm overflow-hidden">
            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row gap-8">
                    {{-- Cover Image --}}
                    <div class="flex-shrink-0">
                        <div class="w-48 h-64 rounded-2xl overflow-hidden bg-muted border border-border/50 shadow-sm">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->judul }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-muted-foreground bg-gradient-to-br from-gray-50 to-gray-100">
                                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    <span class="text-xs font-medium">Tidak ada cover</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Book Info --}}
                    <div class="flex-1 min-w-0 space-y-6">
                        {{-- Title & Author --}}
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="inline-flex items-center bg-primary/10 text-primary text-xs font-medium px-2.5 py-1 rounded-lg">
                                    {{ $book->category->nama_kategori ?? '-' }}
                                </span>
                                <span class="text-xs font-mono text-muted-foreground bg-muted px-2 py-1 rounded-lg">{{ $book->kode_buku }}</span>
                            </div>
                            <h2 class="text-xl font-bold text-foreground tracking-tight leading-tight">{{ $book->judul }}</h2>
                            <p class="text-sm text-muted-foreground mt-1.5">oleh <span class="font-semibold text-foreground">{{ $book->penulis }}</span></p>
                        </div>

                        {{-- Detail Grid --}}
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            <div class="bg-muted rounded-xl p-4">
                                <p class="text-xs font-medium text-muted-foreground uppercase tracking-wider mb-1">Penerbit</p>
                                <p class="text-sm font-semibold text-foreground">{{ $book->penerbit }}</p>
                            </div>
                            <div class="bg-muted rounded-xl p-4">
                                <p class="text-xs font-medium text-muted-foreground uppercase tracking-wider mb-1">Tahun Terbit</p>
                                <p class="text-sm font-semibold text-foreground">{{ $book->tahun_terbit }}</p>
                            </div>
                            <div class="bg-muted rounded-xl p-4">
                                <p class="text-xs font-medium text-muted-foreground uppercase tracking-wider mb-1">Slug</p>
                                <p class="text-sm font-semibold text-foreground font-mono truncate">{{ $book->slug }}</p>
                            </div>
                            <div class="bg-muted rounded-xl p-4">
                                <p class="text-xs font-medium text-muted-foreground uppercase tracking-wider mb-1">Kode Rak</p>
                                <p class="text-sm font-semibold text-foreground font-mono">{{ $book->kode_rak ?? '-' }}</p>
                            </div>
                            <div class="bg-muted rounded-xl p-4">
                                <p class="text-xs font-medium text-muted-foreground uppercase tracking-wider mb-1">ISBN</p>
                                <p class="text-sm font-semibold text-foreground font-mono">{{ $book->isbn ?? '-' }}</p>
                            </div>
                        </div>

                        {{-- Stock Info --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-emerald-50 rounded-xl p-4 border border-emerald-100">
                                <p class="text-xs font-medium text-emerald-600 uppercase tracking-wider mb-1">Stok Tersedia</p>
                                <p class="text-2xl font-bold {{ $book->stok_tersedia > 0 ? 'text-emerald-700' : 'text-red-500' }}">
                                    {{ $book->stok_tersedia }}
                                </p>
                            </div>
                            <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                                <p class="text-xs font-medium text-blue-600 uppercase tracking-wider mb-1">Total Eksemplar</p>
                                <p class="text-2xl font-bold text-blue-700">{{ $book->total_eksemplar }}</p>
                            </div>
                        </div>

                        {{-- Timestamps --}}
                        <div class="flex items-center gap-4 text-xs text-muted-foreground pt-2 border-t border-border">
                            <span>Ditambahkan: <strong class="text-muted-foreground">{{ $book->created_at->format('d M Y, H:i') }}</strong></span>
                            <span>Terakhir diubah: <strong class="text-muted-foreground">{{ $book->updated_at->format('d M Y, H:i') }}</strong></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
