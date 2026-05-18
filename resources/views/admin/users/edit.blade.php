<x-app-layout>
    <x-slot name="title">Edit Pengguna: {{ $user->name }}</x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        {{-- Page Header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.index') }}" class="p-2 bg-card border border-border rounded-xl hover:bg-muted transition-colors">
                <svg class="w-5 h-5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-foreground tracking-tight">Edit Pengguna</h1>
                <p class="text-sm text-muted-foreground mt-0.5">Ubah data akun <strong>{{ $user->name }}</strong>.</p>
            </div>
        </div>

        <div class="bg-card rounded-2xl border border-border shadow-sm overflow-hidden">
            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-6 space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <x-input-label for="nomor_induk" :value="__('Nomor Induk (NIS/NIP)')" class="text-xs font-bold uppercase tracking-wider text-muted-foreground mb-1.5" />
                        <x-text-input id="nomor_induk" name="nomor_induk" type="text" :value="old('nomor_induk', $user->nomor_induk)" required
                                      class="block w-full rounded-xl border-border bg-muted focus:border-ring focus:ring-ring/20 py-3" />
                        <x-input-error :messages="$errors->get('nomor_induk')" class="mt-1.5" />
                    </div>
                    <div>
                        <x-input-label for="name" :value="__('Nama Lengkap')" class="text-xs font-bold uppercase tracking-wider text-muted-foreground mb-1.5" />
                        <x-text-input id="name" name="name" type="text" :value="old('name', $user->name)" required
                                      class="block w-full rounded-xl border-border bg-muted focus:border-ring focus:ring-ring/20 py-3" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
                    </div>
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-xs font-bold uppercase tracking-wider text-muted-foreground mb-1.5" />
                    <x-text-input id="email" name="email" type="email" :value="old('email', $user->email)" required
                                  class="block w-full rounded-xl border-border bg-muted focus:border-ring focus:ring-ring/20 py-3" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <x-input-label for="role" :value="__('Role')" class="text-xs font-bold uppercase tracking-wider text-muted-foreground mb-1.5" />
                        <select id="role" name="role" required class="block w-full rounded-xl border-border bg-muted focus:border-ring focus:ring-ring/20 py-3 text-sm appearance-none"
                                style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpath d=%27M6 9l6 6 6-6%27/%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;">
                            <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>Siswa</option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-1.5" />
                    </div>
                    <div>
                        <x-input-label for="kelas" :value="__('Kelas')" class="text-xs font-bold uppercase tracking-wider text-muted-foreground mb-1.5" />
                        <select id="kelas" name="kelas" class="block w-full rounded-xl border-border bg-muted focus:border-ring focus:ring-ring/20 py-3 text-sm appearance-none"
                                style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpath d=%27M6 9l6 6 6-6%27/%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;">
                            <option value="">— Kosong (Admin) —</option>
                            @foreach(['X AKL 1','X AKL 2','X AKL 3','XI AKL 1','XI AKL 2','XI AKL 3','XII AKL 1','XII AKL 2','XII AKL 3','X MPLB 1','X MPLB 2','X MPLB 3','XI MPLB 1','XI MPLB 2','XI MPLB 3','XII MPLB 1','XII MPLB 2','XII MPLB 3','X PM 1','X PM 2','XI PM 1','XI PM 2','XII PM 1','XII PM 2','X PPLG 1','X PPLG 2','X PPLG 3','XI PPLG 1','XI PPLG 2','XI PPLG 3','XII PPLG 1','XII PPLG 2','XII PPLG 3'] as $k)
                                <option value="{{ $k }}" {{ old('kelas', $user->kelas) === $k ? 'selected' : '' }}>{{ $k }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('kelas')" class="mt-1.5" />
                    </div>
                </div>

                <div class="border-t border-border pt-5">
                    <p class="text-xs text-muted-foreground mb-3 font-medium">Kosongkan password jika tidak ingin mengubahnya.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="password" :value="__('Password Baru')" class="text-xs font-bold uppercase tracking-wider text-muted-foreground mb-1.5" />
                            <x-text-input id="password" name="password" type="password"
                                          class="block w-full rounded-xl border-border bg-muted focus:border-ring focus:ring-ring/20 py-3" placeholder="Opsional" />
                            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                        </div>
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-xs font-bold uppercase tracking-wider text-muted-foreground mb-1.5" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                                          class="block w-full rounded-xl border-border bg-muted focus:border-ring focus:ring-ring/20 py-3" placeholder="Opsional" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="inline-flex items-center gap-2 bg-primary text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-primary/90 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="text-sm text-muted-foreground hover:text-foreground font-medium">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
