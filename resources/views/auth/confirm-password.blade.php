<x-guest-layout>
    <x-slot name="title">Konfirmasi Password</x-slot>

    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-foreground tracking-tight">Konfirmasi Password</h2>
        <p class="text-muted-foreground mt-2 text-sm">Ini adalah area aman. Harap konfirmasi password Anda sebelum melanjutkan.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="mb-1 text-xs font-bold uppercase tracking-wider text-muted-foreground ml-1" />
            <x-text-input id="password" class="block mt-1 w-full rounded-xl border-border bg-muted focus:border-primary focus:ring-ring/20 py-3"
                            type="password"
                            name="password"
                            required autocomplete="current-password" 
                            placeholder="Masukan password Anda" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-primary text-white cursor-pointer rounded-xl px-4 py-3.5 font-bold shadow-lg hover:bg-primary/90 transition-all transform hover:-translate-y-1 hover:shadow-xl flex justify-center items-center gap-2">
                {{ __('Konfirmasi') }}
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </button>
        </div>
    </form>
</x-guest-layout>
