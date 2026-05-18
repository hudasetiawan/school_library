<x-app-layout>
    <x-slot name="title">Kategori Buku</x-slot>

    <div class="space-y-6" x-data="{
        showAddModal: false,
        showEditModal: false,
        editId: null,
        editName: '',
        openEdit(id, name) {
            this.editId = id;
            this.editName = name;
            this.showEditModal = true;
            $nextTick(() => $refs.editInput.focus());
        }
    }">
        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-foreground tracking-tight">Kategori Buku</h1>
                <p class="text-sm text-muted-foreground mt-1">Kelola kategori untuk klasifikasi koleksi buku perpustakaan.</p>
            </div>

            <button @click="showAddModal = true; $nextTick(() => $refs.addInput.focus())" type="button"
                    class="inline-flex items-center gap-2 bg-primary text-primary-foreground px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-primary/90 transition-colors shadow-sm cursor-pointer self-start">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Kategori
            </button>
        </div>

        {{-- Search & Filter Bar --}}
        <div class="bg-card rounded-2xl border border-border shadow-sm p-5">
            <form action="{{ route('admin.categories.index') }}" method="GET" class="flex flex-col lg:flex-row gap-3">
                {{-- Search Input --}}
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           placeholder="Cari nama kategori..."
                           class="w-full pl-10 pr-4 py-2.5 border border-border rounded-xl text-sm focus:ring-2 focus:ring-ring/20 focus:border-ring focus:bg-card transition-all placeholder:text-muted-foreground">
                </div>

                {{-- Status Filter --}}
                <div class="sm:w-52">
                    <select name="status" class="w-full py-2.5 px-3.5 bg-card text-foreground border border-border rounded-xl text-sm transition-colors duration-200 cursor-pointer hover:bg-secondary/50 focus:bg-secondary focus:ring-2 focus:ring-ring/20 focus:border-ring appearance-none"
                        style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpath d=%27M6 9l6 6 6-6%27/%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;">
                        <option value="" class="bg-card text-foreground">Semua Kategori</option>
                        <option value="terisi" class="bg-card text-foreground" {{ ($status ?? '') === 'terisi' ? 'selected' : '' }}>Terisi (> 0 Buku)</option>
                        <option value="kosong" class="bg-card text-foreground" {{ ($status ?? '') === 'kosong' ? 'selected' : '' }}>Kosong (0 Buku)</option>
                    </select>
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-2">
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-primary text-primary-foreground px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-primary/90 transition-colors shadow-sm cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center gap-1.5 bg-muted text-muted-foreground px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-muted/80 transition-colors">
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
                <span>Menampilkan <strong class="text-foreground">{{ $categories->total() }}</strong> hasil
                    @if($search) untuk "<strong class="text-foreground">{{ $search }}</strong>"@endif
                    @if($status) filter <strong class="text-foreground">{{ $status === 'terisi' ? 'Terisi' : 'Kosong' }}</strong>@endif
                </span>
            </div>
        @endif

        {{-- Validation Error --}}
        @if($errors->has('nama_kategori'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-5 py-3.5 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                <span class="text-sm font-medium">{{ $errors->first('nama_kategori') }}</span>
            </div>
        @endif

        {{-- Flash Messages --}}
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                 x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="bg-primary/10 border border-primary/20 text-primary px-5 py-3.5 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
                 x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="bg-red-50 border border-red-200 text-red-800 px-5 py-3.5 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Categories Table --}}
        <div class="bg-card rounded-2xl border border-border shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-border">
                    <thead>
                        <tr class="bg-muted">
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wider w-12">No</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wider">Nama Kategori</th>
                            <th class="px-6 py-3.5 text-center text-xs font-semibold text-muted-foreground uppercase tracking-wider w-40">Jumlah Buku</th>
                            <th class="px-6 py-3.5 text-right text-xs font-semibold text-muted-foreground uppercase tracking-wider w-48">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($categories as $category)
                            <tr class="hover:bg-muted/50 transition-colors">
                                <td class="px-6 py-4 text-sm text-muted-foreground">
                                    {{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"></path></svg>
                                        </div>
                                        <span class="text-sm font-semibold text-foreground">{{ $category->nama_kategori }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center gap-1.5 bg-muted text-muted-foreground text-xs font-semibold px-3 py-1.5 rounded-lg">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        {{ $category->books_count }} buku
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button type="button"
                                                @click="openEdit({{ $category->id }}, '{{ addslashes($category->nama_kategori) }}')"
                                                class="cursor-pointer inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-amber-100 transition-colors border border-amber-200/50">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            Edit
                                        </button>
                                        <x-confirm-modal
                                            :action="route('admin.categories.destroy', $category)"
                                            method="DELETE"
                                            title="Hapus Kategori?"
                                            message="Hapus kategori <strong class='text-foreground'>{{ $category->nama_kategori }}</strong>?<br><br><span class='text-xs'>Kategori yang masih memiliki buku tidak dapat dihapus.</span>"
                                            confirmText="Ya, Hapus"
                                            confirmColor="red"
                                            iconType="trash">
                                            <button type="button"
                                                    class="cursor-pointer inline-flex items-center gap-1.5 bg-red-50 text-red-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-red-100 transition-colors border border-red-200/50">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                Hapus
                                            </button>
                                        </x-confirm-modal>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-muted rounded-2xl flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"></path></svg>
                                        </div>
                                        <p class="text-sm font-medium text-foreground">
                                            @if($search || $status)
                                                Tidak ada kategori ditemukan
                                            @else
                                                Belum ada kategori
                                            @endif
                                        </p>
                                        <p class="text-xs text-muted-foreground mt-1">
                                            @if($search || $status)
                                                Coba ubah kata kunci pencarian atau filter.
                                            @else
                                                Klik tombol "Tambah Kategori" di atas untuk memulai.
                                            @endif
                                        </p>
                                        @if($search || $status)
                                            <a href="{{ route('admin.categories.index') }}" class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-primary hover:text-primary/80 transition-colors">
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
            <div class="px-6 py-4 border-t border-border">
                <x-pagination :paginator="$categories" :perPage="$perPage" />
            </div>
        </div>

        {{-- ==================== MODAL TAMBAH KATEGORI ==================== --}}
        <div x-show="showAddModal" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showAddModal = false"></div>

            {{-- Modal Content --}}
            <div class="relative bg-card rounded-2xl border border-border shadow-xl w-full max-w-md"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 @keydown.escape.window="showAddModal = false">

                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-5 border-b border-border">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-foreground">Tambah Kategori</h3>
                            <p class="text-xs text-muted-foreground">Buat kategori baru untuk koleksi buku.</p>
                        </div>
                    </div>
                    <button @click="showAddModal = false" type="button" class="p-2 text-muted-foreground hover:text-foreground hover:bg-muted rounded-xl transition-colors cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                {{-- Body --}}
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="px-6 py-6">
                        <label for="add_nama_kategori" class="block text-xs font-bold uppercase tracking-wider text-muted-foreground mb-2 ml-0.5">Nama Kategori</label>
                        <input type="text" id="add_nama_kategori" name="nama_kategori" required x-ref="addInput"
                               class="block w-full px-4 py-3 bg-muted border border-border rounded-xl text-sm focus:ring-2 focus:ring-ring/20 focus:border-ring transition-all placeholder:text-muted-foreground"
                               placeholder="Contoh: Fiksi, Sains, Sejarah...">
                    </div>

                    {{-- Footer --}}
                    <div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-border bg-muted/30 rounded-b-2xl">
                        <button type="button" @click="showAddModal = false"
                                class="cursor-pointer inline-flex items-center gap-1.5 px-4 py-2.5 bg-muted text-muted-foreground rounded-xl text-sm font-semibold hover:bg-muted/80 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                                class="cursor-pointer inline-flex items-center gap-2 bg-primary text-primary-foreground px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-primary/90 transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ==================== MODAL EDIT KATEGORI ==================== --}}
        <div x-show="showEditModal" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showEditModal = false"></div>

            {{-- Modal Content --}}
            <div class="relative bg-card rounded-2xl border border-border shadow-xl w-full max-w-md"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 @keydown.escape.window="showEditModal = false">

                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-5 border-b border-border">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center border border-amber-200/50">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-foreground">Edit Kategori</h3>
                            <p class="text-xs text-muted-foreground">Ubah nama kategori yang dipilih.</p>
                        </div>
                    </div>
                    <button @click="showEditModal = false" type="button" class="p-2 text-muted-foreground hover:text-foreground hover:bg-muted rounded-xl transition-colors cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                {{-- Body --}}
                <form :action="`{{ url('admin/categories') }}/${editId}`" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="px-6 py-6">
                        <label for="edit_nama_kategori" class="block text-xs font-bold uppercase tracking-wider text-muted-foreground mb-2 ml-0.5">Nama Kategori</label>
                        <input type="text" id="edit_nama_kategori" name="nama_kategori" required x-ref="editInput"
                               x-model="editName"
                               class="block w-full px-4 py-3 bg-muted border border-border rounded-xl text-sm focus:ring-2 focus:ring-ring/20 focus:border-ring transition-all placeholder:text-muted-foreground"
                               placeholder="Nama kategori...">
                    </div>

                    {{-- Footer --}}
                    <div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-border bg-muted/30 rounded-b-2xl">
                        <button type="button" @click="showEditModal = false"
                                class="cursor-pointer inline-flex items-center gap-1.5 px-4 py-2.5 bg-muted text-muted-foreground rounded-xl text-sm font-semibold hover:bg-muted/80 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                                class="cursor-pointer inline-flex items-center gap-2 bg-primary text-primary-foreground px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-primary/90 transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Perbarui
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
