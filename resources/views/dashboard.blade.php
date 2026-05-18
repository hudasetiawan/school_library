<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    <div class="space-y-10">
        <!-- Hero Section -->
        <div class="relative bg-card rounded-3xl p-8 md:p-12 shadow-sm border border-border overflow-hidden" data-animate="fade-in-up">
            <div class="relative z-10 max-w-2xl">
                <span class="inline-block py-1 px-3 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider mb-4 border border-primary/10">
                    Selamat Datang
                </span>
                <h1 class="text-4xl md:text-5xl font-bold text-foreground mb-4 tracking-tight leading-tight">
                    Halo, <span class="text-primary">{{ Auth::user()->name }}</span>
                </h1>
                <p class="text-lg text-muted-foreground mb-8 leading-relaxed">
                    Mau baca buku apa hari ini? Telusuri koleksi terbaru kami dan temukan inspirasi barumu.
                </p>

                <!-- Search Component -->
                <div class="bg-card p-2 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-border max-w-lg">
                    <form action="{{ route('books.index') }}" method="GET" class="flex items-center">
                        <div class="relative flex-grow">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </span>
                            <input type="text" name="search" class="w-full pl-11 pr-4 py-3 bg-transparent border-none focus:ring-0 text-foreground placeholder-gray-400 font-medium" placeholder="Cari judul, penulis...">
                        </div>
                        <button type="submit" class="bg-primary text-white px-6 py-3 rounded-xl font-bold cursor-pointer hover:bg-primary/90 transition-colors shadow-lg">
                            Cari
                        </button>
                    </form>
                </div>
            </div>

            <!-- Abstract Decoration -->
            <div class="absolute top-0 right-0 w-1/2 h-full opacity-10 pointer-events-none hidden md:block">
                <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#3f5ec2" d="M44.7,-76.4C58.9,-69.2,71.8,-59.1,79.6,-46.9C87.4,-34.7,90.1,-20.4,85.8,-7.1C81.5,6.2,70.2,18.5,60.5,29.6C50.8,40.7,42.7,50.6,33.4,58.3C24.1,66,13.6,71.5,1.9,68.2C-9.8,64.9,-22.7,52.8,-35.1,43.2C-47.5,33.6,-59.4,26.5,-66.4,16.2C-73.4,5.9,-75.5,-7.6,-71.3,-19.6C-67.1,-31.6,-56.6,-42.1,-45.3,-50.2C-34,-58.3,-21.9,-64,-9.3,-62.4C3.3,-60.8,16.6,-60.8,29.9,-60.8C35.5,-83.6 30.5,-83.6 44.7,-76.4Z" transform="translate(100 100)" />
                </svg>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" data-animate="stagger-children">
            @if(auth()->user()->isAdmin())
            <!-- Admin Stats -->
            <a href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.*')" icon="user-group" class="bg-card p-6 rounded-2xl shadow-sm border border-border hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-muted-foreground uppercase tracking-wider">Total User</span>
                </div>
                <p class="text-3xl font-bold text-foreground">{{ \App\Models\User::count() }}</p>
                <p class="text-sm text-muted-foreground mt-1">Anggota terdaftar</p>
            </a>

            <a href="{{ route('admin.books.index') }}" :active="request()->routeIs('admin.books.*')" icon="book-open" class="bg-card p-6 rounded-2xl shadow-sm border border-border hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-purple-50 text-purple-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-muted-foreground uppercase tracking-wider">Koleksi Buku</span>
                </div>
                <p class="text-3xl font-bold text-foreground">{{ \App\Models\Book::count() }}</p>
                <p class="text-sm text-muted-foreground mt-1">Judul buku tersedia</p>
            </a>

            <a href="{{ route('admin.borrowings.index') }}" :active="request()->routeIs('admin.borrowings.*')" icon="switch-horizontal" class="bg-card p-6 rounded-2xl shadow-sm border border-border hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-orange-50 text-orange-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-muted-foreground uppercase tracking-wider">Peminjaman Aktif</span>
                </div>
                <p class="text-3xl font-bold text-foreground">{{ \App\Models\Borrowing::whereNull('tanggal_kembali')->count() }}</p>
                <p class="text-sm text-muted-foreground mt-1">Sedang dipinjam</p>
            </a>
            @else
            <!-- User Stats -->
            <a href="{{ route('borrowings.index') }}" :active="request()->routeIs('borrowings.index')" icon="collection" class="bg-card p-6 rounded-2xl shadow-sm border border-border hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-primary/10 text-primary rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-muted-foreground uppercase tracking-wider">Sedang Dipinjam</span>
                </div>
                <p class="text-3xl font-bold text-foreground">{{ auth()->user()->borrowings()->whereNull('tanggal_kembali')->count() }}</p>
                <p class="text-sm text-muted-foreground mt-1">Buku</p>
            </a>

            <a href=" {{ route('requests.index') }}" :active="request()->routeIs('requests.*')" icon="plus-circle" class="bg-card p-6 rounded-2xl shadow-sm border border-border hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-muted-foreground uppercase tracking-wider">Request Buku</span>
                </div>
                <p class="text-3xl font-bold text-foreground">{{ \App\Models\BookRequest::where('user_id', auth()->id())->count() }}</p>
                <p class="text-sm text-muted-foreground mt-1">Pengajuan dikirim</p>
            </a>
            @endif
        </div>

        <!-- Recent Books -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-foreground">Koleksi Terbaru</h2>
                <a href="{{ route('books.index') }}" class="text-sm font-bold text-primary hover:text-primary flex items-center">
                    Lihat Semua <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6" data-animate="stagger-children">
                @foreach(\App\Models\Book::latest()->take(5)->get() as $book)
                <a href="{{ route('books.show', $book) }}" class="group block">
                    <div class="aspect-[2/3] bg-muted rounded-xl overflow-hidden shadow-sm relative mb-3 group-hover:shadow-md transition-all duration-300 group-hover:-translate-y-1">
                        @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-muted-foreground">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        @endif
                    </div>
                    <h3 class="font-bold text-foreground line-clamp-1 group-hover:text-primary transition-colors">{{ $book->judul }}</h3>
                    <p class="text-sm text-muted-foreground">{{ $book->penulis }}</p>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>