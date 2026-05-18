<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' — ' . config('app.name', 'Perpustakaan') : config('app.name', 'Perpustakaan') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-foreground bg-background relative">
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false, sidebarCollapsed: false, sidebarReady: false }" x-init="setTimeout(() => sidebarReady = true, 150)">

        {{-- Mobile Sidebar Overlay --}}
        <div x-show="sidebarOpen" x-cloak
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false"
            class="fixed inset-0 bg-foreground/50 backdrop-blur-sm z-40 md:hidden"></div>

        {{-- Sidebar --}}
        <aside class="flex-shrink-0 flex-col bg-card border-r border-border z-50 fixed md:relative inset-y-0 left-0"
            :class="[
                sidebarReady ? 'transition-all duration-300' : '',
                sidebarOpen ? 'flex w-72' : 'hidden md:flex',
                sidebarCollapsed ? 'md:w-20' : 'md:w-72'
            ]">
            <a href="{{ route('dashboard') }}" class="block border-b border-border" :class="[sidebarReady ? 'transition-all duration-300' : '', sidebarCollapsed ? 'p-4 flex items-center justify-center' : 'p-8 flex items-center justify-center flex-col']">
                <div class="p-2 bg-muted rounded-xl flex-shrink-0" :class="sidebarCollapsed ? 'mb-0' : 'mb-4'">
                    <img src="{{ asset('images/logo.webp') }}" alt="Logo Perpustakaan" class="h-10 w-10 object-contain flex-shrink-0">
                </div>
                <h1 x-show="!sidebarCollapsed" x-transition:enter="transition ease-out duration-200 delay-100" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    class="text-md font-bold text-foreground text-center tracking-tight leading-tight uppercase">Perpustakaan<br><span class="text-muted-foreground font-normal text-sm">SMKN 2 Magelang</span></h1>
            </a>

            <nav class="flex-1 overflow-y-auto py-6 space-y-2" :class="[sidebarReady ? 'transition-all duration-300' : '', sidebarCollapsed ? 'px-2' : 'px-4']">
                <div>
                    <p x-show="!sidebarCollapsed" class="px-4 text-xs font-bold text-muted-foreground uppercase tracking-wider mb-2">Menu Utama</p>
                    <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="home">
                        Dashboard
                    </x-sidebar-link>
                </div>

                <div class="flex flex-col gap-2">
                    @if(auth()->user()->isAdmin())
                    <p x-show="!sidebarCollapsed" class="px-4 text-xs font-bold text-muted-foreground uppercase tracking-wider mt-6 mb-2">Administrator</p>
                    <x-sidebar-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" icon="user-group">
                        Kelola Pengguna
                    </x-sidebar-link>
                    <x-sidebar-link :href="route('admin.books.index')" :active="request()->routeIs('admin.books.*')" icon="book-open">
                        Kelola Buku
                    </x-sidebar-link>
                    <x-sidebar-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')" icon="tag">
                        Kategori Buku
                    </x-sidebar-link>
                    <x-sidebar-link :href="route('admin.borrowings.index')" :active="request()->routeIs('admin.borrowings.*')" icon="switch-horizontal">
                        Transaksi
                    </x-sidebar-link>
                    <x-sidebar-link :href="route('admin.requests.index')" :active="request()->routeIs('admin.requests.*')" icon="plus-circle">
                        Pengajuan Buku
                    </x-sidebar-link>
                    @else
                    <p x-show="!sidebarCollapsed" class="px-4 text-xs font-bold text-muted-foreground uppercase tracking-wider mt-6 mb-2">Member Area</p>
                    <x-sidebar-link :href="route('books.index')" :active="request()->routeIs('books.*')" icon="book-open">
                        Daftar Buku
                    </x-sidebar-link>
                    <x-sidebar-link :href="route('borrowings.index')" :active="request()->routeIs('borrowings.index')" icon="collection">
                        Peminjaman Saya
                    </x-sidebar-link>
                    <x-sidebar-link :href="route('requests.index')" :active="request()->routeIs('requests.*')" icon="plus-circle">
                        Pengajuan Buku
                    </x-sidebar-link>
                    @endif
                </div>
            </nav>

            {{-- Sidebar Footer --}}
            <div class="border-t border-border bg-muted/50">

                {{-- User Info --}}
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 group rounded-xl hover:bg-card transition-colors" :class="sidebarCollapsed ? 'justify-center p-3' : 'px-7 py-4'">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background={{ Auth::user()->isAdmin() ? 'd1fae5' : 'e0e7ff' }}&color={{ Auth::user()->isAdmin() ? '059669' : '4f46e5' }}&size=36&font-size=0.4&bold=true"
                        alt="Avatar" class="w-9 h-9 rounded-full flex-shrink-0">
                    <div x-show="!sidebarCollapsed" class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-foreground truncate group-hover:text-primary transition-colors">
                            {{ Auth::user()->name }}
                        </p>
                        <p class="text-[11px] text-muted-foreground truncate">{{ Auth::user()->isAdmin() ? 'Administrator' : Auth::user()->kelas ?? 'Siswa' }}</p>
                    </div>
                </a>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col h-screen overflow-hidden relative bg-background">

            {{-- Topbar --}}
            <header class="bg-card border-b border-border px-4 md:px-8 h-16 flex items-center justify-between z-20 flex-shrink-0">
                {{-- Left: Mobile hamburger + Page context --}}
                <div class="flex items-center gap-3">
                    {{-- Mobile hamburger --}}
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-muted-foreground p-2 rounded-xl hover:bg-muted transition-colors cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    {{-- Desktop sidebar toggle --}}
                    <button @click="sidebarCollapsed = !sidebarCollapsed" class="hidden md:flex text-muted-foreground p-2 rounded-xl hover:bg-muted hover:text-foreground transition-colors cursor-pointer" title="Toggle sidebar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div class="hidden md:flex items-center gap-2">
                        <span class="text-sm text-muted-foreground">
                            @if(auth()->user()->isAdmin())
                            Panel Admin
                            @else
                            Perpustakaan
                            @endif
                        </span>
                    </div>
                </div>

                {{-- Right: User dropdown --}}
                <div class="relative" x-data="{ profileOpen: false }">
                    <button @click="profileOpen = !profileOpen"
                        class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-muted cursor-pointer transition-colors duration-200 focus:outline-none"
                        :class="profileOpen ? 'bg-muted' : ''">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-semibold text-foreground leading-tight">{{ Auth::user()->name }}</p>
                            <p class="text-[11px] text-muted-foreground leading-tight">{{ Auth::user()->isAdmin() ? 'Administrator' : Auth::user()->kelas ?? 'Siswa' }}</p>
                        </div>
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background={{ Auth::user()->isAdmin() ? 'd1fae5' : 'e0e7ff' }}&color={{ Auth::user()->isAdmin() ? '059669' : '4f46e5' }}&size=36&font-size=0.4&bold=true"
                            alt="Avatar" class="w-9 h-9 rounded-full flex-shrink-0">
                        <svg class="w-4 h-4 text-muted-foreground transition-transform duration-200" :class="profileOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    {{-- Dropdown Menu --}}
                    <div x-show="profileOpen" x-cloak
                        @click.away="profileOpen = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                        class="absolute right-0 mt-2 w-56 bg-card rounded-xl shadow-lg border border-border py-1.5 z-50">

                        {{-- User Info Header --}}
                        <div class="px-4 py-3 border-b border-border">
                            <p class="text-sm font-bold text-foreground truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-muted-foreground truncate">{{ Auth::user()->email }}</p>
                        </div>

                        {{-- Menu Items --}}
                        <div class="py-1.5">
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-card-foreground hover:bg-muted hover:text-primary transition-colors group">
                                <svg class="w-4 h-4 text-muted-foreground group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="font-medium">Profil Saya</span>
                            </a>
                        </div>

                        {{-- Logout --}}
                        <div class="border-t border-border pt-1.5">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="flex items-center gap-3 w-full px-4 py-2.5 text-sm cursor-pointer text-red-600 hover:bg-red-50 transition-colors group">
                                    <svg class="w-4 h-4 text-red-400 group-hover:text-red-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span class="font-medium">Keluar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto w-full p-4 md:p-10 scroll-smooth">
                {{ $slot }}
            </main>
        </div>

    </div>
    @stack('scripts')
</body>

</html>