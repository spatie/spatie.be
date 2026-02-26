<section id="breadcrumb" class="hidden md:block max-w-screen-xl mx-auto w-full text-[14px]">
    <p class="text-oss-royal-blue ">
        <a wire:navigate href="{{ route('guidelines') }}">Guidelines</a>
        <span class="icon mx-2 fill-current text-oss-royal-blue-light">{{ app_svg('icons/far-angle-right') }}</span>
        <span class="text-oss-spatie-blue font-bold">{{ $page->title }}</span>
    </p>
</section>
