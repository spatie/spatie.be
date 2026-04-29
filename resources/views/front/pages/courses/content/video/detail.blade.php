<div class="px-3 sm:px-16 md:px-10 lg:px-16 pb-20">
    <section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0 mt-8">
        <div class="grid md:grid-cols-[280px,1fr] gap-8 items-start">
            <div class="md:sticky md:top-4">
                @include('front.pages.courses.content.video.sidebar')
            </div>
            <div>
                @include('front.pages.courses.partials.vimeo')

                <div class="w-full rounded-[20px] overflow-hidden shadow-oss-card relative" id="vimeo"
                     style="height: 0; padding-bottom: 56.25%;">
                    @if ($lesson->canBeSeenByCurrentUser() || $lesson->display === \App\Models\Enums\LessonDisplayEnum::HIDDEN)
                        <iframe id="player" class="absolute inset-0 w-full h-full"
                                src="https://player.vimeo.com/video/{{ $video->vimeo_id }}?h={{ $video->hash }}&loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media"
                                allowfullscreen allowtransparency></iframe>
                    @else
                        <div class="absolute inset-0 flex justify-center items-center bg-oss-purple-extra-dark text-white z-10 p-8">
                            <div class="flex flex-col items-center text-center">
                                @if ($lesson->display === \App\Models\Enums\LessonDisplayEnum::LICENSE)
                                    <h4 class="mb-2 font-bold text-lg md:text-2xl">This video is part of a course.</h4>
                                    <p class="hidden md:block text-center text-oss-gray">
                                        You'll need to buy the course to view this content!
                                    </p>
                                    <a class="mt-4 md:mt-8 inline-flex items-center gap-2 px-6 py-3 bg-oss-green-pale text-oss-royal-blue font-bold rounded-lg hover:opacity-90 transition-opacity"
                                       href="{{ $lesson->series->purchasables->first()?->product->getUrl() }}">
                                        Buy a license
                                    </a>
                                @elseif ($lesson->display === \App\Models\Enums\LessonDisplayEnum::AUTH)
                                    <h4 class="mb-2 font-bold text-lg md:text-2xl">This video is only for members.</h4>
                                    <p class="hidden md:block text-center text-oss-gray">
                                        You'll need to log in to view this video!
                                    </p>
                                    <a class="mt-4 md:mt-8 inline-flex items-center gap-2 px-6 py-3 bg-oss-green-pale text-oss-royal-blue font-bold rounded-lg hover:opacity-90 transition-opacity"
                                       href="{{ route('login') }}">
                                        Log in or create a free account
                                    </a>
                                @elseif(session()->has('not-a-sponsor'))
                                    <h4 class="mb-2 font-bold text-lg md:text-2xl">Aaaaw... you're not a sponsor yet.</h4>
                                    <p class="hidden md:block text-center text-oss-gray">
                                        Become one to get access to this video right away!
                                    </p>
                                    <a class="mt-4 md:mt-8 inline-flex items-center gap-2 px-6 py-3 bg-oss-green-pale text-oss-royal-blue font-bold rounded-lg hover:opacity-90 transition-opacity"
                                       href="https://github.com/sponsors/spatie" target="_blank">
                                        <span class="size-5 text-white">{{ app_svg('github') }}</span>
                                        Become a GitHub Sponsor
                                    </a>
                                @else
                                    <h4 class="mb-2 font-bold text-lg md:text-2xl">This video is exclusively for GitHub sponsors.</h4>
                                    <p class="hidden md:block text-center text-oss-gray">
                                        Sponsorships make videos like these possible!
                                    </p>
                                    <div class="mt-4 md:mt-8 flex flex-col md:flex-row gap-2">
                                        @guest
                                            <a class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-oss-green-pale text-oss-royal-blue font-bold rounded-lg hover:opacity-90 transition-opacity"
                                               href="/login/github">
                                                <span class="size-5">{{ app_svg('github') }}</span>
                                                Log in
                                            </a>
                                        @endguest
                                        <a class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-oss-green-pale text-oss-royal-blue font-bold rounded-lg hover:opacity-90 transition-opacity"
                                           href="https://github.com/sponsors/spatie" target="_blank">
                                            Become a GitHub Sponsor
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                @if ($lesson->canBeSeenByCurrentUser())
                    <div class="flex items-center mt-4 text-sm">
                        <div class="text-oss-gray-dark space-y-1">
                            @if($video->downloadable)
                                <div class="flex gap-2">
                                    <span>Download video:</span>
                                    <a href="{{ $video->download_hd_url }}" class="underline hover:text-white transition-colors">HD</a>
                                    <span>|</span>
                                    <a href="{{ $video->download_sd_url }}" class="underline hover:text-white transition-colors">SD</a>
                                </div>
                            @endif
                        </div>

                        @if(auth()->user())
                            <div class="ml-auto">
                                <livewire:lesson-completed-button :lesson="$video->lesson"/>
                            </div>
                        @endif
                    </div>
                @endif

                <h2 class="font-druk uppercase text-[40px] leading-[0.9] mb-8 mt-12 text-white">{{ $lesson->title }}</h2>

                <div class="bg-oss-purple-extra-dark shadow-oss-card rounded-[20px] p-8 md:p-12 text-lg markup markup-titles markup-lists text-oss-gray links-underline">
                    {!! $video->formatted_description !!}
                </div>

                @if ($previousLesson || $nextLesson)
                    <div class="mt-8 flex items-center justify-between py-6 border-t border-white/10">
                        @if ($previousLesson)
                            <a class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 text-white font-bold rounded-lg hover:bg-white/15 transition-colors"
                               href="{{ $previousLesson->url }}">
                                <svg class="w-2 fill-current rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
                                <span class="truncate max-w-[200px]">{{ $previousLesson->title }}</span>
                            </a>
                        @else
                            <div></div>
                        @endif
                        @if ($nextLesson)
                            <div class="text-right">
                                <span class="text-oss-gray-dark text-sm">Up next</span>
                                <a class="inline-flex items-center gap-2 px-6 py-3 bg-oss-green-pale text-oss-royal-blue font-bold rounded-lg hover:opacity-90 transition-opacity"
                                   href="{{ $nextLesson->url }}">
                                    <span class="truncate max-w-[200px]">{{ $nextLesson->title }}</span>
                                    <svg class="w-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
