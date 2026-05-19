<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    <div class="space-y-8">
        @if(auth()->user()->isAdmin())
            {{-- ============ ADMIN DASHBOARD ============ --}}

            {{-- Hero --}}
            <div class="relative bg-card rounded-3xl p-8 md:p-12 shadow-sm border border-border overflow-hidden">
                <div class="relative z-10 max-w-2xl">
                    <span class="inline-block py-1 px-3 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider mb-4 border border-primary/10">Panel Admin</span>
                    <h1 class="text-4xl md:text-5xl font-bold text-foreground mb-3 tracking-tight leading-tight">
                        Halo, <span class="text-primary">{{ Auth::user()->name }}</span>
                    </h1>
                    <p class="text-lg text-muted-foreground leading-relaxed">Kelola perpustakaan dari satu tempat. Pantau statistik, transaksi, dan pengajuan buku.</p>
                </div>
                <div class="absolute top-0 right-0 w-1/2 h-full opacity-10 pointer-events-none hidden md:block">
                    <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg"><path fill="#3f5ec2" d="M44.7,-76.4C58.9,-69.2,71.8,-59.1,79.6,-46.9C87.4,-34.7,90.1,-20.4,85.8,-7.1C81.5,6.2,70.2,18.5,60.5,29.6C50.8,40.7,42.7,50.6,33.4,58.3C24.1,66,13.6,71.5,1.9,68.2C-9.8,64.9,-22.7,52.8,-35.1,43.2C-47.5,33.6,-59.4,26.5,-66.4,16.2C-73.4,5.9,-75.5,-7.6,-71.3,-19.6C-67.1,-31.6,-56.6,-42.1,-45.3,-50.2C-34,-58.3,-21.9,-64,-9.3,-62.4C3.3,-60.8,16.6,-60.8,29.9,-60.8C35.5,-83.6 30.5,-83.6 44.7,-76.4Z" transform="translate(100 100)" /></svg>
                </div>
            </div>

            {{-- Stats Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <a href="{{ route('admin.users.index') }}" class="bg-card p-6 rounded-2xl shadow-sm border border-border hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-xl"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg></div>
                        <span class="text-xs font-bold text-muted-foreground uppercase tracking-wider">Total User</span>
                    </div>
                    <p class="text-3xl font-bold text-foreground">{{ $totalUsers }}</p>
                    <p class="text-sm text-muted-foreground mt-1">Anggota terdaftar</p>
                </a>
                <a href="{{ route('admin.books.index') }}" class="bg-card p-6 rounded-2xl shadow-sm border border-border hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-purple-50 text-purple-600 rounded-xl"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg></div>
                        <span class="text-xs font-bold text-muted-foreground uppercase tracking-wider">Koleksi Buku</span>
                    </div>
                    <p class="text-3xl font-bold text-foreground">{{ $totalBooks }}</p>
                    <p class="text-sm text-muted-foreground mt-1">Judul buku tersedia</p>
                </a>
                <a href="{{ route('admin.borrowings.index') }}" class="bg-card p-6 rounded-2xl shadow-sm border border-border hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                        <span class="text-xs font-bold text-muted-foreground uppercase tracking-wider">Aktif</span>
                    </div>
                    <p class="text-3xl font-bold text-foreground">{{ $activeBorrowings }}</p>
                    <p class="text-sm text-muted-foreground mt-1">Sedang dipinjam</p>
                </a>
                <a href="{{ route('admin.borrowings.index', ['status' => 'pending']) }}" class="bg-card p-6 rounded-2xl shadow-sm border border-border hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-amber-50 text-amber-600 rounded-xl"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                        <span class="text-xs font-bold text-muted-foreground uppercase tracking-wider">Pending</span>
                    </div>
                    <p class="text-3xl font-bold text-foreground">{{ $pendingBorrowings }}</p>
                    <p class="text-sm text-muted-foreground mt-1">Menunggu persetujuan</p>
                </a>
            </div>

            {{-- Grafik + Antrean --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                {{-- Grafik Dual-Tab --}}
                <div class="lg:col-span-8" x-data="{ chartTab: 'monthly' }">
                    <div class="bg-card rounded-2xl shadow-sm border border-border p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                            <h2 class="text-lg font-bold text-foreground">Grafik Tren Peminjaman</h2>
                            <div class="flex bg-muted rounded-xl p-1 gap-1">
                                <button @click="chartTab = 'monthly'" :class="chartTab === 'monthly' ? 'bg-card shadow-sm text-foreground' : 'text-muted-foreground hover:text-foreground'" class="px-4 py-2 rounded-lg text-xs font-semibold transition-all duration-200 cursor-pointer">Bulanan</button>
                                <button @click="chartTab = 'weekly'" :class="chartTab === 'weekly' ? 'bg-card shadow-sm text-foreground' : 'text-muted-foreground hover:text-foreground'" class="px-4 py-2 rounded-lg text-xs font-semibold transition-all duration-200 cursor-pointer">Mingguan</button>
                            </div>
                        </div>
                        <div x-show="chartTab === 'monthly'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" style="min-height: 320px;">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                        <div x-show="chartTab === 'weekly'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" style="min-height: 320px;">
                            <canvas id="weeklyChart"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Antrean Pengajuan Buku --}}
                <div class="lg:col-span-4">
                    <div class="bg-card rounded-2xl shadow-sm border border-border p-6 h-full">
                        <div class="flex items-center justify-between mb-5">
                            <h2 class="text-lg font-bold text-foreground">Antrean Pengajuan</h2>
                            <a href="{{ route('admin.requests.index') }}" class="text-xs font-semibold text-primary hover:text-primary/80 transition-colors">Lihat Semua</a>
                        </div>
                        @if($pendingRequests->isEmpty())
                            <div class="flex flex-col items-center justify-center py-12 text-center">
                                <div class="w-14 h-14 bg-muted rounded-2xl flex items-center justify-center mb-4">
                                    <svg class="w-7 h-7 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <p class="text-sm font-medium text-foreground">Tidak ada antrean</p>
                                <p class="text-xs text-muted-foreground mt-1">Semua pengajuan sudah diproses.</p>
                            </div>
                        @else
                            <div class="space-y-3">
                                @foreach($pendingRequests as $req)
                                <div class="bg-muted/50 rounded-xl p-4 border border-border/50">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-bold text-foreground truncate">{{ $req->judul }}</p>
                                            <p class="text-xs text-muted-foreground mt-0.5">{{ $req->user->name ?? '-' }}</p>
                                            <p class="text-[10px] text-muted-foreground mt-1">{{ $req->created_at->diffForHumans() }}</p>
                                        </div>
                                        <span class="shrink-0 inline-flex items-center bg-amber-100 text-amber-700 text-[10px] font-bold px-2 py-0.5 rounded-md">Pending</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Chart.js CDN & Scripts --}}
            @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const chartDefaults = {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 11 } }, grid: { color: 'rgba(0,0,0,0.04)' } },
                            x: { ticks: { font: { size: 11 } }, grid: { display: false } }
                        }
                    };
                    // Monthly
                    new Chart(document.getElementById('monthlyChart'), {
                        type: 'bar',
                        data: {
                            labels: @json($monthLabels),
                            datasets: [{
                                label: 'Peminjaman',
                                data: @json($monthTotals),
                                backgroundColor: 'rgba(99, 102, 241, 0.7)',
                                borderRadius: 8, borderSkipped: false,
                            }]
                        },
                        options: chartDefaults
                    });
                    // Weekly
                    new Chart(document.getElementById('weeklyChart'), {
                        type: 'line',
                        data: {
                            labels: @json($weekLabels),
                            datasets: [{
                                label: 'Peminjaman',
                                data: @json($weekTotals),
                                borderColor: 'rgb(99, 102, 241)',
                                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                                fill: true, tension: 0.4, pointRadius: 5, pointBackgroundColor: 'rgb(99, 102, 241)',
                            }]
                        },
                        options: chartDefaults
                    });
                });
            </script>
            @endpush

        @else
            {{-- ============ USER (SISWA) DASHBOARD ============ --}}

            {{-- Banner Overdue (Merah) --}}
            @if(isset($overdueBorrowings) && $overdueBorrowings->isNotEmpty())
            <div class="bg-red-50 border border-red-200 rounded-2xl p-5">
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-red-100 rounded-xl shrink-0">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-red-800">Terlambat Pengembalian!</h3>
                        @foreach($overdueBorrowings as $b)
                        <p class="text-sm text-red-700 mt-1">Buku <strong>{{ $b->book->judul }}</strong> sudah melewati jatuh tempo <strong>{{ $b->tanggal_jatuh_tempo->diffForHumans() }}</strong>. Segera kembalikan!</p>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- Banner Due Soon (Kuning) --}}
            @if(isset($dueSoonBorrowings) && $dueSoonBorrowings->isNotEmpty())
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5">
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-amber-100 rounded-xl shrink-0">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-amber-800">Peringatan Jatuh Tempo</h3>
                        @foreach($dueSoonBorrowings as $b)
                        @php $daysLeft = now()->startOfDay()->diffInDays($b->tanggal_jatuh_tempo); @endphp
                        <p class="text-sm text-amber-700 mt-1">Buku <strong>{{ $b->book->judul }}</strong> harus dikembalikan dalam <strong>{{ $daysLeft == 0 ? 'hari ini' : $daysLeft . ' hari lagi' }}</strong>!</p>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- Hero --}}
            <div class="relative bg-card rounded-3xl p-8 md:p-12 shadow-sm border border-border overflow-hidden">
                <div class="relative z-10 max-w-2xl">
                    <span class="inline-block py-1 px-3 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider mb-4 border border-primary/10">Selamat Datang</span>
                    <h1 class="text-4xl md:text-5xl font-bold text-foreground mb-4 tracking-tight leading-tight">
                        Halo, <span class="text-primary">{{ Auth::user()->name }}</span>
                    </h1>
                    <p class="text-lg text-muted-foreground mb-8 leading-relaxed">Mau baca buku apa hari ini? Telusuri koleksi terbaru kami dan temukan inspirasi barumu.</p>
                    <div class="bg-card p-2 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-border max-w-lg">
                        <form action="{{ route('books.index') }}" method="GET" class="flex items-center">
                            <div class="relative flex-grow">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"><svg class="h-5 w-5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></span>
                                <input type="text" name="search" class="w-full pl-11 pr-4 py-3 bg-transparent border-none focus:ring-0 text-foreground placeholder-gray-400 font-medium" placeholder="Cari judul, penulis...">
                            </div>
                            <button type="submit" class="bg-primary text-white px-6 py-3 rounded-xl font-bold cursor-pointer hover:bg-primary/90 transition-colors shadow-lg">Cari</button>
                        </form>
                    </div>
                </div>
                <div class="absolute top-0 right-0 w-1/2 h-full opacity-10 pointer-events-none hidden md:block">
                    <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg"><path fill="#3f5ec2" d="M44.7,-76.4C58.9,-69.2,71.8,-59.1,79.6,-46.9C87.4,-34.7,90.1,-20.4,85.8,-7.1C81.5,6.2,70.2,18.5,60.5,29.6C50.8,40.7,42.7,50.6,33.4,58.3C24.1,66,13.6,71.5,1.9,68.2C-9.8,64.9,-22.7,52.8,-35.1,43.2C-47.5,33.6,-59.4,26.5,-66.4,16.2C-73.4,5.9,-75.5,-7.6,-71.3,-19.6C-67.1,-31.6,-56.6,-42.1,-45.3,-50.2C-34,-58.3,-21.9,-64,-9.3,-62.4C3.3,-60.8,16.6,-60.8,29.9,-60.8C35.5,-83.6 30.5,-83.6 44.7,-76.4Z" transform="translate(100 100)" /></svg>
                </div>
            </div>

            {{-- User Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="{{ route('borrowings.index') }}" class="bg-card p-6 rounded-2xl shadow-sm border border-border hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-primary/10 text-primary rounded-xl"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg></div>
                        <span class="text-xs font-bold text-muted-foreground uppercase tracking-wider">Sedang Dipinjam</span>
                    </div>
                    <p class="text-3xl font-bold text-foreground">{{ $myActiveBorrowings }}</p>
                    <p class="text-sm text-muted-foreground mt-1">Buku</p>
                </a>
                <a href="{{ route('requests.index') }}" class="bg-card p-6 rounded-2xl shadow-sm border border-border hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-xl"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></div>
                        <span class="text-xs font-bold text-muted-foreground uppercase tracking-wider">Request Buku</span>
                    </div>
                    <p class="text-3xl font-bold text-foreground">{{ \App\Models\BookRequest::where('user_id', auth()->id())->count() }}</p>
                    <p class="text-sm text-muted-foreground mt-1">Pengajuan dikirim</p>
                </a>
            </div>

            {{-- Koleksi Terbaru --}}
            <div>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-foreground">Koleksi Terbaru</h2>
                    <a href="{{ route('books.index') }}" class="text-sm font-bold text-primary hover:text-primary flex items-center">
                        Lihat Semua <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                    @foreach($latestBooks as $book)
                    <a href="{{ route('books.show', $book) }}" class="group block">
                        <div class="aspect-[2/3] bg-muted rounded-xl overflow-hidden shadow-sm relative mb-3 group-hover:shadow-md transition-all duration-300 group-hover:-translate-y-1">
                            @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" class="w-full h-full object-cover" loading="lazy">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-muted-foreground">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            @endif
                        </div>
                        <h3 class="font-bold text-foreground line-clamp-1 group-hover:text-primary transition-colors">{{ $book->judul }}</h3>
                        <p class="text-sm text-muted-foreground">{{ $book->penulis }}</p>
                    </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>