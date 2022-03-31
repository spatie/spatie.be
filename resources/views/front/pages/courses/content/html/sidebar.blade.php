<nav class="relative top-0  bg-opacity-50  rounded-sm ">
    <div class="mb-4 rounded-sm overflow-hidden  ">
        <h2 class="title-sm text-sm px-4 py-6  gradient gradient-green text-white">
            {{ $series->title }}
        </h2>

    </div>

    <div>
        @if (! $series->isOwnedByCurrentUser())
            <a href="{{ $series->purchaseLink() }}">
                <x-button>
                    Buy entire course
                </x-button>
            </a>
        @endif
    </div>


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

    <ul class="text-xs grid bg-white p-2 rounded-sm shadow links-blue markup-list-compact">
        <li class="bg-white py-2 rounded-sm {{ request()->routeIs('series.show') ? " bg-paper " : "" }}">
            <a class="flex items-center gap-4" href="{{ route('series.show', [$series]) }}">
                    @if (request()->routeIs('series.show'))
                        <div class="w-1 h-1 absolute bg-gray-light rounded-full "></div>
                    @endif
                <span class="mr-1 text-black {{ request()->routeIs('series.show') ? "
                    font-sans-bold " : "" }}">Introduction</span>
            </a>
        </li>


        @forelse ($series->lessons->groupBy('chapter') as $chapter => $lessonsPerChapter)
            <div x-data="{open: @json(isset($lesson) && $chapter === $lesson->chapter)}">
                @if ($chapter)
                    <h3 @click="open = !open;"
                        class="title-subtext cursor-pointer text-blue-darkest block rounded-sm p-4 bg-gray-lightest  {{ $lessonsPerChapter[0]->canBeSeenByCurrentUser() ? '' : 'opacity-50' }}">
                        @if($lessonsPerChapter[0]->canBeSeenByCurrentUser())
                            <a class=" flex items-center text-blue-darkest justify-between">
                                @endif

                                @if(!$lessonsPerChapter[0]->canBeSeenByCurrentUser())
                                    <div class="w-2 inline-block mr-2">{{ svg('icons/fas-lock-alt') }}</div>
                                @endif
                                {{ $loop->index +1 . '. ' . $chapter }}




                                @if($lessonsPerChapter[0]->canBeSeenByCurrentUser())
                                    <div class="w-3">{{ svg('icons/far-angle-down') }}</div>
                            </a>
                        @endif
                    </h3>
                @endif

                <div x-show='open'>
                    @if($lessonsPerChapter[0]->canBeSeenByCurrentUser() )
                        @foreach($lessonsPerChapter as $lessonInChapter)
                            <li class="bg-white  py-2 rounded-sm flex items-center gap-2 {{ isset($lesson) && $lesson->id === $lessonInChapter->id ? "
                    font-sans-bold bg-paper text-white" : "" }}">
                                    @if (isset($lesson) && $lesson->id === $lessonInChapter->id ))
                                    <div class="w-1 h-1 absolute bg-gray-light rounded-full "></div>
                                    @endif
                                    
                                <a class="flex items-center gap-2" href="{{ route('courses.show', [$series, $lessonInChapter]) }}">
                                    <span class="mr-1">{{ $lessonInChapter->title }}</span>
                                    @if ($lessonInChapter->hasBeenCompletedByCurrentUser())
                                        <div
                                            class="w-3 h-3  bg-green rounded-full text-xs flex items-center text-white justify-items-center font-bold">
                                            <p class="w-full inline-block text-center">✓</p>
                                        </div>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    @endif
                </div>
            </div>



        @empty
            <li>No lessons yet! Stay tuned...</li>
        @endforelse
    </ul>
</nav>
