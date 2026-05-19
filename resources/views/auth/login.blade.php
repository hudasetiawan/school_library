<x-guest-layout>
    <x-slot name="title">Login</x-slot>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div x-data="{ showForgotModal: false }">
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

            <!-- Remember Me & Lupa Password -->
            <div class="flex items-center justify-between mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-border text-primary shadow-sm focus:ring-ring" name="remember">
                    <span class="ms-2 text-sm text-muted-foreground">{{ __('Ingat Saya') }}</span>
                </label>

                <button type="button" @click="showForgotModal = true"
                        class="cursor-pointer underline text-sm text-muted-foreground hover:text-foreground rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ring transition-colors">
                    Lupa Password?
                </button>
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

        {{-- Modal Lupa Password --}}
        <div x-show="showForgotModal" x-cloak
             x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-foreground/50 backdrop-blur-sm"
             @keydown.escape.window="showForgotModal = false">

            <div @click.away="showForgotModal = false"
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                 class="bg-card rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden">

                <div class="p-6 text-center">
                    {{-- Icon --}}
                    <div class="mx-auto w-14 h-14 bg-amber-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>

                    {{-- Title --}}
                    <h3 class="text-lg font-bold text-foreground mb-1">Lupa Kata Sandi?</h3>

                    {{-- Message --}}
                    <p class="text-sm text-muted-foreground mb-6 leading-relaxed">
                        Silakan hubungi <strong class="text-foreground">Admin Perpustakaan</strong> untuk mereset kata sandi akun Anda.
                        Sampaikan <strong class="text-foreground">Nama Lengkap</strong> dan <strong class="text-foreground">NIS</strong> (Nomor Induk Siswa) Anda.
                    </p>
                </div>

                {{-- Close Button --}}
                <div class="border-t border-border">
                    <button type="button" @click="showForgotModal = false"
                            class="cursor-pointer w-full py-3.5 text-sm font-semibold text-primary hover:bg-muted transition-colors">
                        Saya Mengerti
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
