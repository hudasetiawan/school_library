<x-app-layout>
    <x-slot name="title">{{ $book->judul }}</x-slot>

    <div class="space-y-8" x-data="borrowModal()">
        {{-- Page Header --}}
        <div class="flex items-center gap-4">
            <a href="{{ route('books.index') }}"
               class="p-2 text-muted-foreground hover:text-muted-foreground hover:bg-card rounded-xl transition-all duration-200 border border-transparent hover:border-border hover:shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-foreground tracking-tight">Detail Buku</h1>
                <p class="text-sm text-muted-foreground mt-0.5">Informasi untuk buku <strong class="text-foreground">{{ $book->judul }}</strong></p>
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

        <div class="bg-card rounded-2xl shadow-sm border border-border p-6 md:p-8 overflow-hidden relative">

            <div class="flex flex-col md:flex-row gap-8">
                <!-- Left Column: Cover Image -->
                <div class="w-full md:w-1/4 flex-shrink-0">
                    <div class="rounded-xl overflow-hidden shadow-lg border border-border relative">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->judul }}" class="w-full h-auto object-cover">
                        @else
                            <div class="w-full aspect-[2/3] bg-muted flex items-center justify-center text-muted-foreground">
                                <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                        @endif
                    </div>

                    <!-- Metadata Grid -->
                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <div class="p-3 bg-muted rounded-xl text-center border border-border">
                             <p class="text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-0.5">Stok Buku</p>
                             <p class="text-lg font-bold {{ $book->stok_tersedia > 0 ? 'text-primary' : 'text-red-500' }}">
                                 {{ $book->stok_tersedia }}/{{ $book->total_eksemplar }}
                             </p>
                        </div>
                        <div class="p-3 bg-muted rounded-xl text-center border border-border">
                             <p class="text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-0.5">Tahun</p>
                             <p class="text-lg font-bold text-foreground">{{ $book->tahun_terbit }}</p>
                        </div>
                        @if($book->kode_rak)
                        <div class="p-3 bg-muted rounded-xl text-center border border-border">
                             <p class="text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-0.5">Kode Rak</p>
                             <p class="text-sm font-bold text-foreground font-mono">{{ $book->kode_rak }}</p>
                        </div>
                        @endif
                        @if($book->isbn)
                        <div class="p-3 bg-muted rounded-xl text-center border border-border">
                             <p class="text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-0.5">ISBN</p>
                             <p class="text-xs font-bold text-foreground font-mono">{{ $book->isbn }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column: Details -->
                <div class="flex-1 flex flex-col">
                    <div class="mb-6 border-b border-border pb-6">
                        <div class="flex flex-wrap items-center gap-2 mb-3">
                            <span class="bg-primary/15 text-primary text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">{{ $book->category->nama_kategori ?? '-' }}</span>
                            <span class="text-muted-foreground text-sm font-mono bg-muted px-2 py-1 rounded">{{ $book->kode_buku }}</span>
                            @if($book->isbn)
                                <span class="text-muted-foreground text-xs font-mono bg-muted px-2 py-1 rounded">ISBN: {{ $book->isbn }}</span>
                            @endif
                        </div>

                        <h1 class="text-3xl md:text-4xl font-bold text-foreground mb-3 leading-tight tracking-tight">{{ $book->judul }}</h1>
                        <p class="text-lg text-muted-foreground">ditulis oleh <span class="text-foreground font-semibold">{{ $book->penulis }}</span></p>
                         <p class="text-sm text-muted-foreground mt-1">Diterbitkan oleh {{ $book->penerbit }}</p>
                    </div>

                    <div class="mb-8 flex-grow">
                         <h3 class="text-base font-bold text-foreground mb-3">Tentang Buku Ini</h3>
                         <div class="prose prose-sm text-muted-foreground leading-relaxed max-w-none">
                             <p>
                                 Buku ini merupakan salah satu koleksi terpopuler di perpustakaan SMKN 2 Magelang. Ditulis oleh <strong>{{ $book->penulis }}</strong> dan diterbitkan oleh <strong>{{ $book->penerbit }}</strong> pada tahun {{ $book->tahun_terbit }}, buku ini mencakup wawasan mendalam yang relevan untuk kategori {{ $book->category->nama_kategori ?? '-' }}.
                             </p>
                             <p class="mt-4">
                                 Sangat direkomendasikan untuk siswa yang ingin memperdalam pengetahuan di bidang ini. Segera pinjam sebelum kehabisan stok!
                             </p>
                         </div>
                    </div>

                    <!-- Action Button: Open Borrow Modal -->
                    <div class="mt-auto">
                        <div class="bg-muted p-5 rounded-xl border border-border">
                            @if($book->stok_tersedia > 0)
                                <div class="flex flex-col sm:flex-row items-center gap-4">
                                    <div class="flex-grow w-full">
                                        <p class="text-sm text-muted-foreground mb-1">Ingin meminjam buku ini?</p>
                                        <p class="text-xs text-muted-foreground">Pengajuan akan diverifikasi oleh petugas perpustakaan terlebih dahulu.</p>
                                    </div>
                                    <div class="w-full sm:w-auto">
                                        <button @click="openModal()"
                                                type="button"
                                                class="w-full sm:w-auto bg-foreground text-background rounded-xl px-8 py-3.5 font-bold shadow-lg hover:bg-black transition-all cursor-pointer transform hover:-translate-y-1 hover:shadow-xl">
                                            Ajukan Peminjaman
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-2">
                                    <p class="text-red-500 text-sm font-bold">Maaf, buku ini sedang dipinjam semua.</p>
                                    <p class="text-xs text-muted-foreground mt-1">Silakan cek kembali nanti atau hubungi petugas perpustakaan.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

             <!-- Decorative Abstract Blob -->
            <div class="absolute top-0 right-0 -mt-16 -mr-16 w-64 h-64 bg-gradient-to-br from-green-50 to-blue-50 rounded-full blur-3xl opacity-50 -z-10 pointer-events-none"></div>
        </div>

        {{-- Borrow Modal (Flatpickr Datepicker) --}}
        <div x-show="showModal" x-cloak
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-foreground/50 backdrop-blur-sm"
             @keydown.escape.window="closeModal()">

            <div x-show="showModal" @click.away="closeModal()"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="bg-card rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">

                {{-- Modal Header --}}
                <div class="p-6 border-b border-border">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-foreground">Ajukan Peminjaman</h3>
                            <p class="text-xs text-muted-foreground">Pilih tanggal pengembalian untuk buku ini</p>
                        </div>
                    </div>

                    {{-- Book info recap --}}
                    <div class="bg-muted rounded-xl p-3 flex items-center gap-3">
                        <div class="w-10 h-14 rounded-lg overflow-hidden bg-muted flex-shrink-0">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->judul }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-muted-foreground">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-foreground truncate">{{ $book->judul }}</p>
                            <p class="text-xs text-muted-foreground">{{ $book->penulis }}</p>
                        </div>
                    </div>
                </div>

                {{-- Modal Body --}}
                <form action="{{ route('borrow.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">

                    <div class="p-6">
                        <label class="block text-sm font-medium text-foreground mb-2">Tanggal Pengembalian <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </span>
                            <input type="text" name="tanggal_jatuh_tempo" id="borrowDatepicker" required readonly
                                   x-ref="datepicker"
                                   class="w-full pl-10 pr-4 py-3 bg-muted border border-border rounded-xl text-sm focus:ring-2 focus:ring-ring/20 focus:border-ring focus:bg-card transition-all placeholder:text-muted-foreground cursor-pointer"
                                   placeholder="Pilih tanggal...">
                        </div>
                        <p class="text-xs text-muted-foreground mt-2">Batas peminjaman maksimal 14 hari dari hari ini.</p>
                        @error('tanggal_jatuh_tempo')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Modal Footer --}}
                    <div class="flex border-t border-border">
                        <button @click.prevent="closeModal()" type="button"
                                class="flex-1 py-3.5 text-sm font-semibold text-muted-foreground cursor-pointer hover:bg-muted transition-colors border-r border-border">
                            Batal
                        </button>
                        <button type="submit"
                                class="flex-1 py-3.5 text-sm font-semibold text-primary hover:bg-primary/10 cursor-pointer transition-colors">
                            Ajukan Peminjaman
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        function borrowModal() {
            return {
                showModal: false,
                fpInstance: null,

                openModal() {
                    this.showModal = true;
                    this.$nextTick(() => {
                        this.initFlatpickr();
                    });
                },

                closeModal() {
                    this.showModal = false;
                    if (this.fpInstance) {
                        this.fpInstance.destroy();
                        this.fpInstance = null;
                    }
                },

                initFlatpickr() {
                    if (this.fpInstance) return;

                    const tomorrow = new Date();
                    tomorrow.setDate(tomorrow.getDate() + 1);

                    const maxDate = new Date();
                    maxDate.setDate(maxDate.getDate() + 14);

                    this.fpInstance = flatpickr(this.$refs.datepicker, {
                        dateFormat: 'Y-m-d',
                        altInput: true,
                        altFormat: 'j F Y',
                        minDate: tomorrow,
                        maxDate: maxDate,
                        disableMobile: true,
                        defaultDate: null,
                        appendTo: this.$refs.datepicker.closest('.p-6'),
                    });
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
