<div class="pb-16 md:pb-24 xl:pb-32">
    <section id="video">
        <div class="wrap wrap-6 mt-8 items-stretch">
            <div class="z-10 | sm:col-span-2 | print:hidden">
                @include('front.pages.courses.content.video.sidebar')
            </div>
            <div class="pt-8 | md:pt-0 sm:col-start-3 sm:col-span-4">
                <h2 class="title-xl">{{ $series->title }}</h2>

                <div class="mt-8 text-lg links-underline links-blue markup markup-titles markup-lists">
                    <x-markdown>{!! $series->introduction ?? $series->description !!}</x-markdown>
                </div>

                <hr class="-ml-4 mt-12 line-after"/>

                <div
                        class="mt-4 w-full overflow-hidden | md:flex justify-between links-blue links-underline text-xs">
                    @if ($series->lessons->first())
                        <a class="mb-2 md:w-1/2 md:pl-4 flex items-center md:justify-end ml-auto"
                           href="{{ $series->lessons->first()->url }}">
                            <span class="truncate"><span class="font-semibold md:hidden"></span>{{ $series->lessons->first()->title  }}</span>
                            <span class="w-1 fill-current text-blue ml-1 hidden | md:inline-block">
                                    {{ app_svg('icons/far-angle-right') }}
                                </span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
