<nav class="bg-oss-purple-extra-dark shadow-oss-card rounded-[20px] p-4 text-sm">
    @if(!$series->isOwnedByCurrentUser() && $series->isPurchasable())
        <div class="mb-4 p-4 rounded-lg" style="background: rgba(130,216,175,0.15);">
            <p class="text-oss-green-pale text-sm">
                This is content from a <a href="{{ $series->purchaseLink() }}" class="underline font-bold">paid course</a>.
            </p>
            <a href="{{ $series->purchaseLink() }}" class="mt-2 inline-flex items-center gap-2 px-4 py-2 bg-oss-green-pale text-oss-royal-blue font-bold rounded-lg hover:opacity-90 transition-opacity text-sm">
                Buy course
            </a>
            @if($purchasable = $series->purchasableWithDiscount())
                <p class="mt-2 text-xs text-oss-gray-dark">
                    Now at <b>-{{ $purchasable->displayableDiscountPercentage() }}%</b>
                </p>
            @endif
        </div>
    @endif

    <ul class="space-y-0.5">
        <li>
            <a class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('series.show') ? 'bg-white/10 text-white font-bold' : 'text-oss-gray hover:bg-white/[0.05] hover:text-white' }}"
               href="{{ route('series.show', [$series]) }}">
                Introduction
            </a>
        </li>

        @forelse ($series->lessons->groupBy('chapter') as $chapter => $lessonsPerChapter)
            <div x-data="{open: @json(isset($lesson) && $chapter === $lesson->chapter)}">
                @if ($chapter)
                    <h3 @click="open = !open;"
                        class="cursor-pointer flex items-center justify-between px-3 py-2 rounded-lg text-xs font-bold uppercase tracking-wide mt-2
                        {{ $lessonsPerChapter[0]->canBeSeenByCurrentUser() ? 'text-oss-gray hover:bg-white/[0.05]' : 'text-oss-gray-dark' }}">
                        <span class="flex items-center gap-2">
                            @if(!$lessonsPerChapter[0]->canBeSeenByCurrentUser())
                                <span class="w-3 fill-current">{{ app_svg('icons/fas-lock-alt') }}</span>
                            @endif
                            {{ $loop->index + 1 }}. {{ $chapter }}
                        </span>
                        <span class="w-3 fill-current transition-transform" :class="open ? 'rotate-180' : ''">{{ app_svg('icons/far-angle-down') }}</span>
                    </h3>
                @endif

                <div x-show="open" x-collapse>
                    @if($lessonsPerChapter[0]->canBeSeenByCurrentUser())
                        @foreach($lessonsPerChapter as $lessonInChapter)
                            <li>
                                <a class="group flex items-center gap-2 px-3 py-2 rounded-lg transition-colors text-sm
                                    {{ (!request()->routeIs('series.show')) && isset($lesson) && $lesson->id === $lessonInChapter->id ? 'bg-white/10 text-white font-bold' : 'text-oss-gray hover:bg-white/[0.05] hover:text-white' }}"
                                   href="{{ route('courses.show', [$series, $lessonInChapter]) }}">
                                    <span>{{ $lessonInChapter->title }}</span>
                                    @if($lessonInChapter->display_video_icon)
                                        <span class="w-3 fill-current opacity-50 group-hover:opacity-100">{{ app_svg('icons/fas-video') }}</span>
                                    @endif
                                    @if ($lessonInChapter->hasBeenCompletedByCurrentUser())
                                        <x-completion-badge class="ml-auto"/>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    @endif
                </div>
            </div>
        @empty
            <li class="px-3 py-2 text-oss-gray-dark">No lessons yet! Stay tuned...</li>
        @endforelse
    </ul>
</nav>
