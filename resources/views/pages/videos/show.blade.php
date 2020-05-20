@extends('layout.default', [
    'background' => '/backgrounds/video-detail.jpg',
    'title' => $currentVideo->title,
    'description' => $currentVideo->description,
])

@section('content')
    <section id="breadcrumb" class="hidden md:block py-4 md:py-6 lg:py-8">
        <div class="wrap">
            <p class="mt-4">
                <a href="{{ route('videos.index')}}" class="link-underline link-blue">Videos</a>
                <span class="icon mx-2 opacity-50 fill-blue">{{ svg('icons/far-angle-right') }}</span>
                <a href="{{ $series->url }}" class="link-underline link-blue">{{ $series->title }}</a>
                <span class="icon mx-2 opacity-50 fill-blue">{{ svg('icons/far-angle-right') }}</span>
                <span class="font-sans-bold">{{ $currentVideo->title }}</span>
            </p>
        </div>
    </section>

    <div class="pb-16 md:pb-24 xl:pb-32">
        <section id="video">
            <div class="wrap-8 items-start">
                <div class="pt-8 md:pt-0 sm:startx-2 sm:spanx-3 | md:spanx-4 | lg:spanx-5">
                    @include('pages.videos.partials.vimeo')

                    <div class="w-full shadow-lg bg-white overflow-hidden" id="player" style="height: 0; padding-bottom: 56.25%;">
                        @if ($currentVideo->canBeSeenByCurrentUser())
                            <iframe class="absolute pin w-full h-full" src="https://player.vimeo.com/video/{{ $currentVideo->vimeo_id }}?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media" allowfullscreen allowtransparency></iframe>
                        @else
                                <div class="absolute pin flex justify-center items-center inset-dark z-10 p-8">
                                    <div class="flex flex-col items-center text-center">
                                        @if(session()->has('not-a-sponsor'))
                                            <h4 class="mb-2 font-serif-bold text-lg md:text-2xl leading-tight">Aaaaw… you're not a sponsor yet.</h4>
                                            <p class="hidden md:block text-center">
                                                Become one to get access to this video right away! 
                                                <span class="fill-pink icon">
                                                    {{ svg('icons/fas-heart') }}
                                                </span>
                                            </p>
                                            <a class="mt-4 md:mt-8 font-sans-bold cursor-pointer bg-green hover:bg-green-dark justify-center flex items-center px-6 py-2 rounded-full text-white" href="https://github.com/sponsors/spatie" target="_blank">
                                                <span class="mr-3 h-6 w-6 text-white">
                                                    {{ svg('github') }}
                                                </span>                                                
                                                <span>Become a GitHub Sponsor</span>
                                            </a>
                                        @else
                                            <h4 class="mb-2 font-serif-bold text-lg md:text-2xl leading-tight">This video is exclusively for GitHub sponsors.</h4>
                                            <p class="hidden md:block text-center">
                                                Sponsorship makes videos like these possible! 
                                                <span class="fill-pink icon">
                                                    {{ svg('icons/fas-heart') }}
                                                </span>
                                            </p>
                                            <div class="mt-4 md:mt-8 md:flex">
                                                <a class="font-sans-bold cursor-pointer bg-green hover:bg-green-dark justify-center flex items-center px-6 py-2 rounded-full md:rounded-r-none text-white" href="/login/github">
                                                    <span class="mr-3 h-6 w-6 text-white">
                                                        {{ svg('github') }}
                                                    </span>                                                
                                                    <span>Log in</span>
                                                </a>
                                                <a class="mt-2 md:mt-0 font-sans-bold cursor-pointer md:border-l-2 md:border-green-dark bg-green hover:bg-green-dark justify-center flex items-center px-6 py-2 rounded-full md:rounded-l-none text-white" href="https://github.com/sponsors/spatie" target="_blank">
                                                    <span>Become a GitHub Sponsor</span>                                             
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

                    <h2 class="title line-after mt-8">{{ $currentVideo->title }}</h2>

                    <div class="mt-8 text-lg links-underline links-blue markup markup-titles markup-lists">
                        {!! $currentVideo->formatted_description !!}
                    </div>
                </div>

                <div class="z-10 banner-menu | print:hidden">
                    @include('pages.videos.partials.sidebar')
                </div>

            </div>
        </section>
    </div>

@overwrite
