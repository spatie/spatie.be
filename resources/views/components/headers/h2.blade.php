@php
    $tag = $tag ?? 'h2';
@endphp
<{{ $tag }} {{ $attributes->twMerge('font-druk uppercase text-72 leading-90 font-bold') }}>
    {{ $slot }}
</{{ $tag }}>
