@props(['active', 'href', 'icon'])

@php
$baseClasses = 'flex items-center rounded-full transition-all duration-300 font-medium group mb-1';
$activeClasses = $active
    ? 'bg-primary text-white shadow-lg shadow-primary-500/30'
    : 'text-muted-foreground hover:bg-secondary hover:text-primary hover:shadow-md hover:scale-[1.02]';
$iconClasses = ($active ?? false) ? 'text-white' : 'text-muted-foreground group-hover:text-primary transition-colors';
@endphp

<a href="{{ $href }}"
   {{ $attributes->merge(['class' => $baseClasses . ' ' . $activeClasses]) }}
   :class="sidebarCollapsed ? 'justify-center px-0 py-3' : 'px-5 py-3.5'"
   :title="sidebarCollapsed ? '{{ strip_tags($slot) }}' : ''">
    @if($icon == 'home')
        <svg class="w-5 h-5 flex-shrink-0 {{ $iconClasses }}" :class="sidebarCollapsed ? '' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
    @elseif($icon == 'book-open')
        <svg class="w-5 h-5 flex-shrink-0 {{ $iconClasses }}" :class="sidebarCollapsed ? '' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
    @elseif($icon == 'switch-horizontal')
        <svg class="w-5 h-5 flex-shrink-0 {{ $iconClasses }}" :class="sidebarCollapsed ? '' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
    @elseif($icon == 'collection')
        <svg class="w-5 h-5 flex-shrink-0 {{ $iconClasses }}" :class="sidebarCollapsed ? '' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
    @elseif($icon == 'plus-circle')
        <svg class="w-5 h-5 flex-shrink-0 {{ $iconClasses }}" :class="sidebarCollapsed ? '' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    @elseif($icon == 'chat-alt-2')
        <svg class="w-5 h-5 flex-shrink-0 {{ $iconClasses }}" :class="sidebarCollapsed ? '' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
    @elseif($icon == 'user-group')
        <svg class="w-5 h-5 flex-shrink-0 {{ $iconClasses }}" :class="sidebarCollapsed ? '' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
    @elseif($icon == 'tag')
        <svg class="w-5 h-5 flex-shrink-0 {{ $iconClasses }}" :class="sidebarCollapsed ? '' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"></path></svg>
    @endif

    <span x-show="!sidebarCollapsed" class="tracking-wide whitespace-nowrap">{{ $slot }}</span>
</a>
