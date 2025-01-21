@php
    $tag = $tag ?? 'h1';
@endphp
<{{ $tag }} {{ $attributes->twMerge('font-druk uppercase text-[72px] lg:text-[144px] leading-72 lg:leading-[125px] font-bold') }}>
    {{ $slot }}
</{{ $tag }}>
