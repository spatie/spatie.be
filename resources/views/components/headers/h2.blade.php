@php
    $tag = $tag ?? 'h2';
@endphp
<{{ $tag }} {{ $attributes->twMerge('font-druk uppercase text-5xl/[0.8] sm:text-7xl/[0.8] font-bold') }}>
    {{ $slot }}
</{{ $tag }}>
