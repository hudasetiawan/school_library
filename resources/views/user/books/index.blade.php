<x-app-layout>
    <x-slot name="title">Katalog Buku</x-slot>

    <div class="space-y-6" x-data="{ view: localStorage.getItem('bookView') || 'card' }" x-init="$watch('view', val => localStorage.setItem('bookView', val))">
        {{-- Header + View Toggle --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-foreground tracking-tight">Daftar Buku</h1>
                <p class="text-sm text-muted-foreground mt-1">Temukan buku menarik untuk dibaca hari ini.</p>
            </div>
            {{-- View Toggle --}}
            <div class="flex items-center gap-1 bg-muted rounded-xl p-1 self-start">
                <button @click="view = 'card'" :class="view === 'card' ? 'bg-card shadow-sm text-primary' : 'text-muted-foreground hover:text-foreground'"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-semibold transition-all duration-200 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Kartu
                </button>
                <button @click="view = 'list'" :class="view === 'list' ? 'bg-card shadow-sm text-primary' : 'text-muted-foreground hover:text-foreground'"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-semibold transition-all duration-200 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    Daftar
                </button>
            </div>
        </div>

        {{-- Search & Filter Bar --}}
        <div class="bg-card rounded-2xl border border-border shadow-sm p-5">
            <form action="{{ route('books.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           placeholder="Cari judul, penulis, ISBN, atau kode rak..."
                           class="w-full pl-10 pr-4 py-2.5 border border-border rounded-xl text-sm focus:ring-2 focus:ring-ring/20 focus:border-primary focus:bg-card transition-all placeholder:text-muted-foreground">
                </div>
                <div class="sm:w-52">
                    <select name="category_id"
                            class="w-full py-2.5 px-3.5 bg-card text-foreground border border-border rounded-xl text-sm transition-colors duration-200 cursor-pointer hover:bg-secondary/50 focus:bg-secondary focus:ring-2 focus:ring-ring/20 focus:border-ring appearance-none"
                            style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpath d=%27M6 9l6 6 6-6%27/%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ ($categoryId ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                            class="cursor-pointer inline-flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-primary/90 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter
                    </button>
                    @if(request('search') || request('category_id'))
                        <a href="{{ route('books.index') }}"
                           class="inline-flex items-center gap-1.5 bg-muted text-muted-foreground px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-muted transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Result Info --}}
        @if($search || $categoryId)
            <div class="flex items-center gap-2 text-sm text-muted-foreground">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Menampilkan <strong class="text-foreground">{{ $books->total() }}</strong> hasil
                    @if($search) untuk "<strong class="text-foreground">{{ $search }}</strong>"@endif
                    @if($categoryId && $categories->firstWhere('id', $categoryId))
                        dalam kategori <strong class="text-foreground">{{ $categories->firstWhere('id', $categoryId)->nama_kategori }}</strong>
                    @endif
                </span>
            </div>
        @endif

        {{-- ==================== CARD VIEW ==================== --}}
        <div x-show="view === 'card'" x-cloak
             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
            @forelse($books as $book)
                <a href="{{ route('books.show', $book) }}"
                   class="group bg-card rounded-xl overflow-hidden border border-border shadow-sm hover:shadow-lg hover:border-primary/30 transition-all duration-300 hover:-translate-y-1 flex flex-col">

                    {{-- Cover --}}
                    <div class="aspect-[2/3] bg-gradient-to-br from-muted to-secondary relative overflow-hidden">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->judul }}"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-muted-foreground gap-1.5">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                <span class="text-[9px] font-medium">No Cover</span>
                            </div>
                        @endif
                        @if($book->category)
                            <div class="absolute top-2 left-2">
                                <span class="bg-card/90 backdrop-blur-sm text-foreground text-[9px] font-bold px-1.5 py-0.5 rounded-md shadow-sm border border-white/50">{{ $book->category->nama_kategori }}</span>
                            </div>
                        @endif
                        <div class="absolute top-2 right-2">
                            @if($book->stok_tersedia > 0)
                                <span class="bg-emerald-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-md shadow-sm">Stok: {{ $book->stok_tersedia }}</span>
                            @else
                                <span class="bg-red-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-md shadow-sm">Habis</span>
                            @endif
                        </div>
                    </div>

                    {{-- Details --}}
                    <div class="p-2.5 flex flex-col flex-1">
                        <h3 class="text-xs font-bold text-foreground leading-snug line-clamp-2 group-hover:text-primary transition-colors mb-0.5">{{ $book->judul }}</h3>
                        <p class="text-[11px] text-muted-foreground line-clamp-1 mb-2">{{ $book->penulis }}</p>
                        @if($book->isbn)
                            <p class="text-[10px] text-muted-foreground font-mono truncate mb-2">ISBN: {{ $book->isbn }}</p>
                        @endif
                        <div class="mt-auto flex items-center justify-between pt-2 border-t border-border">
                            <span class="text-[10px] font-medium text-muted-foreground">{{ $book->tahun_terbit }}</span>
                            <span class="text-[10px] font-bold text-primary flex items-center gap-0.5 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-[-4px] group-hover:translate-x-0">
                                Detail
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-16 text-center">
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 bg-muted rounded-2xl flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <p class="text-sm font-medium text-foreground">Tidak ada buku ditemukan</p>
                        <p class="text-xs text-muted-foreground mt-1">Coba ubah kata kunci pencarian atau filter kategori.</p>
                        @if($search || $categoryId)
                            <a href="{{ route('books.index') }}" class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-primary hover:text-primary/80 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Reset Pencarian
                            </a>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Card View Pagination --}}
        <div x-show="view === 'card'" x-cloak class="mt-5">
            <x-pagination :paginator="$books" :perPage="$perPage" />
        </div>

        {{-- ==================== LIST VIEW ==================== --}}
        <div x-show="view === 'list'" x-cloak
             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <div class="bg-card rounded-2xl border border-border shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-border">
                        <thead>
                            <tr class="bg-muted/80">
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wider">Buku</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wider hidden lg:table-cell">Penerbit</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wider hidden xl:table-cell">Kode Rak</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wider hidden xl:table-cell">ISBN</th>
                                <th class="px-6 py-3.5 text-center text-xs font-semibold text-muted-foreground uppercase tracking-wider">Stok</th>
                                <th class="px-6 py-3.5 text-right text-xs font-semibold text-muted-foreground uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border/50">
                            @forelse($books as $book)
                            <tr class="hover:bg-muted/50 transition-colors duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-16 rounded-lg overflow-hidden bg-muted flex-shrink-0 border border-border/50">
                                            @if($book->cover_image)
                                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->judul }}" class="w-full h-full object-cover">
                                            @else
                                            <div class="w-full h-full flex items-center justify-center text-muted-foreground">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-foreground truncate max-w-xs">{{ $book->judul }}</p>
                                            <p class="text-xs text-muted-foreground mt-0.5">{{ $book->penulis }}</p>
                                            <p class="text-xs text-muted-foreground mt-0.5 font-mono">{{ $book->kode_buku }} · {{ $book->tahun_terbit }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 hidden lg:table-cell">
                                    <span class="text-sm text-muted-foreground">{{ $book->penerbit }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center bg-primary/10 text-primary text-xs font-medium px-2.5 py-1 rounded-lg">
                                        {{ $book->category->nama_kategori ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 hidden xl:table-cell"><span class="text-sm text-muted-foreground font-mono">{{ $book->kode_rak ?? '-' }}</span></td>
                                <td class="px-6 py-4 hidden xl:table-cell"><span class="text-sm text-muted-foreground font-mono">{{ $book->isbn ?? '-' }}</span></td>
                                <td class="px-6 py-4 text-center">
                                    <div class="inline-flex flex-col items-center">
                                        <span class="text-md font-bold {{ $book->stok_tersedia > 0 ? 'text-emerald-600' : 'text-red-500' }}">
                                            {{ $book->stok_tersedia }}
                                        </span>
                                        <span class="text-xs text-muted-foreground mt-0.5">dari {{ $book->total_eksemplar }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('books.show', $book) }}"
                                       class="inline-flex items-center gap-1 bg-primary/10 text-primary px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-primary/20 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-muted rounded-2xl flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        </div>
                                        <p class="text-sm font-medium text-foreground">Tidak ada buku ditemukan</p>
                                        <p class="text-xs text-muted-foreground mt-1">Coba ubah kata kunci pencarian atau filter kategori.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-6 py-4 border-t border-border bg-muted/50">
                    <x-pagination :paginator="$books" :perPage="$perPage" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
