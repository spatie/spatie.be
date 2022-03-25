<div class="pb-16 md:pb-24 xl:pb-32">
    <section id="video">
        <div class="wrap wrap-6 items-stretch">
            <div class="z-10 | sm:col-span-2 | print:hidden">
                @include('front.pages.courses.content.html.sidebar')
            </div>
            <div class="pt-8 | md:pt-0 sm:col-start-3 sm:col-span-4">
                <h2 class="title-xl">{{ $series->title }}</h2>

                <div class="mt-8 text-lg links-underline links-blue markup markup-titles markup-lists">
                    <x-markdown >{!! $series->introduction ?? $series->description !!}</x-markdown>
                </div>

                <hr class="-ml-4 mt-12 line-after" />
                <div class="w-full overflow-hidden | md:flex justify-between links-blue links-underline text-xs">
                    @if ($series->lessons->first())
                    
                    <div
                        class="my-6 w-full overflow-hidden  py-8 | md:flex justify-between links-blue links-underline text-xs">
                        
                        <h1 class="">
                            Up next
                            <span class="block title max-w-sm">{{ $series->lessons->first()->title }}</span>
                        </h1>

                        <a class="cursor-pointer
                        bg-blue bg-opacity-75 hover:bg-opacity-100 rounded-sm
                        border-2 border-transparent
                        justify-center flex items-center
                        px-6 min-h-10 text-white
                        font-sans-bold 
                        transition-bg duration-300
                        focus:outline-none focus:border-blue-light no-underline whitespace-no-wrap"
                            href="{{ $series->lessons->first()->url }}">
                            <span class="truncate"><span class="font-semibold md:hidden">Next: </span> Complete and
                                Continue</span>
                            <span class="w-1 fill-current text-white ml-1 hidden | md:inline-block">
                                {{ svg('icons/far-angle-right') }}
                            </span>
                        </a>


                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>