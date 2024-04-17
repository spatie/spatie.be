@props([
    'title',
    'icon',
    'description' => '',
    'href' => '',
    'color' => 'purple',
])
<!--
    bg-orange text-orange
    bg-orange-dark text-orange-dark
    bg-purple text-purple
    bg-pink text-pink
    bg-blue text-blue
-->
<aside class="flex w-full">
    <div class="bg-{{ $color }} text-white flex flex-col justify-center rounded-lg p-5 gap-3 text-sm">
        <div class="text-lg icon bg-white text-{{ $color }} rounded-full w-8 flex items-center justify-center h-8">
            {{ app_svg($icon) }}
        </div>
        <div class="font-bold">
            {{ $title }}
        </div>
        <p>{{ $description }}</p>
        <a href="{{ $href }}" class="mt-2">
            <button type="button" class="px-4 py-2.5 rounded text-oss-royal-blue bg-white cursor-pointer">
                Learn&nbsp;more
            </button>
        </a>
        @include('front.pages.docs.banners.hideButton')
    </div>
</aside>
