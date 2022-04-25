<x-page title="{{ $page->title }}" background="/backgrounds/guidelines-blur.jpg">
    @include('front.pages.guidelines.partials.writing-readable-php-cta')

    <x-slot name="description">
        {{ $page->description }}
    </x-slot>

    <section id="breadcrumb" class="hidden md:block py-4 md:py-6 lg:py-8">
        <div class="wrap">
            <p class="mt-4">
                <a href="{{ route('guidelines')}}" class="link-underline link-blue">Guidelines</a>
                <span class="icon mx-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-right') }}</span>
                <span>{{ $page->title }}</span>
            </p>
        </div>
    </section>

    <section class="wrap md:grid pb-24 gap-8 md:grid-cols-3 items-stretch">
        <div class="z-10 | print:hidden">
            <nav class="h-full md:px-4 py-6 md:bg-white md:bg-opacity-50 shadow-light rounded-sm">
                <div class="flex items-center pb-4 border-b-2 border-gray-lighter">
                    <a class="ml-auto flex items-center" href="https://github.com/spatie/spatie.be/edit/main/resources/views/front/pages/guidelines/pages/{{ $page->slug }}.md" rel="nofollow noreferer">
                        <span class="text-xs link-gray link-underline">
                            Edit
                        </span>
                        <span class="ml-2 flex text-xs link-gray">
                            <span class="w-4 h-4">
                                {{ svg('github') }}
                            </span>
                        </span>
                    </a>
                </div>

                <div class="sticky top-0 pt-6">
                    {{ $page->toc }}
                </div>
            </nav>
        </div>
        <div class="md:col-span-2">
            <div class="mb-16">
                <h1 class="banner-slogan">
                    {{ $page->title }}
                </h1>
                <div class="banner-intro flex items-center justify-start">
                    {{ $page->description }}
                </div>
            </div>

            <div class="markup markup-titles markup-lists markup-code links-blue links-underline">
                {{ $page->contents }}
            </div>
        </div>
    </section>

    @include('front.pages.docs.banners.randomBanner')
</x-page>

