<x-page title="{{ $page->title }} | {{ $repository->slug }}" background="/backgrounds/docs.jpg">
    <x-slot name="description">
        {{ $repository->slug }}
    </x-slot>

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                {{ $repository->slug }}
            </h1>
            <p class="banner-intro">
                {{ $alias->slogan }}
            </p>
            <div>
                <select name="alias">
                    @foreach($repository->aliases as $alias)
                        <option value="{{ $alias->slug }}">
                            {{ $alias->slug }} ({{ $alias->branch }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="wrap">
            <div class="grid grid-cols-3 gap-8">
                <div class="col-span-1">
                    @include('front.pages.docs.partials.navigation')
                </div>
                <div class="col-span-2 markup markup-titles markup-lists markup-links markup-code">
                    {!! $page->contents !!}
                    <p>
                        <a href="{{ $alias->githubUrl }}/blob/{{$alias->slug}}/docs/{{ $page->slug }}.md" target="_blank">Edit on github</a>
                    </p>
                </div>
            </div>
        </div>
    </section>


</x-page>

