@php
    $item = $product ?? $bundle ?? null;
    $color = $item?->color ?? $color ?? '#2e7288';
@endphp

@if($color)
    @push('startBody')
        <div class="wallpaper">
            <div class="h-[75vh]" style="background: radial-gradient(ellipse 80% 80% at 50% 0%, {{ $color }} 0%, rgba(5,5,8,0) 100%)">
                <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(5,5,8,0) 30%, #050508 100%)"></div>
            </div>
        </div>
    @endpush
@endif
