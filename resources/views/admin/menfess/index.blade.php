<x-app-layout>
    <x-slot name="title">Moderasi Menfess</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-foreground leading-tight">
            {{ __('Moderasi Menfess') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-primary/15 border border-primary text-primary px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Filter Tabs -->
            <div class="mb-6 border-b border-border">
                <nav class="-mb-px flex space-x-8">
                    @foreach(['pending', 'approved', 'rejected', 'all'] as $filter)
                        <a href="{{ route('admin.menfess.index', ['status' => $filter]) }}"
                           class="{{ request('status', 'pending') == $filter ? 'border-indigo-500 text-primary' : 'border-transparent text-muted-foreground hover:text-foreground hover:border-border' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm capitalize">
                           {{ $filter }}
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="bg-card overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-foreground">
                    @if($menfesses->isEmpty())
                        <div class="text-center py-8 text-muted-foreground">
                            Tidak ada data menfess.
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($menfesses as $menfess)
                                <div class="border rounded-lg p-4 {{ $menfess->reports_count > 0 ? 'border-red-300 bg-red-50' : 'border-border' }}">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="flex items-center gap-2 mb-2">
                                                <span class="font-bold text-foreground">User #{{ $menfess->user_id }}</span>
                                                <span class="text-muted-foreground text-xs">{{ $menfess->created_at->format('d M Y H:i') }}</span>
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $menfess->status === 'approved' ? 'bg-primary/15 text-primary' : ($menfess->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                    {{ ucfirst($menfess->status) }}
                                                </span>
                                            </div>
                                            
                                            <div class="text-sm text-foreground mb-2">
                                                <strong>From:</strong> {{ $menfess->sender }} <br>
                                                <strong>To:</strong> {{ $menfess->receiver }}
                                            </div>

                                            @if($menfess->reports_count > 0)
                                                <div class="text-red-600 text-sm font-bold mt-1">
                                                    ⚠️ Dilaporkan {{ $menfess->reports_count }} kali
                                                    <details class="font-normal text-xs text-muted-foreground mt-1 cursor-pointer">
                                                        <summary>Lihat alasan</summary>
                                                        <ul class="list-disc pl-4 mt-1">
                                                            @foreach($menfess->reports as $report)
                                                                <li>{{ $report->reason }} (User #{{ $report->user_id }})</li>
                                                            @endforeach
                                                        </ul>
                                                    </details>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex gap-2">
                                            @if($menfess->status === 'pending')
                                                <x-confirm-modal
                                                    :action="route('admin.menfess.update', $menfess)"
                                                    method="PATCH"
                                                    title="Approve Menfess?"
                                                    message="Setujui menfess ini untuk ditampilkan?"
                                                    confirmText="Ya, Approve"
                                                    confirmColor="emerald"
                                                    iconType="check">
                                                    <x-slot:formFields>
                                                        <input type="hidden" name="status" value="approved">
                                                    </x-slot:formFields>
                                                    <button type="button" class="cursor-pointer bg-primary hover:bg-primary/90 text-white font-bold py-1 px-3 rounded text-xs">
                                                        Approve
                                                    </button>
                                                </x-confirm-modal>
                                                <x-confirm-modal
                                                    :action="route('admin.menfess.update', $menfess)"
                                                    method="PATCH"
                                                    title="Reject Menfess?"
                                                    message="Tolak menfess ini?"
                                                    confirmText="Ya, Reject"
                                                    confirmColor="red"
                                                    iconType="x-circle">
                                                    <x-slot:formFields>
                                                        <input type="hidden" name="status" value="rejected">
                                                    </x-slot:formFields>
                                                    <button type="button" class="cursor-pointer bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-xs">
                                                        Reject
                                                    </button>
                                                </x-confirm-modal>
                                            @else
                                                <x-confirm-modal
                                                    :action="route('admin.menfess.destroy', $menfess)"
                                                    method="DELETE"
                                                    title="Hapus Menfess?"
                                                    message="Menfess ini akan dihapus secara permanen."
                                                    confirmText="Ya, Hapus"
                                                    confirmColor="red"
                                                    iconType="trash">
                                                    <button type="button" class="cursor-pointer text-red-600 hover:text-red-800 text-sm font-semibold">Hapus</button>
                                                </x-confirm-modal>
                                            @endif
                                        </div>
                                    </div>

                                    <p class="mt-2 text-foreground">{{ $menfess->message }}</p>

                                    @if($menfess->book)
                                        <div class="mt-2 text-sm text-muted-foreground bg-muted p-2 rounded">
                                            📚 Rujukan: <span class="font-semibold">{{ $menfess->book->judul }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            <x-pagination :paginator="$menfesses" :perPage="$perPage" />
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
