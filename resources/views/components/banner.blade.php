@props([
    'title',
    'icon',
    'description' => '',
    'href' => '',
    'color' => 'purple',
    'class' => '',
    'thin' => false,
])
<!--
    bg-orange text-orange
    bg-orange-dark text-orange-dark
    bg-purple text-purple
    bg-pink text-pink
    bg-blue text-blue
-->
<aside class="flex w-full {{ $class }}">
    <div class="w-full bg-{{ $color }} text-white flex {{ $thin ? 'items-center justify-between' : 'flex-col justify-center' }} p-5 rounded-lg gap-3 text-sm">
        <div class="text-lg icon bg-white text-{{ $color }} rounded-full w-8 flex items-center justify-center h-8">
            {{ app_svg($icon) }}
        </div>
        <div class="{{ $thin ? 'mr-auto' : '' }}">
            <div class="font-bold">
                {{ $title }}
            </div>
            <p>{{ $description }}</p>
        </div>
        <a href="{{ $href }}" class="{{ $thin ? '' : 'mt-2' }}">
            <button type="button" class="px-4 py-2.5 rounded text-oss-royal-blue bg-white cursor-pointer">
                Learn&nbsp;more
            </button>
        </a>
    </div>
</aside>
