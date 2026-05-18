<x-app-layout>
    <x-slot name="title">Edit Buku: {{ $book->judul }}</x-slot>

    <div class="space-y-6" x-data="bookEditForm()">
        {{-- Page Header --}}
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.books.index') }}"
               class="p-2 text-muted-foreground hover:text-muted-foreground hover:bg-card rounded-xl transition-all duration-200 border border-transparent hover:border-border hover:shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-foreground tracking-tight">Edit Buku</h1>
                <p class="text-sm text-muted-foreground mt-0.5">Perbarui informasi untuk <strong class="text-foreground">{{ $book->judul }}</strong></p>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="bg-card rounded-2xl border border-border shadow-sm overflow-hidden">
            <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="p-6 md:p-8">
                    {{-- Section: Informasi Utama --}}
                    <div class="mb-8">
                        <h3 class="text-sm font-bold text-foreground uppercase tracking-wider mb-5 flex items-center gap-2">
                            <span class="w-6 h-6 bg-indigo-100 text-primary rounded-lg flex items-center justify-center text-xs font-bold">1</span>
                            Informasi Utama
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            {{-- Kode Buku --}}
                            <div>
                                <label for="kode_buku" class="block text-sm font-medium text-foreground mb-1.5">Kode Buku <span class="text-red-400">*</span></label>
                                <input type="text" id="kode_buku" name="kode_buku" value="{{ old('kode_buku', $book->kode_buku) }}" required
                                       class="w-full px-4 py-2.5 bg-muted border border-border rounded-xl text-sm focus:ring-2 focus:ring-ring/20 focus:border-ring focus:bg-card transition-all placeholder:text-muted-foreground">
                                <x-input-error :messages="$errors->get('kode_buku')" class="mt-1.5" />
                            </div>

                            {{-- Judul --}}
                            <div>
                                <label for="judul" class="block text-sm font-medium text-foreground mb-1.5">Judul Buku <span class="text-red-400">*</span></label>
                                <input type="text" id="judul" name="judul" value="{{ old('judul', $book->judul) }}" required
                                       class="w-full px-4 py-2.5 bg-muted border border-border rounded-xl text-sm focus:ring-2 focus:ring-ring/20 focus:border-ring focus:bg-card transition-all placeholder:text-muted-foreground">
                                <x-input-error :messages="$errors->get('judul')" class="mt-1.5" />
                            </div>

                            {{-- Penulis --}}
                            <div>
                                <label for="penulis" class="block text-sm font-medium text-foreground mb-1.5">Penulis <span class="text-red-400">*</span></label>
                                <input type="text" id="penulis" name="penulis" value="{{ old('penulis', $book->penulis) }}" required
                                       class="w-full px-4 py-2.5 bg-muted border border-border rounded-xl text-sm focus:ring-2 focus:ring-ring/20 focus:border-ring focus:bg-card transition-all placeholder:text-muted-foreground">
                                <x-input-error :messages="$errors->get('penulis')" class="mt-1.5" />
                            </div>

                            {{-- Penerbit --}}
                            <div>
                                <label for="penerbit" class="block text-sm font-medium text-foreground mb-1.5">Penerbit <span class="text-red-400">*</span></label>
                                <input type="text" id="penerbit" name="penerbit" value="{{ old('penerbit', $book->penerbit) }}" required
                                       class="w-full px-4 py-2.5 bg-muted border border-border rounded-xl text-sm focus:ring-2 focus:ring-ring/20 focus:border-ring focus:bg-card transition-all placeholder:text-muted-foreground">
                                <x-input-error :messages="$errors->get('penerbit')" class="mt-1.5" />
                            </div>

                            {{-- Tahun Terbit --}}
                            <div>
                                <label for="tahun_terbit" class="block text-sm font-medium text-foreground mb-1.5">Tahun Terbit <span class="text-red-400">*</span></label>
                                <input type="number" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit', $book->tahun_terbit) }}" required
                                       min="1900" max="{{ date('Y') + 1 }}"
                                       class="w-full px-4 py-2.5 bg-muted border border-border rounded-xl text-sm focus:ring-2 focus:ring-ring/20 focus:border-ring focus:bg-card transition-all placeholder:text-muted-foreground">
                                <x-input-error :messages="$errors->get('tahun_terbit')" class="mt-1.5" />
                            </div>

                            {{-- Kategori --}}
                            <div>
                                <x-category-select :categories="$categories" :selected="$book->category_id" />
                            </div>

                            {{-- Kode Rak --}}
                            <div>
                                <label for="kode_rak" class="block text-sm font-medium text-foreground mb-1.5">Kode Rak <span class="text-red-500">*</span></label>
                                <input type="text" id="kode_rak" name="kode_rak" value="{{ old('kode_rak', $book->kode_rak) }}" required
                                       class="w-full px-4 py-2.5 bg-muted border border-border rounded-xl text-sm focus:ring-2 focus:ring-ring/20 focus:border-ring focus:bg-card transition-all placeholder:text-muted-foreground"
                                       placeholder="Contoh: RAK-A01 (isi - jika belum tersedia)">
                                <x-input-error :messages="$errors->get('kode_rak')" class="mt-1.5" />
                            </div>

                            {{-- ISBN --}}
                            <div>
                                <label for="isbn" class="block text-sm font-medium text-foreground mb-1.5">ISBN <span class="text-muted-foreground font-normal">(Opsional)</span></label>
                                <input type="text" id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}"
                                       class="w-full px-4 py-2.5 bg-muted border border-border rounded-xl text-sm focus:ring-2 focus:ring-ring/20 focus:border-ring focus:bg-card transition-all placeholder:text-muted-foreground"
                                       placeholder="Contoh: 978-602-1234-56-7" maxlength="20">
                                <x-input-error :messages="$errors->get('isbn')" class="mt-1.5" />
                            </div>
                        </div>
                    </div>

                    {{-- Section: Stok & Cover --}}
                    <div>
                        <h3 class="text-sm font-bold text-foreground uppercase tracking-wider mb-5 flex items-center gap-2">
                            <span class="w-6 h-6 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center text-xs font-bold">2</span>
                            Stok & Cover
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            {{-- Total Eksemplar --}}
                            <div>
                                <label for="total_eksemplar" class="block text-sm font-medium text-foreground mb-1.5">Total Eksemplar <span class="text-red-400">*</span></label>
                                <input type="number" id="total_eksemplar" name="total_eksemplar" value="{{ old('total_eksemplar', $book->total_eksemplar) }}" required min="0"
                                       class="w-full px-4 py-2.5 bg-muted border border-border rounded-xl text-sm focus:ring-2 focus:ring-ring/20 focus:border-ring focus:bg-card transition-all placeholder:text-muted-foreground">
                                <x-input-error :messages="$errors->get('total_eksemplar')" class="mt-1.5" />
                            </div>

                            {{-- Stok Tersedia --}}
                            <div>
                                <label for="stok_tersedia" class="block text-sm font-medium text-foreground mb-1.5">Stok Tersedia <span class="text-red-400">*</span></label>
                                <input type="number" id="stok_tersedia" name="stok_tersedia" value="{{ old('stok_tersedia', $book->stok_tersedia) }}" required min="0"
                                       class="w-full px-4 py-2.5 bg-muted border border-border rounded-xl text-sm focus:ring-2 focus:ring-ring/20 focus:border-ring focus:bg-card transition-all placeholder:text-muted-foreground">
                                <p class="text-xs text-muted-foreground mt-1.5">Jumlah buku yang saat ini tersedia di rak.</p>
                                <x-input-error :messages="$errors->get('stok_tersedia')" class="mt-1.5" />
                            </div>

                            {{-- Cover Image Upload --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-foreground mb-1.5">Cover Buku <span class="text-muted-foreground font-normal">(Opsional)</span></label>
                                <div class="flex items-start gap-4">
                                    {{-- Image Preview --}}
                                    <div class="w-20 h-28 rounded-xl border-2 border-dashed border-border overflow-hidden flex-shrink-0 bg-muted flex items-center justify-center transition-all duration-200"
                                         :class="imagePreview ? 'border-solid border-indigo-200' : ''">
                                        <template x-if="imagePreview">
                                            <img :src="imagePreview" alt="Preview" class="w-full h-full object-cover">
                                        </template>
                                        <template x-if="!imagePreview">
                                            @if($book->cover_image)
                                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Current Cover" class="w-full h-full object-cover">
                                            @else
                                                <svg class="w-6 h-6 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            @endif
                                        </template>
                                    </div>

                                    <div class="flex-1">
                                        <label for="cover_image"
                                               class="flex flex-col items-center justify-center w-full py-4 border-2 border-dashed border-border rounded-xl cursor-pointer hover:border-indigo-300 hover:bg-primary/10/30 transition-all duration-200">
                                            <svg class="w-6 h-6 text-muted-foreground mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                            <span class="text-xs text-muted-foreground font-medium">Ganti gambar cover</span>
                                            <span class="text-[10px] text-muted-foreground mt-0.5">JPG, PNG, WebP · Maks 2MB</span>
                                        </label>
                                        <input id="cover_image" type="file" name="cover_image" class="hidden" accept="image/jpeg,image/png,image/webp"
                                               @change="previewImage($event)">
                                        @if($book->cover_image)
                                            <p class="text-xs text-muted-foreground mt-1.5">Cover saat ini: <span class="font-mono text-muted-foreground">{{ basename($book->cover_image) }}</span></p>
                                        @endif
                                        <x-input-error :messages="$errors->get('cover_image')" class="mt-1.5" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form Footer --}}
                <div class="px-6 md:px-8 py-4 bg-muted/80 border-t border-border flex items-center justify-between">
                    <a href="{{ route('admin.books.index') }}" class="text-sm text-muted-foreground hover:text-foreground font-medium transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-foreground text-background px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-foreground/90 transition-all duration-200 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Perbarui Buku
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function bookEditForm() {
            return {
                imagePreview: null,
                previewImage(event) {
                    const file = event.target.files[0];
                    if (file) {
                        if (file.size > 2 * 1024 * 1024) {
                            alert('Ukuran file terlalu besar. Maksimal 2MB.');
                            event.target.value = '';
                            this.imagePreview = null;
                            return;
                        }
                        const reader = new FileReader();
                        reader.onload = (e) => { this.imagePreview = e.target.result; };
                        reader.readAsDataURL(file);
                    }
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
