<div class="pb-16 md:pb-24 xl:pb-32">
    <section id="video">
        <div class="wrap wrap-6 items-stretch">
            <div class="z-10 | sm:col-span-2 | print:hidden">
                @include('front.pages.courses.partials.sidebar')
            </div>
            <div class="pt-8 | sm:col-start-3 sm:col-span-4 | md:pt-0">
                <h2 class="title line-after mt-12">{{ $htmlLesson->title }}</h2>

                <div class="mt-8 text-lg links-underline links-blue markup markup-titles markup-lists">
                    {!! $htmlLesson->html !!}
                </div>

                <hr class="mt-12 line-after"/>

                <div
                    class="mt-4 w-full overflow-hidden | md:flex justify-between links-blue links-underline text-xs">
                    @if ($previousLesson)
                        <a class="mb-2 md:w-1/2 md:pr-4 flex items-center" href="{{ $previousLesson->url }}">
                                <span class="w-1 fill-current text-blue mr-1 hidden | md:inline-block">
                                    {{ svg('icons/far-angle-left') }}
                                </span>
                            <span class="truncate"><span class="font-semibold md:hidden">Previous: </span>{{ $previousLesson->title }}</span>
                        </a>
                    @endif
                    @if ($nextLesson)
                        <a class="mb-2 md:w-1/2 md:pl-4 flex items-center md:justify-end ml-auto"
                           href="{{ $nextLesson->url }}">
                            <span class="truncate"><span class="font-semibold md:hidden">Next: </span>{{ $nextLesson->title  }}</span>
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
