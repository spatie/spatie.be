<section id="series" class="section">
    <div class="wrap">
        <h2 class="title line-after mb-12">Available series</h2>
    </div>
    <div class="wrap-6 | items-start markup-lists">
        @foreach($allSeries as $series)
            <div class="sm:spanx-3">
                {{--
                <a href="{{ $series->url }}" class="illustration">
                    {{ image("/video-series/{$series->slug}.jpg") }}
                </a>
                --}}

                <div class="mt-8 line-l">
                    <h2 class="title-sm">
                        <a href="{{ $series->url }}">{{ $series->title }}</a>
                        <div class="title-subtext text-grey">
                            {{ $series->videos()->count() }}
                            {{  \Illuminate\Support\Str::plural('video', $series->videos()->count()) }}

                            @if($series->purchasables->count())
                                <span class="ml-1 bg-green-lightest text-green text-xs font-normal py-1 px-2 rounded-full">Part of a course</span>
                            @endif
                            @if($series->videos->where('display', \App\Models\Enums\VideoDisplayEnum::SPONSORS)->count())
                                <span class="ml-1 bg-pink-lightest text-pink text-xs font-normal py-1 px-2 rounded-full">Sponsor content</span>
                            @endif
                        </div>
                    </h2>
                    <p class="mt-4">
                        {{ $series->description }}
                    </p>
                    <p class="mt-4">
                        <a class="link-underline link-blue" href="{{ $series->url }}">Watch {{  \Illuminate\Support\Str::plural('video', $series->videos()->count()) }}</a>
                    </p>
                    @if($series->slug === 'building-mailcoach')
                        <p class="">
                            <a class="link-underline link-blue" href="https://mailcoach.app/videos">
                                Buy the entire course at <strong>mailcoach.app/videos</strong>
                            </a>
                        </p>

                        @if (sponsorIsViewingPage())
                            <p class="mt-2 text-xs text-grey">
                                As a sponsor, you can get 15$ off with following coupon:
                                <span class="mt-2 font-mono opacity-75">{{ config('services.promo_codes.package_training') }}</span>
                            </p>
                        @endif
                    @endif

                    @if($series->slug === 'laravel-package-training')
                        <p class="">
                            <a class="link-underline link-blue" href="https://laravelpackage.training">
                                Buy the entire course at <strong>laravelpackage.training</strong>
                            </a>
                        </p>

                        @if (sponsorIsViewingPage())
                            <p class="mt-2 text-xs text-grey">
                                As a sponsor, you can get 15$ off with following coupon:
                                <span class="mt-2 font-mono opacity-75">{{ config('services.promo_codes.package_training') }}</span>
                            </p>
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</section>
