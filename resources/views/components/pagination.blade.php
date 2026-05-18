{{-- Reusable Pagination Bar with Per-Page Selector --}}
@props(['paginator', 'perPage' => 10])

@php
    // Append per_page and all existing query strings to paginator
    $paginator->appends(array_merge(request()->except('page'), ['per_page' => $perPage]));
@endphp

@if($paginator->hasPages() || $paginator->total() > 0)
<div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4">
    {{-- Left: Info + Per-page selector --}}
    <div class="flex items-center gap-4 text-sm text-muted-foreground">
        <span>
            Menampilkan
            <span class="font-semibold text-foreground">{{ $paginator->firstItem() ?? 0 }}</span>
            –
            <span class="font-semibold text-foreground">{{ $paginator->lastItem() ?? 0 }}</span>
            dari
            <span class="font-semibold text-foreground">{{ $paginator->total() }}</span>
            data
        </span>

        <div class="flex items-center gap-2">
            <label for="per_page_select" class="text-xs text-muted-foreground whitespace-nowrap">Per halaman:</label>
            <select id="per_page_select" onchange="updatePerPage(this.value)"
                class="py-1.5 pl-2.5 pr-7 bg-card text-foreground border border-border rounded-lg text-xs font-medium transition-colors duration-200 cursor-pointer hover:bg-secondary/50 focus:bg-secondary focus:ring-2 focus:ring-ring/20 focus:border-ring appearance-none"
                style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpath d=%27M6 9l6 6 6-6%27/%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 0.35rem center; background-size: 0.85rem;">
                @foreach([10, 25, 50, 100] as $option)
                    <option value="{{ $option }}" class="bg-card text-foreground" {{ (int) $perPage === $option ? 'selected' : '' }}>{{ $option }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Right: Page navigation --}}
    @if($paginator->hasPages())
    <nav class="flex items-center gap-1">
        {{-- Previous --}}
        @if($paginator->onFirstPage())
            <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-muted-foreground/40 cursor-not-allowed">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-muted-foreground hover:bg-muted hover:text-foreground transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
        @endif

        {{-- Page Numbers --}}
        @php
            $currentPage = $paginator->currentPage();
            $lastPage = $paginator->lastPage();
            $startPage = max(1, $currentPage - 2);
            $endPage = min($lastPage, $currentPage + 2);

            // Ensure we always show at least 5 pages if available
            if ($endPage - $startPage < 4) {
                if ($startPage === 1) {
                    $endPage = min($lastPage, $startPage + 4);
                } else {
                    $startPage = max(1, $endPage - 4);
                }
            }
        @endphp

        @if($startPage > 1)
            <a href="{{ $paginator->url(1) }}"
               class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-sm font-medium text-muted-foreground hover:bg-muted hover:text-foreground transition-colors">1</a>
            @if($startPage > 2)
                <span class="inline-flex items-center justify-center w-9 h-9 text-muted-foreground text-xs">...</span>
            @endif
        @endif

        @for($i = $startPage; $i <= $endPage; $i++)
            @if($i == $currentPage)
                <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-sm font-bold bg-primary text-primary-foreground shadow-sm">{{ $i }}</span>
            @else
                <a href="{{ $paginator->url($i) }}"
                   class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-sm font-medium text-muted-foreground hover:bg-muted hover:text-foreground transition-colors">{{ $i }}</a>
            @endif
        @endfor

        @if($endPage < $lastPage)
            @if($endPage < $lastPage - 1)
                <span class="inline-flex items-center justify-center w-9 h-9 text-muted-foreground text-xs">...</span>
            @endif
            <a href="{{ $paginator->url($lastPage) }}"
               class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-sm font-medium text-muted-foreground hover:bg-muted hover:text-foreground transition-colors">{{ $lastPage }}</a>
        @endif

        {{-- Next --}}
        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-muted-foreground hover:bg-muted hover:text-foreground transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        @else
            <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-muted-foreground/40 cursor-not-allowed">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </span>
        @endif
    </nav>
    @endif
</div>

@once
@push('scripts')
<script>
function updatePerPage(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', value);
    url.searchParams.delete('page');
    window.location.href = url.toString();
}
</script>
@endpush
@endonce
@endif
