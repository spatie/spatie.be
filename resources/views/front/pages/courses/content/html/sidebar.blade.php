<nav class="relative top-0  bg-opacity-50  rounded-sm ">
    <div class="mb-4 rounded-sm overflow-hidden  ">
        <h2 class="title-sm text-sm px-4 py-6  gradient gradient-green text-white">
            {{ $series->title }}
            <span class="text-white lowercase block font-light">course info</span>
        </h2>
        <div class="flex justify-between px-4 py-6 bg-white text-sm leading-tight">
            <p class="text-blue-darkest">
                14 chapters
            </p>
            <p class="text-gray-light">
                14:54
            </p>
        </div>
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
        <li class="bg-white py-4 rounded-sm {{ request()->routeIs('series.show') ? " bg-paper " : "" }}">
            <a class="flex items-center gap-4" href="{{ route('series.show', [$series]) }}">
                <div class=" rounded-full flex justify-center items-center h-6 w-6 {{ request()->routeIs('series.show') ? "bg-white " : " bg-gray-lightest" }}">
                    @if (request()->routeIs('series.show'))
                    <div class="w-3 h-3 absolute bg-gray-lightest rounded-full "> </div>
                    @endif

                </div>
                <span class="mr-1 {{ request()->routeIs('series.show') ? "font-sans-bold  " : "" }}">Introduction</span>
            </a>
        </li>

        @forelse ($series->lessons->groupBy('chapter') as $chapter => $lessonsPerChapter)
            @if ($chapter)
                <h3 class="title-subtext text-blue-darkest block p-4 bg-gray-lightest  {{ $lessonsPerChapter[0]->canBeSeenByCurrentUser() ? '' : 'opacity-50' }}">
                    @if($lessonsPerChapter[0]->canBeSeenByCurrentUser())
                        <a class=" flex items-center text-blue-darkest justify-between" href="{{ $series->getUrlForChapter($chapter) }}">
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


            @if($lessonsPerChapter[0]->canBeSeenByCurrentUser() )
                @foreach($lessonsPerChapter as $lessonInChapter)
                    <li class="bg-white  py-4 rounded-sm flex items-center gap-4 {{ isset($lesson) && $lesson->id === $lessonInChapter->id ? "font-sans-bold bg-paper text-white" : "" }}">
                        <div class=" rounded-full flex justify-center items-center h-6 w-6 {{ isset($lesson) && $lesson->id === $lessonInChapter->id  ? "bg-white " : " bg-gray-lightest" }}">
                            @if (isset($lesson) && $lesson->id === $lessonInChapter->id ))
                            <div class="w-3 h-3 absolute bg-gray-lightest rounded-full "> </div>
                            @endif

                        </div>
                        <a class="block" href="{{ route('courses.show', [$series, $lessonInChapter]) }}">
                            <span class="mr-1">{{ $lessonInChapter->title }}</span>
                        </a>
                    </li>
                @endforeach
            @endif
        @empty
            <li>No lessons yet! Stay tuned...</li>
        @endforelse
    </ul>
</nav>
