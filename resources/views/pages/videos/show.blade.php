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

                    <div class="w-full shadow-lg bg-white overflow-hidden" id="player" style="height: 0; padding-bottom: 56.25%;">
                        @if ($currentVideo->canBeSeenByCurrentUser())
                            <iframe class="absolute pin w-full h-full" src="https://player.vimeo.com/video/{{ $currentVideo->vimeo_id }}?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media" allowfullscreen allowtransparency></iframe>
                        @else
                                <div class="absolute pin flex justify-center items-center inset-green z-10 p-8">
                                    <div class="flex flex-col items-center text-center">
                                        <h4 class="mb-2 font-serif-bold text-2xl leading-tight">This video is exclusively for GitHub sponsors.</h4>
                                        <p class="hidden md:block text-center">
                                            Your sponsorship helps make videos like these possible! 
                                            <span class="fill-pink icon">
                                                {{ svg('icons/fas-heart') }}
                                            </span>
                                        </p>
                                        @guest
                                                <a class="mt-8 text-sm font-sans-bold cursor-pointer bg-white hover:shadow-lg shadow  flex items-center px-4 py-2 rounded-full text-green" href="/login/github">
                                                    <span>Log in with GitHub</span>
                                                    <span class="ml-2 h-6 w-6 text-black">
                                                        {{ svg('github') }}
                                                    </span>                                                
                                                </a>
                                        @else
                                                <a class="mt-8 text-sm font-sans-bold cursor-pointer bg-white hover:shadow-lg shadow  flex items-center px-4 py-2 rounded-full text-green" href="https://github.com/sponsors/spatie" target="__blank">
                                                    <span>Become A GitHub Sponsor</span>
                                                    <span class="ml-2 h-6 w-6 text-black">
                                                        {{ svg('github') }}
                                                    </span>                                                
                                                </a>
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
