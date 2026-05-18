<x-guest-layout>
    <x-slot name="title">Daftar Akun</x-slot>

    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-foreground tracking-tight">Bergabung Bersama Kami</h2>
        <p class="text-muted-foreground mt-2 text-sm">Buat akun untuk mulai meminjam buku.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Nomor Induk (NIS) -->
        <div>
            <x-input-label for="nomor_induk" :value="__('Nomor Induk Siswa (NIS)')" class="mb-1 text-xs font-bold uppercase tracking-wider text-muted-foreground ml-1" />
            <x-text-input id="nomor_induk" class="block mt-1 w-full rounded-xl border-border bg-muted focus:border-primary focus:ring-ring/20 py-3" type="text" name="nomor_induk" :value="old('nomor_induk')" required autofocus autocomplete="off" placeholder="Contoh: 12345" />
            <x-input-error :messages="$errors->get('nomor_induk')" class="mt-1.5" />
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="mb-1 text-xs font-bold uppercase tracking-wider text-muted-foreground ml-1" />
            <x-text-input id="name" class="block mt-1 w-full rounded-xl border-border bg-muted focus:border-primary focus:ring-ring/20 py-3" type="text" name="name" :value="old('name')" required autocomplete="name" placeholder="Nama Lengkap" />
            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="mb-1 text-xs font-bold uppercase tracking-wider text-muted-foreground ml-1" />
            <x-text-input id="email" class="block mt-1 w-full rounded-xl border-border bg-muted focus:border-primary focus:ring-ring/20 py-3" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Kelas -->
        <div>
            <x-input-label for="kelas" :value="__('Kelas')" class="mb-1 text-xs font-bold uppercase tracking-wider text-muted-foreground ml-1" />
            <select id="kelas" name="kelas" required
                    class="block mt-1 w-full rounded-xl border-border bg-muted focus:border-primary focus:ring-ring/20 py-3 text-sm appearance-none"
                    style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpath d=%27M6 9l6 6 6-6%27/%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;">
                <option value="">— Pilih Kelas —</option>
                @foreach([
                    'X AKL 1', 'X AKL 2', 'X AKL 3',
                    'XI AKL 1', 'XI AKL 2', 'XI AKL 3',
                    'XII AKL 1', 'XII AKL 2', 'XII AKL 3',
                    'X MPLB 1', 'X MPLB 2', 'X MPLB 3',
                    'XI MPLB 1', 'XI MPLB 2', 'XI MPLB 3',
                    'XII MPLB 1', 'XII MPLB 2', 'XII MPLB 3',
                    'X PM 1', 'X PM 2',
                    'XI PM 1', 'XI PM 2',
                    'XII PM 1', 'XII PM 2',
                    'X PPLG 1', 'X PPLG 2', 'X PPLG 3',
                    'XI PPLG 1', 'XI PPLG 2', 'XI PPLG 3',
                    'XII PPLG 1', 'XII PPLG 2', 'XII PPLG 3'
                ] as $k)
                    <option value="{{ $k }}" {{ old('kelas') === $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('kelas')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="mb-1 text-xs font-bold uppercase tracking-wider text-muted-foreground ml-1" />
            <x-text-input id="password" class="block mt-1 w-full rounded-xl border-border bg-muted focus:border-primary focus:ring-ring/20 py-3"
                            type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="mb-1 text-xs font-bold uppercase tracking-wider text-muted-foreground ml-1" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-xl border-border bg-muted focus:border-primary focus:ring-ring/20 py-3"
                            type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-primary text-white cursor-pointer rounded-xl px-4 py-3.5 font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all transform hover:-translate-y-1 hover:shadow-xl flex justify-center items-center gap-2">
                {{ __('Daftar Sekarang') }}
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-muted-foreground">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-bold text-foreground hover:text-primary transition-colors">Masuk disini</a>
            </p>
        </div>
    </form>
</x-guest-layout>
