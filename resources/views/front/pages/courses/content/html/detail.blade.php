<div class="pb-16 pt-8 md:pb-24 xl:pb-32">
    <section id="video">
        <div class="wrap wrap-6 mt-4 items-stretch">
            <div class="z-10 | sm:col-span-2 | print:hidden">
                @include('front.pages.courses.content.html.sidebar')
            </div>
            <div class="pt-8 | sm:col-start-3 sm:col-span-4 | md:pt-0">
                <h2 class="title line-after">{{ $htmlLesson->title }}</h2>
                <div
                    class="mt-8 bg-white p-12 xl:p-16 text-lg links-underline rounded-sm overflow-hidden links-blue markup markup-shiki markup-titles markup-lists markup-tables">
                    {!! $htmlLesson->html !!}
                </div>

                <hr class="mt-12 -ml-4 line-after "/>
                @if ($nextLesson)

                    <div
                        class="my-6 w-full overflow-hidden py-8 | md:flex gap-8 justify-between links-blue links-underline text-xs">


                        <div>
                            <span class="opacity-50">Up next</span>
                            <span class="-mt-1 block font-semibold text-lg">{{ $nextLesson->title }}</span>
                        </div>

                        @if($lesson->hasBeenCompletedByCurrentUser())
                            <div class="flex items-center">
                                <a class="cursor-pointer
                    bg-blue  bg-opacity-75 hover:bg-opacity-100 rounded-sm
                    border-2 border-transparent
                    justify-center flex items-center
                    px-6 min-h-10 text-white
                    font-sans-bold
                    transition-bg duration-300
                    focus:outline-none focus:border-blue-light no-underline whitespace-no-wrap"
                                   href="{{ $nextLesson->url }}">Continue</a>
                            </div>

                        @else
                            <form action="{{ route('courses.completeLesson', [$series, $lesson]) }}" method="POST">
                                @csrf


                                <span class="cursor-pointer
                    bg-blue bg-opacity-75 hover:bg-opacity-100 rounded-sm
                    border-2 border-transparent
                    justify-center flex items-center
                    px-6 min-h-10 text-white
                    font-sans-bold
                    transition-bg duration-300
                    focus:outline-none focus:border-blue-light no-underline whitespace-no-wrap">
                        <button type="submit" class="truncate"><span class="font-semibold md:hidden">Next: </span> Complete and
                            Continue</button>
                                <span class="w-1 fill-current text-white ml-1 hidden | md:inline-block">
                            {{ svg('icons/far-angle-right') }}
                        </span>
                            </span>
                            </form>
                        @endif
                    </div>
                @endif
                <hr class="my-8 -ml-4 line-after "/>

                @php
                    $noCommentsText = 'What are your thoughts on "' . $htmlLesson->title . "'"
                @endphp

                <livewire:comments
                    no-replies
                    :no-comments-text="$noCommentsText" :model="$htmlLesson->lesson"/>
            </div>
        </div>
    </section>
</div>
