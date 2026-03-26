@props([
    'color' => '#735AFF',
    'position' => 'top-right',
])

@php
    $cornerGradient = match($position) {
        'top-right' => 'background: radial-gradient(ellipse 120% 120% at top right, ' . $color . ' 0%, ' . $color . '99 8%, ' . $color . '50 20%, ' . $color . '18 35%, transparent 55%);',
        'top-left' => 'background: radial-gradient(ellipse 120% 120% at top left, ' . $color . ' 0%, ' . $color . '99 8%, ' . $color . '50 20%, ' . $color . '18 35%, transparent 55%);',
        'bottom-right' => 'background: radial-gradient(ellipse 120% 120% at bottom right, ' . $color . ' 0%, ' . $color . '99 8%, ' . $color . '50 20%, ' . $color . '18 35%, transparent 55%);',
        'bottom-left' => 'background: radial-gradient(ellipse 120% 120% at bottom left, ' . $color . ' 0%, ' . $color . '99 8%, ' . $color . '50 20%, ' . $color . '18 35%, transparent 55%);',
        default => 'background: radial-gradient(ellipse 120% 120% at top right, ' . $color . ' 0%, ' . $color . '99 8%, ' . $color . '50 20%, ' . $color . '18 35%, transparent 55%);',
    };
@endphp

<section {{ $attributes->merge(['class' => 'relative overflow-hidden rounded-[20px] md:rounded-[48px] pt-16 md:pt-32 p-7 md:pb-16 md:px-12']) }}
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
    {{-- Corner color glow --}}
    <div class="absolute inset-0 pointer-events-none" style="{{ $cornerGradient }}"></div>
    {{-- Content --}}
    <div class="relative z-10">
        {{ $slot }}
    </div>
</section>
