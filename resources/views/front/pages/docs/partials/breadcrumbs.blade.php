<section id="breadcrumb" class="hidden md:block py-4 md:py-6 lg:py-8">
    <div class="wrap">
        <p class="mt-4">
            <a href="{{ route('docs')}}" class="link-underline link-blue">Docs</a>
            <span class="icon mx-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-right') }}</span>
            <a
                class="link-underline link-blue"
                href="{{ action([\App\Http\Controllers\DocsController::class, 'repository'], [$repository->slug, $alias->slug]) }}"
            >{{ ucfirst($repository->slug) }}</a>
            @if(! $page->isRootPage())
                <span class="icon mx-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-right') }}</span>
                <span>{{ ucfirst($page->section) }}</span>
            @endif
            <span class="icon mx-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-right') }}</span>
            <span>{{ $page->title }}</span>
        </p>
    </div>
</section>
