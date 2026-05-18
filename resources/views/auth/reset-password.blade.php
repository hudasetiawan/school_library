<x-guest-layout>
    <x-slot name="title">Reset Password</x-slot>

    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-foreground tracking-tight">Reset Password</h2>
        <p class="text-muted-foreground mt-2 text-sm">Buat password baru untuk akun Anda.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="mb-1 text-xs font-bold uppercase tracking-wider text-muted-foreground ml-1" />
            <x-text-input id="email" class="block mt-1 w-full rounded-xl border-border bg-muted focus:border-primary focus:ring-ring/20 py-3" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="mb-1 text-xs font-bold uppercase tracking-wider text-muted-foreground ml-1" />
            <x-text-input id="password" class="block mt-1 w-full rounded-xl border-border bg-muted focus:border-primary focus:ring-ring/20 py-3" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="mb-1 text-xs font-bold uppercase tracking-wider text-muted-foreground ml-1" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-xl border-border bg-muted focus:border-primary focus:ring-ring/20 py-3"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-foreground text-background rounded-xl px-4 py-3.5 font-bold shadow-lg hover:bg-black transition-all transform hover:-translate-y-1 hover:shadow-xl flex justify-center items-center gap-2">
                {{ __('Reset Password') }}
                <svg class="w-4 h-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </button>
        </div>
    </form>
</x-guest-layout>
