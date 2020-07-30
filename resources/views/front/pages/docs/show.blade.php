<x-page
        title="{{ $page->title }}"
        background="/backgrounds/about.jpg">
    <x-slot name="description">
        This is a placeholder
    </x-slot>

{{--    @include('front.pages.about.partials.banner')--}}

    {{ $page->alias }}

    {{ $page->repository }}

    <div class="section section-group wrap md:grid md:grid-cols" style="--cols: 1fr 2fr">
        <div>
            @include('front.pages.docs.partials.navigation')
        </div>


        <div>
            <article class="article">
                {!! $page->contents !!}
            </article>

            <div>
                <a href="{{ $alias->githubUrl }}/blob/{{$alias->slug}}/docs/{{ $page->slug }}.md" target="_blank">Edit on github</a>
            </div>
    </div>
</x-page>
