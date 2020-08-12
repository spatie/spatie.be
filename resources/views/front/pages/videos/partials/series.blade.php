<section id="series" class="section">
    <div class="wrap grid sm:grid-cols-2 col-gap-6 row-gap-8 | items-start markup-lists">
        @foreach($allSeries as $series)
            <div>
                @if(true OR $series->purchasables->count())
                    <div class="line-l line-l-green p-4 bg-green-lightest bg-opacity-50">
                        <h2 class="title-sm">
                            <a class="link-black link-underline" href="{{ $series->url }}">{{ $series->title }}</a>
                            <div class="title-subtext text-gray flex items-center">
                                <span>
                                {{ $series->videos()->count() }}
                                {{  \Illuminate\Support\Str::plural('video', $series->videos()->count()) }}
                                </span>

                                <span title="Part of course" class="ml-1 w-4 h-4 inline-flex items-center justify-center bg-green-lightest rounded-full">
                                    <span style="font-size: .6rem; top: -.1rem" class="icon text-green">
                                        {{-- If not bought --}}
                                        {{ svg('icons/fas-lock-alt') }}
                                        {{-- Else  
                                         svg('icons/fas-lock-open-alt') --}}
                                         {{-- Endif  --}}
                                    </span>
                                </span>

                               
                            </div>
                        </h2>
                        <p class="mt-4">
                            {{ $series->description }}
                        </p>

                        {{-- If not bought --}}
                        <p class="mt-4 links-underline link-blue">
                            <a href="{{ $series->url }}">Watch {{  \Illuminate\Support\Str::plural('sample', $series->videos()->count()) }}</a>
                            <span class="text-blue-light">|</span>
                            <a href="">About this course</a>
                        </p>
                        <p class="mt-4">
                            <a>
                            <x-button>
                                Buy course
                            </x-button>
                            </a>
                        </p>
                        @if (true OR sponsorIsViewingPage())
                            @include('front.pages.videos.partials.sponsorDiscount')
                        @endif

                        {{-- Else  
                            <p class="mt-4 links-underline link-blue">
                                <a href="">About this course</a>
                            </p>
                            <p class="mt-4">
                                <a>
                                <x-button>
                                    Start course
                                </x-button>
                                </a>
                            </p>
                        --}}

                        {{-- Endif  --}}

                    </div>
                @else
                    <div class="py-4">
                        <div class="line-l">
                            <h2 class="title-sm">
                                <a class="link-black link-underline" href="{{ $series->url }}">{{ $series->title }}</a>
                                <div class="title-subtext text-gray flex items-center">
                                    <span>
                                    {{ $series->videos()->count() }}
                                    {{  \Illuminate\Support\Str::plural('video', $series->videos()->count()) }}
                                    </span>

                                    @if($series->videos->where('display', \App\Models\Enums\VideoDisplayEnum::SPONSORS)->count())
                                        <span title="Series has extra content for sponsors" class="ml-1 w-4 h-4 inline-flex items-center justify-center bg-pink-lightest rounded-full">
                                            <span style="font-size: .6rem" class="icon text-pink">
                                                {{ svg('icons/fas-heart') }}
                                            </span>
                                        </span>
                                    @endif
                                </div>
                            </h2>
                            <p class="mt-4">
                                {{ $series->description }}
                            </p>
                            <p class="mt-4">
                                <a class="link-underline link-blue" href="{{ $series->url }}">Watch {{  \Illuminate\Support\Str::plural('videos', $series->videos()->count()) }}</a>
                            </p>
                        </div>
                    </div>
                @endif

            </div>
        @endforeach
    </div>
</section>
