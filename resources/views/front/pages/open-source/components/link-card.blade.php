@props([
    'light' => false,
    'title' => null,
    'href' => null,
    'link' => null,
])
<div
    {{ $attributes->merge([
        'class' => 'rounded-[20px] p-7 md:p-10 text-[14px] md:text-[16px] leading-normal ' . ($light ? 'bg-link-card-light text-oss-royal-blue' : 'link-card bg-link-card text-oss-gray shadow-oss-card'),
    ]) }}
>
    <h3 class="{{ $light ? 'text-oss-royal-blue' : 'text-oss-gray'  }} text-[18px] md:text-[24px] mb-5 leading-tight">{{ $title }}</h3>
    {{ $slot }}
    @if ($href)
    <a class="text-sm flex items-center gap-x-2 mt-9" href="{{ $href }}">
        <svg class="w-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
        <span class="underline">{{ $link }}</span>
    </a>
    @endif
</div>
