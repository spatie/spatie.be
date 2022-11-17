<x-page
    ogImage="https://spatie.be/images/og-store.png"
    title="Applications and digital courses built for modern developers"
    background="/backgrounds/product.jpg"
    description="Welcome in our store, by artisans for artisans. Get access to our paid products, courses and ebooks"
>
    <div class="section section-group">
        <section class="section overflow-visible">
            <div class="wrap">
                <h2 class="title line-after mb-12">{{ $mainVideo['title'] }}</h2>
                <iframe style="aspect-ratio: 16 / 9" class="w-full"
                        src="https://www.youtube.com/embed/{{ $mainVideo['youtube_id'] }}" title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>

                <div class="my-6">
                    <a href="/products">
                        <button class="cursor-pointer
                            bg-yellow hover:bg-opacity-75 rounded-sm
                            border-2 border-transparent
                            justify-center flex items-center
                            px-6 min-h-10
                            font-sans-bold text-black
                            transition-bg duration-300
                            focus:outline-none focus:border-blue-light whitespace-no-wrap">
                            Take a look at all our products
                        </button>
                    </a>
                </div>

                <h2 class="title line-after mt-8 mb-12">Our other WWSD videos</h2>
                <div class="grid col-gap-24 row-gap-24 | sm:grid-cols-2 items-stretch">
                    @foreach($otherVideos as $otherVideo)
                        <div class="my-6">
                            <a href="{{ route('wwsd', $otherVideo['slug']) }}" class="group">
                                <div
                                    class="-mt-8 pb-6 transition-transform transform ease-in-out group-hover:-translate-y-2 duration-200">
                                    <div class="shadow-md group-hover:shadow-lg">
                                        <img class="w-full" src="{{ $otherVideo['thumbnail'] }}" alt="{{ $otherVideo['title'] }}">
                                    </div>
                                </div>

                                <h2 class="title-sm link-black link-underline-hover">{{ $otherVideo['title'] }}</h2>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</x-page>
