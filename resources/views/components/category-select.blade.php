{{-- Category Dropdown with "+ Kategori Baru" inline modal --}}
@props(['categories', 'selected' => null])

<div x-data="categoryDropdown()" class="space-y-1.5">
    <label for="category_id" class="block text-sm font-medium text-foreground mb-1.5">Kategori <span class="text-red-400">*</span></label>

    <div class="flex items-center gap-2">
        {{-- Dropdown --}}
        <select id="category_id" name="category_id" required x-ref="categorySelect"
                class="flex-1 px-4 py-2.5 bg-input text-foreground border border-border rounded-xl text-sm transition-colors duration-200 cursor-pointer hover:bg-secondary/50 focus:bg-secondary focus:ring-2 focus:ring-ring/20 focus:border-ring appearance-none"
                style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpath d=%27M6 9l6 6 6-6%27/%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;">
            <option value="">— Pilih Kategori —</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ (old('category_id', $selected) == $category->id) ? 'selected' : '' }}>
                    {{ $category->nama_kategori }}
                </option>
            @endforeach
        </select>

        {{-- Tombol "+ Kategori Baru" --}}
        <button type="button" @click="showModal = true"
                class="cursor-pointer flex-shrink-0 inline-flex items-center gap-1.5 bg-primary/10 text-primary px-3.5 py-2.5 rounded-xl text-sm font-semibold hover:bg-primary/20 transition-colors border border-primary/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            <span class="hidden sm:inline">Kategori Baru</span>
        </button>
    </div>

    <x-input-error :messages="$errors->get('category_id')" class="mt-1" />

    {{-- Modal --}}
    <div x-show="showModal" x-cloak
         x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-foreground/50 backdrop-blur-sm"
         @keydown.escape.window="closeModal()">

        <div @click.away="closeModal()"
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
             class="bg-card rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden">

            {{-- Modal Header --}}
            <div class="px-6 py-5 border-b border-border flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-card-foreground">Tambah Kategori</h3>
                    <p class="text-xs text-muted-foreground mt-0.5">Kategori baru akan langsung tersedia.</p>
                </div>
                <button type="button" @click="closeModal()" class="cursor-pointer p-1.5 text-muted-foreground hover:text-foreground hover:bg-muted rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-6">
                <div class="mb-4">
                    <label class="block text-xs font-bold uppercase tracking-wider text-muted-foreground mb-1.5">Nama Kategori</label>
                    <input type="text" x-model="newCategoryName" x-ref="modalInput"
                           @keydown.enter.prevent="submitCategory()"
                           class="w-full px-4 py-2.5 bg-input border border-border rounded-xl text-sm focus:ring-2 focus:ring-ring/20 focus:border-ring focus:bg-card transition-all placeholder:text-muted-foreground"
                           :class="errorMessage ? 'border-red-300 focus:border-red-400 focus:ring-red-500/20' : ''"
                           placeholder="Contoh: Fiksi, Teknologi...">
                    {{-- Error Message --}}
                    <p x-show="errorMessage" x-text="errorMessage" x-cloak
                       class="text-xs text-red-600 font-medium mt-1.5"></p>
                    {{-- Success Message --}}
                    <p x-show="successMessage" x-text="successMessage" x-cloak
                       class="text-xs text-emerald-600 font-medium mt-1.5"></p>
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="px-6 py-4 bg-muted/80 border-t border-border flex items-center justify-end gap-3">
                <button type="button" @click="closeModal()"
                        class="cursor-pointer text-sm text-muted-foreground hover:text-foreground font-medium transition-colors px-4 py-2">
                    Batal
                </button>
                <button type="button" @click="submitCategory()" :disabled="loading"
                        class="cursor-pointer inline-flex items-center gap-2 bg-primary text-primary-foreground px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-primary/90 transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <svg x-show="!loading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span x-text="loading ? 'Menyimpan...' : 'Simpan'"></span>
                </button>
            </div>
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
function categoryDropdown() {
    return {
        showModal: false,
        newCategoryName: '',
        errorMessage: '',
        successMessage: '',
        loading: false,

        closeModal() {
            this.showModal = false;
            this.newCategoryName = '';
            this.errorMessage = '';
            this.successMessage = '';
        },

        async submitCategory() {
            this.errorMessage = '';
            this.successMessage = '';

            const name = this.newCategoryName.trim();
            if (!name) {
                this.errorMessage = 'Nama kategori wajib diisi.';
                return;
            }

            this.loading = true;

            try {
                const response = await fetch("{{ route('admin.categories.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ nama_kategori: name }),
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    // Append new option to select
                    const select = this.$refs.categorySelect;
                    const option = new Option(data.category.nama, data.category.id, true, true);
                    select.appendChild(option);

                    this.successMessage = data.message;

                    // Close modal after brief delay
                    setTimeout(() => {
                        this.closeModal();
                    }, 600);
                } else {
                    // Validation error
                    if (data.errors && data.errors.nama_kategori) {
                        this.errorMessage = data.errors.nama_kategori[0];
                    } else {
                        this.errorMessage = data.message || 'Terjadi kesalahan saat menyimpan.';
                    }
                }
            } catch (err) {
                this.errorMessage = 'Gagal terhubung ke server. Coba lagi.';
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
@endpush
@endonce
