<x-page
    title="Courses"
    description="Learn Laravel best practices from open source veterans SPATIE"
    body-class="bg-oss-black text-oss-gray font-medium font-pt antialiased mb-0"
    dark
>

    @include('layout.partials.gradient-background', [
        'color1' => '#21B989',
        'color2' => '#015389',
        'color3' => '#197593',
        'rotationZ' => '190',
        'positionX' => '0.8',
        'positionY' => '-0.5',
        'uDensity' => '1.8',
        'uFrequency' => '4.0',
        'uStrength' => '2.0',
    ])

    <section class="w-full max-w-[1080px] mx-auto mt-8 sm:mt-20 md:mt-32 mb-24 md:mb-52 px-7 lg:px-0">
        <h1 class="font-druk uppercase text-[72px] lg:text-[144px] leading-[0.8] font-bold mb-10">Watch<br>and learn</h1>
        <p class="text-[18px] sm:text-2xl font-medium max-w-[600px]">
            This is how we do it
        </p>
    </section>

    <div class="px-3 sm:px-16 md:px-10 lg:px-16 flex flex-col gap-y-16 sm:gap-y-20 pb-20">
        <section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0">
            <div class="grid gap-12 sm:grid-cols-2">
                @foreach($allSeries as $series)
                    <div>
                        <a href="{{ $series->url }}" class="group block">
                            @if($series->getFirstMedia('series-image'))
                                <div class="mb-6 rounded-[20px] overflow-hidden shadow-oss-card transition-transform transform ease-in-out group-hover:-translate-y-1 duration-200">
                                    {{ $series->getFirstMedia('series-image') }}
                                </div>
                            @endif
                            <h2 class="font-bold text-xl group-hover:underline">{{ $series->title }}</h2>
                            <div class="text-sm text-oss-gray-dark mt-1 flex items-center gap-1">
                                <span>
                                    @if ($series->type === \App\Domain\Shop\Enums\SeriesType::Video)
                                        {{ $series->lessons()->count() }}
                                        {{ \Illuminate\Support\Str::plural('video', $series->lessons()->count()) }}
                                    @elseif ($series->type === \App\Domain\Shop\Enums\SeriesType::VideoAndEbook)
                                        {{ $series->lessons()->count() }}
                                        {{ \Illuminate\Support\Str::plural('video', $series->lessons()->count()) }}
                                        + Ebook
                                    @else
                                        Course
                                    @endif
                                </span>

                                @if($series->isPurchasable())
                                    <span title="Part of course" class="w-4 h-4 inline-flex items-center justify-center bg-green-lightest rounded-full">
                                        <span style="font-size: .6rem; top: -.1rem" class="icon text-green">
                                            @if ($series->isOwnedByCurrentUser())
                                                {{ app_svg('icons/fas-lock-open-alt') }}
                                            @else
                                                {{ app_svg('icons/fas-lock-alt') }}
                                            @endif
                                        </span>
                                    </span>
                                @elseif($series->hasSponsoredContent())
                                    <span title="Series has extra content for sponsors" class="w-4 h-4 inline-flex items-center justify-center bg-pink-lightest rounded-full">
                                        <span style="font-size: .6rem" class="icon text-pink">
                                            {{ app_svg('icons/fas-heart') }}
                                        </span>
                                    </span>
                                @endif
                            </div>
                        </a>

                        <p class="my-4">
                            @if($series->isPurchasable())
                                @if (! $series->isOwnedByCurrentUser())
                                    <a href="{{ $series->purchaseLink() }}" class="inline-flex items-center gap-x-2 underline hover:text-white">
                                        <svg class="w-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
                                        Buy course
                                    </a>
                                    @if ($videoUrl = $series->sampleVideoUrl())
                                        <a class="ml-4 underline text-oss-gray-dark hover:text-white" href="{{ $videoUrl }}">Watch sample</a>
                                    @endif
                                @else
                                    <a href="{{ $series->url }}" class="inline-flex items-center gap-x-2 underline hover:text-white">
                                        <svg class="w-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
                                        Start course
                                    </a>
                                @endif
                            @else
                                <a class="inline-flex items-center gap-x-2 underline hover:text-white" href="{{ $series->url }}">
                                    <svg class="w-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
                                    @if($series->type === \App\Domain\Shop\Enums\SeriesType::Video)
                                        Watch {{ \Illuminate\Support\Str::plural('videos', $series->lessons()->count()) }}
                                    @elseif($series->type === \App\Domain\Shop\Enums\SeriesType::Html)
                                        Start course
                                    @endif
                                </a>
                            @endif
                        </p>

                        <p class="mt-4 text-oss-gray-dark">{{ $series->formattedDescription }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0">
            <h2 class="font-druk uppercase text-[40px] sm:text-[72px] leading-[0.9] mb-10">Exclusive content</h2>
            <div class="text-lg max-w-[640px]">
                <p>
                    From Laravel best practices to things that keep the team busy, these video series will give you a
                    great insight in how we work and how you can improve your web development skills.
                </p>
                <p class="mt-6">
                    Some of this content is sponsors-first: by becoming a Spatie <a class="underline hover:text-white" href="https://github.com/sponsors/spatie">sponsor on GitHub</a>, you'll get early access and
                    exclusive content from the team.
                </p>
            </div>
        </section>

    </div>

</x-page>
