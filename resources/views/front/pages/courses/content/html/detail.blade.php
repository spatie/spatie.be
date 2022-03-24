<div class="pb-16 md:pb-24 xl:pb-32">
    <section id="video">
        <div class="wrap wrap-6 items-stretch">
            <div class="z-10 | sm:col-span-2 | print:hidden">
                @include('front.pages.courses.content.html.sidebar')
            </div>
            <div class="pt-8 | sm:col-start-3 sm:col-span-4 | md:pt-0">
                <h2 class="title line-after">{{ $htmlLesson->title }}</h2>
                @ray($htmlLesson)
                <div class="mt-8 text-lg links-underline links-blue markup markup-titles markup-lists">
                    {!! $htmlLesson->html !!}
                </div>


                {{-- <hr class="mt-12 line-after" /> --}}
                

                <div
                    class="my-8 w-full overflow-hidden bg-blue-dark rounded-sm px-4 py-8 | md:flex justify-between links-white links-underline text-xs">
                    {{--@if ($previousLesson)
                    <a class="mb-2 md:w-1/2 md:pr-4 flex items-center" href="{{ $previousLesson->url }}">
                        <span class="w-1 fill-current text-white mr-1 hidden | md:inline-block">
                            {{ svg('icons/far-angle-left') }}
                        </span>
                        <span class="truncate"><span class="font-semibold md:hidden">Previous: </span>{{
                            $previousLesson->title }}</span>
                    </a>
                    @endif--}}
                    @if ($nextLesson)
                    <h1 class="text-white">
                        Next lesson
                        <span class="block title">{{ $nextLesson->title }}</span>
                    </h1>

                    <a class="cursor-pointer
                    bg-paper bg-opacity-75 hover:bg-opacity-100 rounded-sm
                    border-2 border-transparent
                    justify-center flex items-center
                    px-6 min-h-10
                    font-sans-bold text-white
                    transition-bg duration-300
                    focus:outline-none focus:border-blue-light no-underline whitespace-no-wrap" href="{{ $nextLesson->url }}">
                        <span class="truncate"><span class="font-semibold md:hidden">Next: </span> Complete and
                            Continue</span>
                        <span class="w-1 fill-current text-white ml-1 hidden | md:inline-block">
                            {{ svg('icons/far-angle-right') }}
                        </span>
                    </a>

                    @else
                    @auth
                    <livewire:lesson-completed-button :lesson="$htmlLesson->lesson" />
                    @endauth
                    @endif

                </div>

                <livewire:comments :model="$htmlLesson->lesson" />
            </div>
        </div>
    </section>
</div>