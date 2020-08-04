<x-page title="Documentation" background="/backgrounds/docs.jpg">
    {{--    <x-slot name="description">--}}
    {{--        This is a placeholder--}}
    {{--    </x-slot>--}}

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Docs
            </h1>
            <p class="banner-intro">
                Documentation for our comprehensive packages
            </p>
        </div>
    </section>

    <section class="section section-group">
        @foreach($repositories->groupBy('category') as $category => $repositories)
            <div class="wrap">
                <h2 class="title line-after mb-12">{{ $category }}</h2>
            </div>
            <div class="wrap mb-24">
                <div class="grid col-gap-6 row-gap-16 | sm:grid-cols-2 items-stretch">
                    @foreach($repositories as $repository)
                        <div class="line-l">
                            <a href="{{ action([\App\Http\Front\Controllers\DocsController::class, 'repository'], $repository->slug) }}">

                                <h2 class="title-sm link-black link-underline">{{ $repository->slug }}</h2>
                                <p class="mt-4">{{ $repository->aliases->last()->slogan }}</p>
                                <div class="text-xs mt-4 text-gray">
                                    @foreach($repository->aliases as $alias)
                                        <span>
                                            <a href="{{action([\App\Http\Front\Controllers\DocsController::class, 'repository'], [$repository->slug, $alias->slug])}}">
                                                {{ $alias->slug }}
                                            </a>
                                            @if(! $loop->last)
                                                <span class="char-separator">•</span>
                                            @endif
                                        </span>
                                    @endforeach
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </section>
</x-page>
