<x-page
    ogImage="https://spatie.be/images/og-store.png"
    title="Applications and digital courses built for modern developers"
    background="/backgrounds/product.jpg"
    description="Welcome in our store, by artisans for artisans. Get access to our paid products, courses and ebooks"
>
    <div class="section section-group">
        <section class="section overflow-visible">
            <div class="wrap">


                {{ $mainVideo['title'] }}
                <div class="grid col-gap-24 row-gap-24 | sm:grid-cols-2 items-stretch">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $mainVideo['youtube_id'] }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>

                <div>
                    <a href="/products">Take a look at all our products</a>
                </div>

                <h2>Our other WWSD videos</h2>
                @foreach($otherVideos as $otherVideo)
                    <ul>
                        <li>
                            <a href="{{ route('wwsd', $otherVideo['slug']) }}">
                                <img src="{{ $otherVideo['thumbnail'] }}" alt="{{ $otherVideo['title'] }}">
                                {{ $otherVideo['title'] }}
                            </a>
                        </li>
                    </ul>
                @endforeach
            </div>
        </section>
    </div>
</x-page>
