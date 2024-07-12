@php
    $tag = $tag ?? 'h1';
@endphp
<{{ $tag }} {{ $attributes->twMerge('font-druk uppercase text-72 lg:text-144 leading-80 font-bold') }}>
    {{ $slot }}
</{{ $tag }}>
