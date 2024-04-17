<section id="breadcrumb" class="hidden md:block max-w-screen-xl mx-auto w-full text-[14px]">
    <p class="text-oss-royal-blue ">
        <a href="{{ route('docs')}}">Docs</a>
        <span class="icon mx-2 fill-current text-oss-royal-blue-light">{{ app_svg('icons/far-angle-right') }}</span>
        <a href="{{ action([\App\Http\Controllers\DocsController::class, 'repository'], [$repository->slug, $alias->slug]) }}"
        >{{ ucfirst($repository->slug) }}</a>
        @if(! $page->isRootPage())
            <span class="icon mx-2 fill-current text-oss-royal-blue-light">{{ app_svg('icons/far-angle-right') }}</span>
            <span>{{ ucfirst($page->section) }}</span>
        @endif
        <span class="icon mx-2 fill-current text-oss-royal-blue-light">{{ app_svg('icons/far-angle-right') }}</span>
        <span>{{ $page->title }}</span>
    </p>
</section>
