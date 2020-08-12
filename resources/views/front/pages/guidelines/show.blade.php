<x-page title="{{ $page->title }}" background="/backgrounds/docs.jpg">
    <x-slot name="description">
        {{ $page->description }}
    </x-slot>

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                {{ $page->title }}
            </h1>
            <p class="mt-4 flex justify-start gap-8">
                <span>
                    <span class="icon mr-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-left') }}</span> <a href="{{ route('guidelines')}}" class="link-underline link-blue">Guidelines overview</a>
                </span>
                <span class="mx-2 text-blue-lighter">|</span>
                 <a class="flex items-center link-blue link-underline" href="https://github.com/spatie/spatie.be/edit/master/resources/views/front/pages/guidelines/pages/{{ $page->slug }}.md"
                            target="_blank">
                            Edit 
                            <span class="ml-1 w-4 h-4">
                                {{ svg('github') }}
                            </span>
                        </a>
            </p>
            
            <div class="mt-16 markup-titles markup-lists markup-code links-blue links-underline">
                {{ $page->contents }}
            </div>

        </div>
    </section>

</x-page>

