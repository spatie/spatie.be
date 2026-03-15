@props([
    'color' => '#735AFF',
    'position' => 'top-right',
])

@php
    $glowPositions = match($position) {
        'top-right' => 'top: -40%; right: -30%;',
        'top-left' => 'top: -40%; left: -30%;',
        'bottom-right' => 'bottom: -40%; right: -30%;',
        'bottom-left' => 'bottom: -40%; left: -30%;',
        'center' => 'top: 50%; left: 50%; transform: translate(-50%, -50%);',
        default => 'top: -40%; right: -30%;',
    };
@endphp

<section {{ $attributes->merge(['class' => 'relative overflow-hidden rounded-[20px] md:rounded-[48px] p-7 md:py-16 md:px-12']) }}
         style="background-color: #0a0a14;">
    {{-- Grid pattern --}}
    <div class="absolute inset-0 pointer-events-none"
         style="opacity: 0.12;
            background-image:
                linear-gradient(to right, rgba(255,255,255,0.4) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255,255,255,0.4) 1px, transparent 1px);
            background-size: 180px 180px;
            mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 30%, transparent 80%);">
    </div>
    {{-- Primary color glow (large, vibrant) --}}
    <div class="absolute pointer-events-none w-[800px] h-[800px] md:w-[1200px] md:h-[1200px]"
         style="{{ $glowPositions }}
            background: radial-gradient(circle, {{ $color }}90 0%, {{ $color }}40 25%, {{ $color }}10 50%, transparent 70%);
            filter: blur(40px);">
    </div>
    {{-- Secondary subtle glow for depth --}}
    <div class="absolute pointer-events-none w-[400px] h-[400px] md:w-[600px] md:h-[600px]"
         style="{{ $glowPositions }}
            background: radial-gradient(circle, {{ $color }} 0%, {{ $color }}60 20%, transparent 50%);
            filter: blur(80px);
            opacity: 0.4;">
    </div>
    {{-- Content --}}
    <div class="relative z-10">
        {{ $slot }}
    </div>
</section>
