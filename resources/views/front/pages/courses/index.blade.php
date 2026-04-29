<x-page
    title="Courses"
    description="Learn Laravel best practices from open source veterans SPATIE"
    body-class="bg-oss-black text-oss-gray font-medium font-pt antialiased mb-0"
    dark
    footerCta
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

    <section class="w-full max-w-[1080px] mx-auto mt-8 sm:mt-20 md:mt-24 mb-24 md:mb-32 px-7 lg:px-0">
        <h1 class="font-druk uppercase text-[72px] lg:text-[144px] leading-[0.8] font-bold mb-10">Our courses</h1>
    </section>

    <div class="px-3 sm:px-16 md:px-10 lg:px-16 space-y-16 sm:space-y-32 pb-20">

        <section class="w-full max-w-[1320px] mx-auto">
            <div class="grid gap-8 sm:gap-20 sm:grid-cols-2">
                @foreach($allSeries as $series)
                    <a href="{{ $series->url }}" class="group flex flex-col border border-white/10 rounded-xl overflow-hidden transition-colors hover:border-white/20 hover:bg-white/[0.02]">
                        @if($series->getFirstMedia('series-image'))
                            <div class="overflow-hidden aspect-[16/10] [&_img]:object-cover [&_img]:size-full">
                                {{ $series->getFirstMedia('series-image') }}
                            </div>
                        @endif
                        <div class="p-9 flex flex-col grow">
                            <h2 class="text-4xl font-druk uppercase text-white leading-tight">{{ $series->title }}</h2>
                            <div class="mt-2 text-sm text-oss-gray-dark flex items-center gap-2 tabular-nums">
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
                                    <span title="Part of course" class="w-4 h-4 inline-flex items-center justify-center rounded-full" style="background: rgba(130,216,175,0.15);">
                                        <span class="w-2 fill-current text-oss-green-pale">
                                            @if ($series->isOwnedByCurrentUser())
                                                {{ app_svg('icons/fas-lock-open-alt') }}
                                            @else
                                                {{ app_svg('icons/fas-lock-alt') }}
                                            @endif
                                        </span>
                                    </span>
                                @elseif($series->hasSponsoredContent())
                                    <span title="Series has extra content for sponsors" class="w-4 h-4 inline-flex items-center justify-center rounded-full" style="background: rgba(130,216,175,0.15);">
                                        <span class="w-2 fill-current text-pink">
                                            {{ app_svg('icons/fas-heart') }}
                                        </span>
                                    </span>
                                @endif
                            </div>
                            @if($series->isPurchasable() && !$series->isOwnedByCurrentUser())
                                @if($purchasable = $series->purchasableWithDiscount())
                                    <p class="mt-2 text-oss-green text-sm font-medium tabular-nums">
                                        -{{ $purchasable->displayableDiscountPercentage() }}% off
                                    </p>
                                @endif
                            @endif
                            <div class="mt-4 text-lg text-oss-gray-dark">{{ $series->formattedDescription }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        <section class="w-full max-w-[1080px] mx-auto mt-8 sm:mt-20 md:mt-24 mb-24 md:mb-32 px-7 lg:px-0">
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
