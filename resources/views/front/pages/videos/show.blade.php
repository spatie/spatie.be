<x-page
        :title="$currentVideo->title"
        background="/backgrounds/video-blur.jpg"
        :description="$currentVideo->description"
>
    <section id="breadcrumb" class="hidden md:block py-4 md:py-6 lg:py-8">
        <div class="wrap">
            <p class="mt-4 links-underline links-blue">
                <a href="{{ route('videos.index')}}">Videos</a>
                <span class="icon mx-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-right') }}</span>

                <a href="{{ route('series.show', $series) }}" class="">{{ $series->title }}</a>

                <span class="icon mx-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-right') }}</span>
                <span>{{ $currentVideo->title }}</span>
            </p>
        </div>
    </section>

    <div class="pb-16 md:pb-24 xl:pb-32">
        <section id="video">
            <div class="wrap wrap-6 items-stretch">
                <div class="z-10 | md:col-span-2 | print:hidden">
                    @include('front.pages.videos.partials.sidebar')
                </div>
                <div class="pt-8 | md:pt-0 md:col-start-3 md:col-span-4">
                    @include('front.pages.videos.partials.vimeo')

                    <div class="w-full shadow-lg bg-white overflow-hidden" id="vimeo"
                         style="height: 0; padding-bottom: 56.25%;">
                        @if ($currentVideo->canBeSeenByCurrentUser())
                            <iframe id="player" class="absolute inset-0 w-full h-full"
                                    src="https://player.vimeo.com/video/{{ $currentVideo->vimeo_id }}?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media"
                                    allowfullscreen allowtransparency></iframe>
                        @else
                            <div class="absolute inset-0 flex justify-center items-center gradient gradient-dark text-white z-10 p-8">
                                <div class="flex flex-col items-center text-center">
                                    @if ($currentVideo->display === \App\Models\Enums\VideoDisplayEnum::LICENSE)
                                        <h4 class="mb-2 font-serif-bold text-lg md:text-2xl leading-tight">This video is
                                            part of a course.</h4>
                                        <p class="hidden md:block text-center">
                                            You'll need to buy the course to view this video!
                                        </p>
                                        <a class="mt-4 md:mt-8 font-sans-bold cursor-pointer bg-green hover:bg-green-dark justify-center flex items-center px-6 py-2 rounded-full text-white"
                                           href="{{ $series->purchasables->first()->product->getUrl() }}">
                                            <span>Buy a license</span>
                                        </a>
                                    @elseif ($currentVideo->display === \App\Models\Enums\VideoDisplayEnum::AUTH)
                                        <h4 class="mb-2 font-serif-bold text-lg md:text-2xl leading-tight">This video is
                                            only for members.</h4>
                                        <p class="hidden md:block text-center">
                                            You'll need to log in to view this video!
                                        </p>
                                        <a class="mt-4 md:mt-8 font-sans-bold cursor-pointer bg-green hover:bg-green-dark justify-center flex items-center px-6 py-2 rounded-full text-white"
                                           href="{{ route('login') }}">
                                            <span>Log in or create a free account</span>
                                        </a>
                                    @elseif(session()->has('not-a-sponsor'))
                                        <h4 class="mb-2 font-serif-bold text-lg md:text-2xl leading-tight">Aaaaw… you're
                                            not a sponsor yet.</h4>
                                        <p class="hidden md:block text-center">
                                            Become one to get access to this video right away!
                                            <span class="fill-current text-pink icon">
                                                    {{ svg('icons/fas-heart') }}
                                                </span>
                                        </p>
                                        <a class="mt-4 md:mt-8 font-sans-bold cursor-pointer bg-green hover:bg-green-dark justify-center flex items-center px-6 py-2 rounded-full text-white"
                                           href="https://github.com/sponsors/spatie" target="_blank">
                                                <span class="mr-3 h-6 w-6 text-white">
                                                    {{ svg('github') }}
                                                </span>
                                            <span>Become a GitHub Sponsor</span>
                                        </a>
                                    @else
                                        <h4 class="mb-2 font-serif-bold text-lg md:text-2xl leading-tight">This video is
                                            exclusively for GitHub sponsors.</h4>
                                        <p class="hidden md:block text-center">
                                            Sponsorships make videos like these possible!
                                            <span class="fill-current text-pink icon">
                                                    {{ svg('icons/fas-heart') }}
                                                </span>
                                        </p>
                                        <div class="mt-4 md:mt-8 md:flex">
                                            @guest
                                                <a class="font-sans-bold cursor-pointer bg-green hover:bg-green-dark justify-center flex items-center px-6 py-2 rounded-full md:rounded-r-none text-white"
                                                   href="/login/github">
                                                        <span class="mr-3 h-6 w-6 text-white">
                                                            {{ svg('github') }}
                                                        </span>
                                                    <span>Log in</span>
                                                </a>
                                            @endguest
                                            <a class="mt-2 md:mt-0 font-sans-bold cursor-pointer md:border-l-2 md:border-green-dark bg-green hover:bg-green-dark justify-center flex items-center px-6 py-2 rounded-full @guest md:rounded-l-none @endguest text-white"
                                               href="https://github.com/sponsors/spatie" target="_blank">
                                                <span>Become a GitHub Sponsor</span>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    @if ($currentVideo->canBeSeenByCurrentUser())
                        <div class="flex items-center mt-4">
                            <div class="text-xs links-underline links-blue space-y-1">
                                @if($currentVideo->downloadable)
                                    <div class="flex space-x-2">
                                        <span class="text-gray">Download video:</span>
                                        <a href="{{ $currentVideo->download_hd_url }}">HD</a>
                                        <span class="char-separator">|</span>
                                        <a href="{{ $currentVideo->download_sd_url }}">SD</a>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-auto">
                                <livewire:video-completed-button :video="$currentVideo"/>
                            </div>
                        </div>

                    @endif

                    <h2 class="title line-after mt-12">{{ $currentVideo->title }}</h2>

                    <div class="mt-8 text-lg links-underline links-blue markup markup-titles markup-lists">
                        {!! $currentVideo->formatted_description !!}
                    </div>

                    <hr class="mt-12 line-after"/>

                    <div class="mt-4 w-full overflow-hidden | md:flex justify-between links-blue links-underline text-xs">
                        @if ($previousVideo)
                            <a class="mb-2 md:w-1/2 md:pr-4 flex items-center" href="{{ $previousVideo->url }}">
                                <span class="w-1 fill-current text-blue mr-1 hidden | md:inline-block">
                                    {{ svg('icons/far-angle-left') }}
                                </span>
                                <span class="truncate"><span class="font-semibold md:hidden">Previous: </span>{{ $previousVideo->title }}</span>
                            </a>
                        @endif
                        @if ($nextVideo)
                            <a class="mb-2 md:w-1/2 md:pl-4 flex items-center md:justify-end ml-auto"
                               href="{{ $nextVideo->url }}">
                                <span class="truncate"><span class="font-semibold md:hidden">Next: </span>{{ $nextVideo->title  }}</span>
                                <span class="w-1 fill-current text-blue ml-1 hidden | md:inline-block">
                                    {{ svg('icons/far-angle-right') }}
                                </span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-page>
