@php
    $tag = $tag ?? 'h1';
@endphp
<{{ $tag }} {{ $attributes->twMerge('font-druk uppercase text-[72px] lg:text-[144px] leading-72 lg:leading-[125px] font-bold') }} style="text-shadow: 0px 0px 110px rgba(0, 0, 0, 0.2)">
    {{ $slot }}
</{{ $tag }}>
