@extends('layout.default')

@section('content')
    <div class="flex wrap">
        @include('pages.videos.partials.sidebar')
        <div>
            <div class="">
                @include('pages.videos.partials.vimeo')

                <div class="w-full overflow-hidden md:flex justify-between pb-10">
                    @if ($previousVideo)
                        <a class="mb-2 no-underline text-black md:w-1/2 md:pr-4 flex items-center text-sm opacity-75 hover:opacity-100" href="{{ $previousVideo->url }}">
                            <i class="fa fa-arrow-left text-sm opacity-50 mr-1 hidden | md:inline-block"></i>
                            <span class="truncate"><span class="font-semibold">Previous: </span> {{ $previousVideo->title }}</span>
                        </a>
                    @endif
                    @if ($nextVideo)
                        <a class="mb-2 no-underline text-black md:w-1/2 md:pl-4 flex items-center md:justify-end ml-auto text-sm opacity-75 hover:opacity-100" href="{{ $nextVideo->url }}">
                            <span class="truncate"><span class="font-semibold">Next</span>: {{ $nextVideo->title  }}</span>
                            <i class="fa fa-arrow-right text-sm opacity-50 ml-1 hidden | md:inline-block"></i>
                        </a>
                    @endif
                </div>

                <div class="w-full aspect-16x9 shadow-lg" id="player" style="padding-bottom: 56.25%;">
                    @if (! $currentVideo->only_for_sponsors || (auth()->user() && auth()->user()->is_sponsor))
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

                <div class="flex justify-between items-baseline">
                    <h2 class="mr-4">{{ $currentVideo->title }}</h2>
                </div>

                <div class="text-lg">
                    {!! $currentVideo->formatted_description !!}
                </div>

                @if ($currentVideo->download_hd_url || $currentVideo->download_sd_url)
                    <div class="mt-16 border-t-2 border-dark-100 pt-6">
                        <h3 class="mt-0">Downloads</h3>
                        @if ($currentVideo->download_hd_url)
                            <div class="py-2">
                                <a href="{{ $currentVideo->download_hd_url }}">
                                    HD Video
                                </a>
                                <span class="opacity-75 text-black text-sm">— {{ formatBytes($currentVideo->download_hd_size) }}</span>
                            </div>
                        @endif
                        @if ($currentVideo->download_sd_url)
                            <div class="py-2">
                                <a href="{{ $currentVideo->download_sd_url }}" class="py-2">
                                    SD Video
                                </a>
                                <span class="opacity-75 text-black text-sm">— {{ formatBytes($currentVideo->download_sd_size) }}</span>
                            </div>
                        @endif
                    </div>
                @endif
        </div>
    </div>
@overwrite
