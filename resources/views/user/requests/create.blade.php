<x-app-layout>
    <x-slot name="title">Ajukan Buku Baru</x-slot>

    <div class="space-y-8" data-animate="fade-in-up">
        
        {{-- Page Header --}}
        <div class="flex items-center gap-4">
            <a href="{{ route('requests.index') }}"
               class="p-2 text-muted-foreground hover:text-muted-foreground hover:bg-card rounded-xl transition-all duration-200 border border-transparent hover:border-border hover:shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-foreground tracking-tight">Ajukan Buku Baru</h1>
                <p class="text-sm text-muted-foreground mt-0.5">Bantu kami melengkapi koleksi perpustakaan dengan rekomendasi Anda.</p>
            </div>
        </div>

        <div class="max-w-2xl mx-auto">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-foreground tracking-tight">Ajukan Buku Baru</h2>
                <p class="text-muted-foreground mt-2">Bantu kami melengkapi koleksi perpustakaan dengan rekomendasi Anda.</p>
            </div>

            <div class="bg-card rounded-2xl shadow-sm border border-border p-8 md:p-10 relative overflow-hidden">
                 <!-- Decorative top border -->
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-400 to-blue-500"></div>

                <form action="{{ route('requests.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <x-input-label for="judul" :value="__('Judul Buku')" class="mb-2" />
                        <x-text-input id="judul" class="block w-full text-lg p-4" type="text" name="judul" :value="old('judul')" required autofocus placeholder="Contoh: Laut Bercerita" />
                        <x-input-error :messages="$errors->get('judul')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="penulis" :value="__('Penulis')" class="mb-2" />
                            <x-text-input id="penulis" class="block w-full" type="text" name="penulis" :value="old('penulis')" required placeholder="Nama Penulis" />
                            <x-input-error :messages="$errors->get('penulis')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="penerbit" :value="__('Penerbit (Opsional)')" class="mb-2" />
                            <x-text-input id="penerbit" class="block w-full" type="text" name="penerbit" :value="old('penerbit')" placeholder="Nama Penerbit" />
                            <x-input-error :messages="$errors->get('penerbit')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="kategori" :value="__('Kategori (Opsional)')" class="mb-2" />
                        <select id="kategori" name="kategori" class="block w-full rounded-xl border-border focus:border-primary focus:ring-ring shadow-sm transition">
                            <option value="">Pilih Kategori...</option>
                            <option value="Fiksi">Fiksi</option>
                            <option value="Non-Fiksi">Non-Fiksi</option>
                            <option value="Pelajaran">Pelajaran</option>
                            <option value="Komik">Komik</option>
                            <option value="Novel">Novel</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="alasan" :value="__('Alasan Pengajuan (Opsional)')" class="mb-2" />
                        <textarea id="alasan" name="alasan" class="block w-full rounded-xl border-border focus:border-primary focus:ring-ring shadow-sm transition" rows="4" placeholder="Mengapa buku ini layak ada di perpustakaan?">{{ old('alasan') }}</textarea>
                        <x-input-error :messages="$errors->get('alasan')" class="mt-2" />
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full cursor-pointer bg-primary text-background rounded-xl px-4 py-4 font-bold shadow-lg hover:bg-primary/90 transition-all transform hover:-translate-y-1 hover:shadow-xl flex justify-center items-center gap-2">
                            <span>Kirim Pengajuan</span>
                            <svg class="w-4 h-4 text-background" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
