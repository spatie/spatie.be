<nav class="sticky top-0 px-4 py-6 bg-white bg-opacity-50 shadow-light rounded-sm markup-lists">
    <h2 class="title-sm text-sm mb-4">
        {{ $series->title }}
    </h2>

    @if(!$series->isOwnedByCurrentUser() && $series->isPurchasable())
        <div class="my-8 py-4 pr-4 line-l line-l-green bg-green-lightest bg-opacity-50">
            These are videos from a <a href="{{ $series->purchaseLink() }}" class="link-green link-underline">paid
                course</a>.
            <div class="mt-2">
                <a href="{{ $series->purchaseLink() }}" class="grid">
                    <x-button>
                        Buy<span class="sm:hidden md:inline">&nbsp;entire course</span>
                    </x-button>
                </a>
            </div>

            @if($purchasable = $series->purchasableWithDiscount())
                <p class="mt-3 text-xs text-gray">
                    Now at <b>-{{ $purchasable->displayableDiscountPercentage() }}%</b>
                </p>
            @endif
        </div>
    @endif

    <ul class="text-xs grid gap-2 links-blue markup-list-compact">
        <li class="{{ request()->routeIs('series.show') ? "font-sans-bold" : "" }}">
            <a class="block" href="{{ route('series.show', [$series]) }}">
                <span class="mr-1">Introduction</span>
            </a>
        </li>
        @forelse ($series->lessons->groupBy('chapter') as $chapter => $lessonsPerChapter)
            @if ($chapter)
                <h3 class="title-subtext mt-6 mb-2">
                    @if($lessonsPerChapter[0]->canBeSeenByCurrentUser())
                        <a href="{{ $series->getUrlForChapter($chapter) }}">
                            @endif
                            {{ $chapter }}

                            @if($lessonsPerChapter[0]->canBeSeenByCurrentUser())

                        </a>
                    @endif
                </h3>
            @endif

            @if($lesson->chapter === $chapter)
                @if($lessonsPerChapter[0]->display === \App\Models\Enums\LessonDisplayEnum::LICENSE &&  $lessonsPerChapter[0]->canBeSeenByCurrentUser() )
                    @foreach($lessonsPerChapter as $lessonInChapter)
                        <li class="{{ isset($lesson) && $lesson->id === $lessonInChapter->id ? "font-sans-bold" : "" }}">
                            <a class="block" href="{{ route('courses.show', [$series, $lessonInChapter]) }}">
                                <span class="mr-1">{{ $lessonInChapter->title }}</span>


                                {{--
                                @if($lessonInChapter->hasBeenCompletedByCurrentUser())
                                    <span title="Completed" style="left: calc(-1.5em - 1.5rem); top: 0.075rem" class="absolute w-4 h-4 inline-flex items-center justify-center bg-green rounded-full">
                                        <span style="font-size: 0.75rem" class="text-white">
                                            ✓
                                        </span>
                                    </span>
                                @endif
                                --}}
                            </a>
                        </li>
                    @endforeach
                @endif
            @endif
        @empty
            <li>No lessons yet! Stay tuned...</li>
        @endforelse
    </ul>

    @if($series->title == 'Front Line PHP')
        <div class="my-8 py-4 pr-4 line-l line-l-green bg-green-lightest bg-opacity-50">
            Learn how to build modern applications using PHP
            <div class="mt-2">
                <a href="https://front-line-php.com" class="grid">
                    <x-button>
                        Visit Front Line PHP
                    </x-button>
                </a>
            </div>
        </div>
    @endif
</nav>
