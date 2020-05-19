@extends('layout.default', [
    'background' => '/backgrounds/videos.jpg',
    'title' => $currentVideo->title,
    'description' => $currentVideo->description,
])

@section('content')
    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                {{ $series->title }}
            </h1>
            <p class="mt-4">
                <span class="icon mr-2 opacity-50 fill-blue">{{ svg('icons/far-angle-left') }}</span> <a href="{{ route('videos.index')}}" class="link-underline link-blue">Videos overview</a>
            </p>
        </div>
    </section>

    <div class="section-group pt-0 section-fade z-10">
        <section id="video" class="section">
            <div class="wrap-8 items-start">
                <div class="sm:startx-2 sm:spanx-3 | md:spanx-4 | lg:spanx-5">
                    @include('pages.videos.partials.vimeo')

                    <div class="w-full h-0 shadow-lg bg-white" id="player" style="padding-bottom: 56.25%;">
                        @if ($currentVideo->canBeSeenByCurrentUser())
                            <iframe class="absolute pin w-full h-full" src="https://player.vimeo.com/video/{{ $currentVideo->vimeo_id }}?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media" allowfullscreen allowtransparency></iframe>
                        @else
                            <div class="absolute pin-b pin-l pin-r pin-t bg-blue overflow-hidden">
                                <div class="absolute pin-b pin-l pin-r pin-t z-0 overflow-hidden" style="
                                    transform: scale(1.05);
                                    background-image: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.3)), url('https://placehold.it/3008x1692');
                                    filter: blur(4px);
                                    -webkit-filter: blur(4px);
                                    background-position: center;
                                    background-repeat: no-repeat;
                                    background-size: cover;
                                "></div>
                                <div class="flex flex-col justify-center items-center relative z-10 h-full w-full">
                                    <div class="font-bold md:mb-8 md:text-3xl text-center text-white">This video is restricted to GitHub sponsors only.</div>
                                    <div class="hidden md:block md:mb-8 text-center text-white md:text-xl">Your sponsorship helps make videos like these possible! ❤️</div>
                                    @guest
                                        <div class="mt-4">
                                            <a class="text-sm md:text-base cursor-pointer border-2 border-white flex hover:border-gray-300 hover:text-gray-400 items-center px-4 md:px-8 py-1 md:py-2 rounded-full shadow text-white" href="/login/github">
                                                <span class="mr-2">Log in with GitHub</span>
                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
                                            </a>
                                        </div>
                                    @else
                                        <div class="mt-4">
                                            <a class="text-sm md:text-base cursor-pointer border-2 border-white flex hover:border-gray-300 hover:text-gray-400 items-center px-4 md:px-8 py-1 md:py-2 rounded-full shadow text-white" href="https://github.com/sponsors/spatie" target="__blank">
                                                <span class="mr-4">Become A GitHub Sponsor</span>
                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                     <div class="mt-4 w-full overflow-hidden | md:flex justify-between links-blue links-underline text-xs">
                        @if ($previousVideo)
                            <a class="mb-2 md:w-1/2 md:pr-4 flex items-center" href="{{ $previousVideo->url }}">
                                <span class="w-1 fill-blue mr-1 hidden | md:inline-block">
                                    {{ svg('icons/far-angle-left') }}
                                </span>
                                <span class="truncate"><span class="font-semibold md:hidden">Previous: </span>{{ $previousVideo->title }}</span>
                            </a>
                        @endif
                        @if ($nextVideo)
                            <a class="mb-2 md:w-1/2 md:pl-4 flex items-center md:justify-end ml-auto" href="{{ $nextVideo->url }}">
                                <span class="truncate"><span class="font-semibold md:hidden">Next: </span>{{ $nextVideo->title  }}</span>
                                <span class="w-1 fill-blue ml-1 hidden | md:inline-block">
                                    {{ svg('icons/far-angle-right') }}
                                </span>
                            </a>
                        @endif
                    </div>

                    <h2 class="mt-8 title line-after mb-16">{{ $currentVideo->title }}</h2>

                    <div class="text-lg">
                        {!! $currentVideo->formatted_description !!}
                    </div>
                </div>

                <div class="banner-menu | print:hidden">
                    @include('pages.videos.partials.sidebar')
                </div>

            </div>
        </section>
    </div>

@overwrite
