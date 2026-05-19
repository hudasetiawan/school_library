<x-app-layout>
    <x-slot name="title">Profil Saya</x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        {{-- Page Header --}}
        <div>
            <h1 class="text-2xl font-bold text-foreground tracking-tight">Pengaturan Akun</h1>
            <p class="text-sm text-muted-foreground mt-1">Kelola informasi profil dan keamanan akun Anda.</p>
        </div>

        {{-- Flash Messages --}}
        @if(session('status') === 'profile-updated')
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="bg-primary/10 border border-primary/20 text-primary px-5 py-3.5 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span class="text-sm font-medium">Profil berhasil diperbarui.</span>
            </div>
        @endif

        {{-- Informasi Profil (Read-Only) --}}
        <div class="bg-card rounded-2xl border border-border shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-border">
                <h2 class="text-lg font-bold text-foreground">Informasi Profil</h2>
                <p class="text-sm text-muted-foreground mt-0.5">Data berikut tidak dapat diubah. Hubungi petugas perpustakaan jika ada kesalahan.</p>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-muted-foreground mb-1.5">Nomor Induk (NIS)</label>
                    <input type="text" value="{{ $user->nomor_induk }}" disabled
                           class="block w-full rounded-xl border-border bg-muted py-3 text-sm text-muted-foreground cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-muted-foreground mb-1.5">Nama Lengkap</label>
                    <input type="text" value="{{ $user->name }}" disabled
                           class="block w-full rounded-xl border-border bg-muted py-3 text-sm text-muted-foreground cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-muted-foreground mb-1.5">Kelas</label>
                    <input type="text" value="{{ $user->kelas ?? '—' }}" disabled
                           class="block w-full rounded-xl border-border bg-muted py-3 text-sm text-muted-foreground cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-muted-foreground mb-1.5">Role</label>
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-lg
                        {{ $user->isAdmin() ? 'bg-purple-50 text-purple-700 border border-purple-200/50' : 'bg-blue-50 text-blue-700 border border-blue-200/50' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $user->isAdmin() ? 'bg-purple-500' : 'bg-blue-500' }}"></span>
                        {{ $user->isAdmin() ? 'Administrator' : 'Siswa' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Update Email --}}
        <div class="bg-card rounded-2xl border border-border shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-border">
                <h2 class="text-lg font-bold text-foreground">Alamat Email</h2>
                <p class="text-sm text-muted-foreground mt-0.5">Perbarui alamat email yang terhubung dengan akun Anda.</p>
            </div>
            <form method="POST" action="{{ route('profile.update') }}" class="p-6">
                @csrf
                @method('patch')

                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-xs font-bold uppercase tracking-wider text-muted-foreground mb-1.5" />
                    <x-text-input id="email" name="email" type="email"
                                  class="block w-full rounded-xl border-border bg-muted focus:border-ring focus:ring-ring/20 py-3"
                                  :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-1.5" :messages="$errors->get('email')" />
                </div>

                <div class="mt-5 flex items-center gap-3">
                    <button type="submit"
                            class="cursor-pointer inline-flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-primary/90 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Email
                    </button>
                </div>
            </form>
        </div>

        {{-- Update Password --}}
        <div class="bg-card rounded-2xl border border-border shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-border">
                <h2 class="text-lg font-bold text-foreground">Ganti Kata Sandi</h2>
                <p class="text-sm text-muted-foreground mt-0.5">Pastikan akun Anda menggunakan kata sandi yang kuat dan unik.</p>
            </div>
            <form method="POST" action="{{ route('password.update') }}" class="p-6 space-y-4">
                @csrf
                @method('put')

                <div>
                    <x-input-label for="current_password" :value="__('Password Saat Ini')" class="text-xs font-bold uppercase tracking-wider text-muted-foreground mb-1.5" />
                    <x-text-input id="current_password" name="current_password" type="password"
                                  class="block w-full rounded-xl border-border bg-muted focus:border-ring focus:ring-ring/20 py-3"
                                  autocomplete="current-password" placeholder="Masukkan password saat ini" />
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Password Baru')" class="text-xs font-bold uppercase tracking-wider text-muted-foreground mb-1.5" />
                    <x-text-input id="password" name="password" type="password"
                                  class="block w-full rounded-xl border-border bg-muted focus:border-ring focus:ring-ring/20 py-3"
                                  autocomplete="new-password" placeholder="Minimal 8 karakter" />
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" class="text-xs font-bold uppercase tracking-wider text-muted-foreground mb-1.5" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                                  class="block w-full rounded-xl border-border bg-muted focus:border-ring focus:ring-ring/20 py-3"
                                  autocomplete="new-password" placeholder="Ulangi password baru" />
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1.5" />
                </div>

                <div class="pt-2 flex items-center gap-3">
                    <button type="submit"
                            class="cursor-pointer inline-flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-primary/90 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Perbarui Password
                    </button>

                    @if (session('status') === 'password-updated')
                        <p x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                           x-transition class="text-sm text-primary font-medium">Password berhasil diperbarui!</p>
                    @endif
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
