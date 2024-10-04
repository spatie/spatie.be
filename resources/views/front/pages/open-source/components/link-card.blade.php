@props([
    'light' => false,
    'title' => null,
    'href' => null,
    'link' => null,
    'target' => null,
    'as' => 'div'
])
<{{ $as }}
    {{ $attributes->merge([
        'class' => 'relative flex flex-col group rounded-[20px] p-7 md:p-10 text-[14px] md:text-[16px] leading-normal ' . ($light ? 'text-oss-royal-blue' : 'link-card text-oss-gray shadow-oss-card'),
    ])->except(['href', 'target']) }}
    @if ($as === 'a')
        href="{{ $href }}"
    @endif
>
    @if ($light)
        <div class="transition-all absolute inset-0 bg-link-card-light rounded-[20px] group-hover:opacity-0"></div>
        <div class="transition-all absolute inset-0 bg-link-card-light-hover rounded-[20px] opacity-0 group-hover:opacity-100"></div>
    @else
        <div class="transition-all absolute inset-0 bg-link-card rounded-[20px]"></div>
    @endif
    <h3 class="{{ $light ? 'text-oss-royal-blue' : 'text-oss-gray'  }} text-[18px] md:text-[24px] mb-5 leading-tight">{{ $title }}</h3>
    <div class="h-full @if ($href && $as !== 'a') mb-9 @endif">
        {{ $slot }}
    </div>
    @if ($href && $as !== 'a')
    <a class="flex items-center gap-x-2 mt-auto" href="{{ $href }}" @if($target) target="{{ $target }}" @endif>
        <svg class="w-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
        <span class="underline">{{ $link }}</span>
    </a>
    @endif
</{{ $as }}>
