<x-page
        title="Support us"
        background="/backgrounds/open-source.jpg"
        description="Learn how to support us via our paid products or via GitHub sponsors."
>
    @include('front.pages.open-source.components.menu')

    @include('front.pages.open-source.partials.banner-support')

    <div class="section section-group pt-0">
        <section id="resources" class="section">
            <div class="wrap mb-16 ">
                <div class="markup links-underline links-blue">
                    <p class="text-lg">
                        The easiest way to support us financially is by buying or subscribing to one of our paid <a
                                href="{{ route('products.index') }}">products</a>.
                        We tried to put as much love into these as in our open source work—and we hope it shows.
                    </p>
                    <p class="text-lg">
                        You can help with our open source efforts in many ways: by resolving <a
                                href='https://github.com/issues?q=is%3Aopen+is%3Aissue+user%3Aspatie+is%3Apublic+label%3A%22good+first+issue%22'
                                class="link-black">open issues</a> or just by sending us a <a
                                href="{{ route('open-source.postcards') }}">postcard</a>. An easy way to send us a
                        postcard is via <a href="https://spatie.cards">spatie.cards</a>.
                    </p>
                    <p class="text-lg"> You can also sponsor our open source work via <a
                                href="https://github.com/sponsors/spatie" target="_blank" rel="noreferrer noopener">GitHub
                            Sponsors</a> or
                        <a target="_blank" rel="noreferrer noopener" href="https://cottonbureau.com/people/spatie">buy a
                            T-shirt</a> from us.
                </div>
            </div>
            <div class="wrap">
                <div class="markup links-underline links-blue">
                    <div class="card gradient gradient-blue text-black">
                        <div class="wrap-card md:items-center">
                            <ul class="grid gap-4 links-blue links-underline bullets bullets-blue">
                                @foreach ($products as $product)
                                    <li>
                                        <span class="icon">{{ app_svg('icons/far-angle-right') }}</span>
                                        <a class="text-xl font-sans-bold" href="{{ route('products.show', $product) }}">
                                            {{ $product->title }}</a>
                                        <br><span class="text-base">{{ $product->formattedDescription }}</span>
                                    </li>
                                @endforeach
                                <li>
                                    <span class="icon">{{ app_svg('icons/far-angle-right') }}</span>
                                    <a class="text-xl font-sans-bold" target="_blank" rel="noreferrer noopener"
                                       href="https://cottonbureau.com/people/spatie">
                                        Spatie apparel</a>
                                    <br><span class="text-base">Buy Spatie T-shirts from cottonbureau.com</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


        </section>

        <section class="section">
            @include('front.pages.open-source.partials.donations')
        </section>
    </div>
</x-page>
