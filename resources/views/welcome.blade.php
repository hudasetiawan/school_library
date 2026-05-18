<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Selamat Datang — {{ config('app.name', 'Perpustakaan') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,700|playfair-display:600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-foreground font-sans antialiased selection:bg-primary/15 selection:text-primary">
    
    <!-- Navbar -->
    <nav class="fixed w-full z-50 transition-all duration-300 bg-card/80 backdrop-blur-md border-b border-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center shadow-lg shadow-blue-600/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-foreground">Perpus <span class="text-primary">SMKN 2 Magelang</span></span>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:items-center sm:gap-6">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="font-medium text-muted-foreground hover:text-primary transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="font-medium text-muted-foreground hover:text-primary transition">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-primary text-white px-5 py-2.5 rounded-xl font-medium hover:bg-primary/90 transition shadow-lg shadow-primary/10 hover:shadow-primary/20">Daftar Sekarang</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="pt-20">
        <section class="relative pt-20 pb-32 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-3xl mx-auto opacity-0" data-animate="fade-in-up">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/10 text-primary text-sm font-medium mb-6">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                        </span>
                        Perpustakaan Digital Modern
                    </div>
                    <h1 class="text-5xl md:text-7xl font-bold tracking-tight text-foreground mb-8 leading-tight font-serif">
                        Jelajahi Dunia Lewat <br>
                        <span class="text-primary">Buku & Pengetahuan</span>
                    </h1>
                    <p class="text-lg md:text-xl text-muted-foreground mb-10 leading-relaxed max-w-2xl mx-auto">
                        Akses ribuan koleksi buku, jurnal, dan referensi akademik secara mudah. Tingkatkan literasi dan wawasanmu bersama SMKN 2 Magelang.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="{{ route('books.index') }}" class="w-full sm:w-auto px-8 py-4 bg-primary text-white rounded-2xl font-bold hover:bg-primary/90 transition shadow-xl shadow-primary-600/60 hover:shadow-primary-600/30 hover:-translate-y-1 transform">
                            Mulai Menjelajah
                        </a>
                        <a href="#featured" class="w-full sm:w-auto px-8 py-4 bg-card text-foreground border border-border rounded-2xl font-bold hover:bg-background transition hover:-translate-y-1 transform">
                            Lihat Koleksi
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Decorative blobs -->
            <div class="absolute top-0 -left-4 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-primary/60 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
        </section>

        <!-- Featured Books Section -->
        <section id="featured" class="py-24 bg-card relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 opacity-0" data-animate="fade-in-up">
                    <h2 class="text-3xl md:text-4xl font-bold text-foreground mb-4 font-serif">Koleksi Terbaru</h2>
                    <p class="text-muted-foreground text-lg">Buku-buku pilihan yang baru saja ditambahkan ke perpustakaan.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($books as $book)
                        <div class="group opacity-0" data-animate="fade-in-up" style="animation-delay: {{ $loop->index * 100 }}ms">
                            <div class="relative bg-background rounded-3xl overflow-hidden transition-all duration-300 hover:shadow-2xl hover:shadow-border hover:-translate-y-2 border border-border h-full flex flex-col">
                                <!-- Image Container -->
                                <div class="aspect-[3/4] w-full overflow-hidden relative">
                                    @if($book->cover_image)
                                        <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->judul }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                    @else
                                        <div class="w-full h-full bg-muted flex items-center justify-center">
                                            <svg class="w-12 h-12 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <!-- Overlay Gradient -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    
                                    <!-- Quick Action -->
                                    <div class="absolute bottom-4 left-4 right-4 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                                        <a href="{{ route('books.show', $book) }}" class="block w-full py-3 bg-card/10 backdrop-blur-md border border-white/20 text-white text-center rounded-xl font-semibold hover:bg-card hover:text-foreground transition-colors">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="p-6 flex-1 flex flex-col">
                                    <div class="flex items-center gap-2 mb-3">
                                        <span class="px-2.5 py-1 bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider rounded-lg">
                                            {{ $book->kategori ?? 'Umum' }}
                                        </span>
                                    </div>
                                    <h3 class="text-xl font-bold text-foreground mb-2 font-serif line-clamp-2 group-hover:text-primary transition-colors">
                                        <a href="{{ route('books.show', $book) }}">
                                            {{ $book->judul }}
                                        </a>
                                    </h3>
                                    <p class="text-muted-foreground text-sm mb-4 line-clamp-1">{{ $book->penulis }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-16 text-center">
                    <a href="{{ route('books.index') }}" class="inline-flex items-center gap-2 text-primary font-bold hover:text-primary transition group">
                        Lihat Semua Koleksi
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-20 bg-foreground text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div class="p-6">
                        <div class="text-4xl md:text-5xl font-bold text-primary/70 mb-2">2000+</div>
                        <div class="text-muted-foreground font-medium">Judul Buku</div>
                    </div>
                    <div class="p-6">
                        <div class="text-4xl md:text-5xl font-bold text-blue-400 mb-2">1500+</div>
                        <div class="text-muted-foreground font-medium">Anggota Aktif</div>
                    </div>
                    <div class="p-6">
                        <div class="text-4xl md:text-5xl font-bold text-purple-400 mb-2">50+</div>
                        <div class="text-muted-foreground font-medium">Kunjungan/Hari</div>
                    </div>
                    <div class="p-6">
                        <div class="text-4xl md:text-5xl font-bold text-orange-400 mb-2">24/7</div>
                        <div class="text-muted-foreground font-medium">Akses Online</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-card border-t border-border py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <span class="font-bold text-lg text-foreground">Perpus SMKN 2</span>
                        </div>
                        <p class="text-muted-foreground leading-relaxed">
                            Menyediakan layanan literasi digital terbaik untuk mendukung kegiatan belajar mengajar di lingkungan SMKN 2 Magelang.
                        </p>
                    </div>
                    <div>
                        <h4 class="font-bold text-foreground mb-6">Tautan Cepat</h4>
                        <ul class="space-y-4 text-muted-foreground">
                            <li><a href="#" class="hover:text-primary transition">Tentang Kami</a></li>
                            <li><a href="#" class="hover:text-primary transition">Katalog Buku</a></li>
                            <li><a href="#" class="hover:text-primary transition">Tata Tertib</a></li>
                            <li><a href="#" class="hover:text-primary transition">Kontak</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold text-foreground mb-6">Hubungi Kami</h4>
                        <ul class="space-y-4 text-muted-foreground">
                            <li class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-primary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span>Jl. Ahmad Yani No. 135, Magelang, Jawa Tengah</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-6 h-6 text-primary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span>perpustakaan@smkn2magelang.sch.id</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-border mt-12 pt-8 text-center text-muted-foreground text-sm">
                    &copy; {{ date('Y') }} Perpustakaan SMKN 2 Magelang. All rights reserved.
                </div>
            </div>
        </footer>
    </main>

    <style>
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
    </style>
</body>
</html>
