<x-app-layout>
    <x-slot name="title">Menfess Space</x-slot>

    <div class="space-y-8" data-animate="fade-in-up">
        
        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto">
            <h2 class="text-3xl font-bold text-foreground tracking-tight mb-2">Menfess Space</h2>
            <p class="text-muted-foreground">Kirim pesan rahasia atau rekomendasi buku secara anonim.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Section -->
            <div class="lg:col-span-1">
                <div class="bg-card rounded-2xl shadow-sm border border-border p-6 sticky top-24">
                    <h3 class="font-bold text-lg text-foreground mb-4 flex items-center gap-2">
                        <span class="p-2 bg-pink-50 text-pink-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </span>
                        Kirim Menfess
                    </h3>
                    
                    <form action="{{ route('menfess.store') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-muted-foreground uppercase tracking-wider mb-1">Dari</label>
                                <input type="text" name="sender" class="w-full rounded-xl border-border bg-muted focus:border-pink-500 focus:ring-pink-500/20 text-sm" placeholder="Anonim (Opsional)">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-muted-foreground uppercase tracking-wider mb-1">Untuk</label>
                                <input type="text" name="receiver" class="w-full rounded-xl border-border bg-muted focus:border-pink-500 focus:ring-pink-500/20 text-sm" required placeholder="Nama/Inisial">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-muted-foreground uppercase tracking-wider mb-1">Pesan</label>
                            <textarea name="message" rows="4" class="w-full rounded-xl border-border bg-muted focus:border-pink-500 focus:ring-pink-500/20 text-sm" required placeholder="Tulis pesanmu di sini..."></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-muted-foreground uppercase tracking-wider mb-1">Rujuk Buku (Opsional)</label>
                            <select name="book_id" class="w-full rounded-xl border-border bg-muted focus:border-pink-500 focus:ring-pink-500/20 text-sm">
                                <option value="">-- Pilih Buku --</option>
                                @foreach(\App\Models\Book::all() as $book)
                                    <option value="{{ $book->id }}">{{ $book->judul }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-foreground text-background font-bold py-3 rounded-xl hover:bg-black transition shadow-lg flex items-center justify-center gap-2">
                            <span>Kirim Menfess</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Feed Section -->
            <div class="lg:col-span-2 space-y-6" data-animate="stagger-children">
                @foreach($menfesses as $menfess)
                    <div class="bg-card rounded-2xl p-6 shadow-sm border border-border hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-pink-100 to-purple-100 flex items-center justify-center text-pink-500 font-bold">
                                    ?
                                </div>
                                <div>
                                    <h4 class="font-bold text-foreground text-sm">
                                        <span class="text-pink-600">{{ $menfess->sender ?? 'Anonim' }}</span> 
                                        <span class="text-muted-foreground mx-1">to</span> 
                                        <span class="text-primary">{{ $menfess->receiver }}</span>
                                    </h4>
                                    <p class="text-xs text-muted-foreground">{{ $menfess->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            
                             <!-- Report Button -->
                            <form action="{{ route('menfess.report', $menfess) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-muted-foreground hover:text-red-500 transition-colors" title="Laporkan">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </button>
                            </form>
                        </div>
                        
                        <p class="text-foreground leading-relaxed mb-4 text-sm md:text-base">
                            "{{ $menfess->message }}"
                        </p>

                        @if($menfess->book)
                            <div class="bg-muted rounded-xl p-3 flex items-center gap-3 border border-border">
                                @if($menfess->book->cover_image)
                                    <img src="{{ asset('storage/' . $menfess->book->cover_image) }}" class="w-10 h-14 object-cover rounded-md shadow-sm">
                                @else
                                    <div class="w-10 h-14 bg-muted rounded-md flex items-center justify-center text-muted-foreground">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-xs font-bold text-muted-foreground uppercase tracking-wider">Merekomendasikan</p>
                                    <a href="{{ route('books.show', $menfess->book) }}" class="font-bold text-foreground hover:text-primary transition-colors">{{ $menfess->book->judul }}</a>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach

                <x-pagination :paginator="$menfesses" :perPage="$perPage" />
            </div>
        </div>
    </div>
</x-app-layout>
