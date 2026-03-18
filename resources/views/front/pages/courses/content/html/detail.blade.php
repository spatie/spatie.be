<div class="px-3 sm:px-16 md:px-10 lg:px-16 pb-20">
    <section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0 mt-8">
        <div class="grid md:grid-cols-[280px,1fr] gap-8 items-start">
            <div class="md:sticky md:top-4">
                @include('front.pages.courses.content.html.sidebar')
            </div>
            <div>
                <h2 class="font-druk uppercase text-[40px] leading-[0.9] mb-8 text-white">{{ $htmlLesson->title }}</h2>
                <div class="bg-oss-purple-extra-dark shadow-oss-card rounded-[20px] p-8 md:p-12 text-lg markup markup-code markup-titles markup-lists markup-tables text-oss-gray links-underline">
                    {!! $htmlLesson->html !!}
                </div>

                @if ($nextLesson)
                    <div class="mt-8 flex items-center justify-between py-6 border-t border-white/10">
                        <div>
                            <span class="text-oss-gray-dark text-sm">Up next</span>
                            <span class="block font-semibold text-lg text-white">{{ $nextLesson->title }}</span>
                        </div>

                        @if($lesson->hasBeenCompletedByCurrentUser())
                            <a class="inline-flex items-center gap-2 px-6 py-3 bg-oss-green-pale text-oss-royal-blue font-bold rounded-lg hover:opacity-90 transition-opacity"
                               href="{{ $nextLesson->url }}">
                                Continue
                                <svg class="w-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
                            </a>
                        @else
                            <form action="{{ route('courses.completeLesson', [$series, $lesson]) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-oss-green-pale text-oss-royal-blue font-bold rounded-lg hover:opacity-90 transition-opacity cursor-pointer">
                                    Complete and Continue
                                    <svg class="w-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
                                </button>
                            </form>
                        @endif
                    </div>
                @endif

                {{-- Comments temporarily disabled during redesign
                @php
                    $noCommentsText = 'What are your thoughts on "' . $htmlLesson->title . '"?'
                @endphp

                <livewire:comments
                        no-replies
                        :no-comments-text="$noCommentsText" :model="$htmlLesson->lesson"/>
                --}}
            </div>
        </div>
    </section>
</div>
