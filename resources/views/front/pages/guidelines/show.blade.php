<x-page title="{{ $page->title }}" background="/backgrounds/docs.jpg">
    <x-slot name="description">
        {{ $page->description }}
    </x-slot>

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                {{ $page->title }}
            </h1>
            <p class="banner-intro">
                {{ $page->description }}
            </p>
        </div>
    </section>

    <section class="section">
        <div class="wrap">
            <div class="grid grid-cols-1 sm:grid-cols-3 sm:gap-16">
                <div class="col-span-2 markup markup-titles markup-lists markup-links markup-code">
                    {{ $page->contents }}

                    <p>
                        <a href="https://github.com/spatie/spatie.be/edit/master/resources/views/front/pages/guidelines/pages/{{ $page->slug }}.md"
                            target="_blank">Edit on github</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
</x-page>

