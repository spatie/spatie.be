<div class="pb-16 pt-8 md:pb-24 xl:pb-32">
    <section id="video">
        <div class="wrap wrap-courses wrap-6 items-stretch print:block">
            <div class="z-10 | sm:col-span-2 | print:hidden">
                @include('front.pages.courses.content.html.sidebar')
            </div>
            <div class="pt-8 | md:pt-0 sm:col-start-3 sm:col-span-4">
                <div class="bg-white p-12 xl:p-16 text-lg links-underline links-blue markup markup-titles markup-lists">
                    <h1 class="mb-16">{{ $series->title }}</h1>
                    <x-markdown>{!! $series->introduction ?? $series->description !!}</x-markdown>
                </div>

                <hr class="-ml-4 mt-12 line-after"/>
                <div class="w-full overflow-hidden | md:flex justify-between links-blue links-underline text-xs">
                    @if ($series->lessons->first())

                        @if($series->isOwnedByCurrentUser())
                            <div
                                    class="my-6 w-full overflow-hidden  py-8 | md:flex gap-8 justify-between links-blue links-underline text-xs">

                                <div>
                                    <span class="opacity-50">Up next</span>
                                    <span class="-mt-1 block font-semibold text-lg">{{ $series->lessons->first()->title }}</span>
                                </div>

                                <a class="cursor-pointer
                        bg-blue hover:bg-blue-dark rounded-sm
                        border-2 border-transparent
                        justify-center flex items-center
                        px-6 min-h-10 text-white
                        font-sans-bold
                        transition-colors duration-300
                        focus:outline-none focus:border-blue-light no-underline whitespace-no-wrap"
                                   href="{{ $series->lessons->first()->url }}">
                            <span class="truncate"><span class="font-semibold md:hidden">Next: </span>
                                Continue</span>
                                    <span class="w-1 fill-current text-white ml-1 hidden | md:inline-block">
                                {{ app_svg('icons/far-angle-right') }}
                            </span>
                                </a>

                            </div>
                        @endif
                    @endif
                    <hr class="my-8 -ml-4 line-after "/>
                </div>
            </div>
        </div>
    </section>
</div>
