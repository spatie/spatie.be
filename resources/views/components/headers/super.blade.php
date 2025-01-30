@php
    $tag = $tag ?? 'h1';
@endphp
<{{ $tag }} {{ $attributes->twMerge('font-druk uppercase text-7xl/[0.9] lg:text-[9rem]/[0.9] font-bold') }}>
    {{ $slot }}
</{{ $tag }}>
