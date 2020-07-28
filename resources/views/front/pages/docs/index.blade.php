<x-page
        title="Documentation"
        background="/backgrounds/about.jpg">
    <x-slot name="description">
        This is a placeholder
    </x-slot>

    {{--    @include('front.pages.about.partials.banner')--}}

    <div class="section section-group wrap md:grid md:grid-cols" style="--cols: 1fr 2fr">
        <div>
            <article class="article">
                Summary of docs available
                <ul>
                    @foreach($repositories as $repository)
                        <li>
                            <a href="{{ action([\App\Http\Front\Controllers\DocsController::class, 'repository'], $repository->slug) }}">
                                {{ $repository->slug }}
                            </a>

                            <p>{{ $repository->aliases->last()->slogan }}</p>
                        </li>
                    @endforeach
                </ul>
            </article>
        </div>
    </div>
</x-page>
