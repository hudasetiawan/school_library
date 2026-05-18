@props([
    'action',
    'method' => 'POST',
    'title' => 'Konfirmasi',
    'message' => 'Apakah Anda yakin?',
    'confirmText' => 'Ya, Lanjutkan',
    'confirmColor' => 'red',
    'iconType' => 'warning',
])

@php
    $colors = [
        'red' => ['bg' => 'bg-red-100', 'text' => 'text-red-500', 'btn' => 'text-red-600 hover:bg-red-50'],
        'emerald' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-500', 'btn' => 'text-emerald-600 hover:bg-emerald-50'],
        'blue' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-500', 'btn' => 'text-blue-600 hover:bg-blue-50'],
        'amber' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-500', 'btn' => 'text-amber-600 hover:bg-amber-50'],
    ];
    $c = $colors[$confirmColor] ?? $colors['red'];

    $icons = [
        'warning' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>',
        'check' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
        'trash' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>',
        'x-circle' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
        'return' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>',
    ];
    $iconPath = $icons[$iconType] ?? $icons['warning'];
@endphp

<div x-data="{ showConfirm: false }">
    {{-- Trigger Button --}}
    <div @click="showConfirm = true">
        {{ $slot }}
    </div>

    {{-- Modal Overlay --}}
    <div x-show="showConfirm" x-cloak
         x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-foreground/50 backdrop-blur-sm"
         @keydown.escape.window="showConfirm = false">

        {{-- Modal Card --}}
        <div @click.away="showConfirm = false"
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             class="bg-card rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden">

            <div class="p-6 text-center">
                <div class="mx-auto w-14 h-14 {{ $c['bg'] }} rounded-full flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 {{ $c['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $iconPath !!}</svg>
                </div>
                <h3 class="text-lg font-bold text-foreground mb-1">{{ $title }}</h3>
                <p class="text-sm text-muted-foreground mb-6">{!! $message !!}</p>
            </div>

            <div class="flex border-t border-border">
                <button @click="showConfirm = false" type="button"
                        class="flex-1 py-3.5 text-sm font-semibold text-muted-foreground hover:bg-muted transition-colors border-r border-border cursor-pointer">
                    Batal
                </button>
                <form action="{{ $action }}" method="POST" class="flex-1">
                    @csrf
                    @if(strtoupper($method) === 'DELETE')
                        @method('DELETE')
                    @elseif(strtoupper($method) === 'PATCH')
                        @method('PATCH')
                    @elseif(strtoupper($method) === 'PUT')
                        @method('PUT')
                    @endif
                    {{-- Extra hidden fields --}}
                    @if(isset($formFields))
                        {{ $formFields }}
                    @endif
                    <button type="submit"
                            class="w-full py-3.5 text-sm font-semibold {{ $c['btn'] }} transition-colors cursor-pointer">
                        {{ $confirmText }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
