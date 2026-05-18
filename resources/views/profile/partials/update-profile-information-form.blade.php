<section>
    <header>
        <h2 class="text-lg font-medium text-foreground">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-muted-foreground">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-foreground">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-muted-foreground hover:text-foreground rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ring">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-primary">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Kelas -->
        <div>
            <x-input-label for="kelas" :value="__('Kelas')" />
            <select id="kelas" name="kelas"
                    class="mt-1 block w-full rounded-md border-border shadow-sm focus:border-ring focus:ring-ring text-sm appearance-none"
                    style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpath d=%27M6 9l6 6 6-6%27/%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;">
                <option value="">— Pilih Kelas —</option>
                @foreach([
                    // Akuntansi (AKL)
                    'X AKL 1', 'X AKL 2', 'X AKL 3',
                    'XI AKL 1', 'XI AKL 2', 'XI AKL 3',
                    'XII AKL 1', 'XII AKL 2', 'XII AKL 3',
                    
                    // Perkantoran (MPLB)
                    'X MPLB 1', 'X MPLB 2', 'X MPLB 3',
                    'XI MPLB 1', 'XI MPLB 2', 'XI MPLB 3',
                    'XII MPLB 1', 'XII MPLB 2', 'XII MPLB 3',
                    
                    // Pemasaran (PM)
                    'X PM 1', 'X PM 2',
                    'XI PM 1', 'XI PM 2',
                    'XII PM 1', 'XII PM 2',
                    
                    // Pengembangan Perangkat Lunak dan Gim (PPLG)
                    'X PPLG 1', 'X PPLG 2', 'X PPLG 3',
                    'XI PPLG 1', 'XI PPLG 2', 'XI PPLG 3',
                    'XII PPLG 1', 'XII PPLG 2', 'XII PPLG 3'
                ] as $k)
                    <option value="{{ $k }}" {{ old('kelas', $user->kelas ?? '') === $k ? 'selected' : '' }}>
                        {{ $k }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('kelas')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-muted-foreground"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
