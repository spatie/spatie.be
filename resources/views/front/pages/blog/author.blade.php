<x-page
    :title="$member->full_name"
    background="/backgrounds/blog-index.jpg"
    body-class="bg-oss-gray"
    main-class="font-pt text-oss-royal-blue font-medium text-18 leading-140 antialiased"
    :description="$member->description"
    footerCta
    livewire
>
    @push('head')
        {!! schema()->authorPage($member) !!}
    @endpush

    <header class="wrapper-lg px-7 sm:px-16 mt-8 sm:mt-20">
        <a href="{{ route('blog') }}" wire:navigate.hover class="text-base font-semibold hover:text-oss-spatie-blue">
            &larr; Blog
        </a>
        <div class="mt-6 flex flex-col-reverse md:flex-row md:items-center md:justify-between gap-8">
            <h1 class="font-druk uppercase text-[72px] lg:text-[144px] leading-[0.8] font-bold text-white drop-shadow-2xl">
                {{ $member->first_name }}<br>{{ $member->last_name }}
            </h1>
            <img
                src="{{ gravatar_url($member->email, 480) }}"
                alt=""
                width="224"
                height="224"
                class="size-24 md:size-28 lg:size-56 flex-shrink-0 rounded-full object-cover ring-4 ring-white/60 shadow-big"
            >
        </div>
        <ul class="mt-8 flex flex-wrap gap-x-6 gap-y-2 text-xl">
            @if($member->twitter)
                <li><a class="underline transition hover:text-oss-spatie-blue" href="https://x.com/{{ $member->twitter }}">{{ '@'.$member->twitter }}</a></li>
            @endif
            @if($member->github)
                <li><a class="underline transition hover:text-oss-spatie-blue" href="https://github.com/{{ $member->github }}">github.com/{{ $member->github }}</a></li>
            @endif
            @if($member->website)
                <li><a class="underline transition hover:text-oss-spatie-blue" href="{{ $member->website }}">{{ $member->website_domain }}</a></li>
            @endif
        </ul>
    </header>

    <x-blog.highlight :post="$highlight" class="mt-12 md:mt-16" />

    @if($posts->isNotEmpty())
        <div class="wrapper-lg px-7 sm:px-16 mt-16 lg:mt-24">
            <div class="grid gap-8 sm:grid-cols-[1fr,3fr]">
                <h2 class="hidden sm:block text-24 font-bold pt-9">More posts</h2>
                <div class="space-y-8 sm:space-y-0">
                    @foreach($posts as $post)
                        <x-blog.list-item :insight="$post" />
                        @if(!$loop->last)
                            <hr class="sm:hidden h-px bg-oss-gray-medium">
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="wrapper-lg sm:px-16 my-16 lg:my-24">
        <livewire:newsletter />
    </div>
</x-page>
