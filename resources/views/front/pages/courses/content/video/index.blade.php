<div class="px-3 sm:px-16 md:px-10 lg:px-16 pb-20">
    <section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0 mt-8">
        <div class="grid md:grid-cols-[280px,1fr] gap-8 items-start">
            <div class="md:sticky md:top-4">
                @include('front.pages.courses.content.video.sidebar')
            </div>
            <div>
                <div class="bg-oss-purple-extra-dark shadow-oss-card rounded-[20px] p-8 md:p-12 text-lg markup markup-titles markup-lists">
                    <h1 class="font-druk uppercase text-[40px] leading-[0.9] mb-8 text-white">{{ $series->title }}</h1>
                    <div class="text-oss-gray">
                        <x-markdown>{!! $series->introduction ?? $series->description !!}</x-markdown>
                    </div>
                </div>

                @if ($series->lessons->first() && $series->isOwnedByCurrentUser())
                    <div class="mt-8 flex items-center justify-between py-6 border-t border-white/10">
                        <div>
                            <span class="text-oss-gray-dark text-sm">Up next</span>
                            <span class="block font-semibold text-lg text-white">{{ $series->lessons->first()->title }}</span>
                        </div>
                        <a class="inline-flex items-center gap-2 px-6 py-3 bg-oss-green-pale text-oss-royal-blue font-bold rounded-lg hover:opacity-90 transition-opacity"
                           href="{{ $series->lessons->first()->url }}">
                            Continue
                            <svg class="w-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
