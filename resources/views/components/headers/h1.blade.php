@php
    $tag = $tag ?? 'h1';
@endphp
<{{ $tag }} {{ $attributes->twMerge('font-druk uppercase text-[60px]/[0.8] sm:text-[85px]/[0.8] font-bold') }}>
    {{ $slot }}
</{{ $tag }}>
