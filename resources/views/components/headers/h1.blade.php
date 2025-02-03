@php
    $tag = $tag ?? 'h1';
@endphp
<{{ $tag }} {{ $attributes->twMerge('font-druk uppercase text-[60px]/[0.9] sm:text-[96px]/[0.83] font-bold') }}>
    {{ $slot }}
</{{ $tag }}>
