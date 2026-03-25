<section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0 -mt-12 sm:-mt-16 pb-24">
    <div class="px-6 py-6 lg:px-16 lg:py-12 grid md:grid-cols-[2fr,3fr] gap-8">
        <div class="w-full flex flex-col md:justify-between h-full">
            <header class="text-white">
                <x-headers.h2 class="text-balance">
                    Insights
                </x-headers.h2>
            </header>
        </div>
        <div class="space-y-8 mt-2">
            @foreach($newsItems as $newsItem)
                @include('front.pages.home.partials.newsItem', ['newsItem' => $newsItem])
            @endforeach
        </div>
    </div>
</section>
