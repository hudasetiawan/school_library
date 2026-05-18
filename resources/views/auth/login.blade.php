<x-guest-layout>
    <x-slot name="title">Login</x-slot>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-foreground tracking-tight">Selamat Datang Kembali</h2>
        <p class="text-muted-foreground mt-2 text-sm">Masuk untuk mengakses akun perpustakaan Anda.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="mb-1 text-xs font-bold uppercase tracking-wider text-muted-foreground ml-1" />
            <x-text-input id="email" class="block mt-1 w-full rounded-xl border-border bg-muted focus:border-primary focus:ring-ring/20 py-3" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="mb-1 text-xs font-bold uppercase tracking-wider text-muted-foreground ml-1" />

            <x-text-input id="password" class="block mt-1 w-full rounded-xl border-border bg-muted focus:border-primary focus:ring-ring/20 py-3"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-border text-primary shadow-sm focus:ring-ring" name="remember">
                <span class="ms-2 text-sm text-muted-foreground">{{ __('Ingat Saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-muted-foreground hover:text-foreground rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ring" href="{{ route('password.request') }}">
                    {{ __('Lupa Password?') }}
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-primary text-background cursor-pointer rounded-xl px-4 py-3.5 font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all transform hover:-translate-y-1 hover:shadow-xl flex justify-center items-center gap-2">
                {{ __('Masuk Sekarang') }}
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>
        
        <div class="text-center mt-6">
            <p class="text-sm text-muted-foreground">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-bold text-foreground hover:text-primary transition-colors">Daftar disini</a>
            </p>
        </div>
    </form>
</x-guest-layout>
