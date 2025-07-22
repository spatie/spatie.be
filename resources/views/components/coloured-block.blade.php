@props([
    'color' => 'yellow',
    'icon' => null,
])

@php
$colorStyles = [
    'yellow' => 'background-color: rgba(246,202,96); color: #1f2937;',
    'blue' => 'background-color: rgba(147,197,253); color: #1f2937;',
    'green' => 'background-color: #f0fdf4; color: #166534;',
    'terminal' => 'background-color: #1a1a1a; color: #22c55e;',
    'red' => 'background-color: #fef2f2; color: #dc2626;',
    'gray' => 'background-color: #f9fafb; color: #374151;',
];

$colorStyle = $colorStyles[$color] ?? $colorStyles['yellow'];
@endphp

<div class="p-8 rounded-lg" style="{{ $colorStyle }}">
    <div class="flex items-start gap-4">
        @if($icon)
            <div class="flex-shrink-0">
                @if($icon === 'graduation-cap')
                    <svg class="w-8 h-8 text-current" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a1 1 0 00.364 0L13 10.819v2.13a1 1 0 102 0v-2.13l.943-.405a1 1 0 00.037-1.838l-2-3.25a1 1 0 00-1.708 0l-2 3.25z"></path>
                    </svg>
                @elseif($icon === 'code')
                    <svg class="w-8 h-8 text-current" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                @endif
            </div>
        @endif
        <div class="flex-1">
            {{ $slot }}
        </div>
    </div>
</div>