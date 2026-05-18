<x-guest-layout>
    <x-slot name="title">Verifikasi Email</x-slot>

    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-foreground tracking-tight">Verifikasi Email</h2>
    </div>

    <div class="mb-6 text-sm text-muted-foreground bg-muted p-4 rounded-xl border border-border">
        {{ __('Terima kasih telah mendaftar! Sebelum memulai, bisakah Anda memverifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan ke email Anda? Jika Anda tidak menerima email tersebut, kami dengan senang hati akan mengirimkan yang baru.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 font-medium text-sm text-primary bg-primary/10 p-4 rounded-xl border border-primary/10">
            {{ __('Tautan verifikasi baru telah dikirimkan ke alamat email yang Anda berikan saat pendaftaran.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between gap-4 flex-col md:flex-row">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full">
            @csrf

            <button type="submit" class="w-full bg-foreground text-background rounded-xl px-4 py-3.5 font-bold shadow-lg hover:bg-black transition-all transform hover:-translate-y-1 hover:shadow-xl">
                {{ __('Kirim Ulang Email Verifikasi') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf

            <button type="submit" class="w-full bg-card text-foreground border border-border rounded-xl px-4 py-3.5 font-bold hover:bg-muted transition-colors shadow-sm">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
