<x-page
    title="From our team and products"
    background="/backgrounds/blog-index.png"
    body-class="bg-oss-gray"
    main-class="font-pt text-oss-royal-blue font-medium text-18 leading-140 antialiased"
>
    <div class="wrapper-lg mt-8 grid gap-8">
        <h1 class="text-2xl/tight sm:text-4xl/tight font-bold">
            From our team & products
        </h1>
        <div class="grid gap-8 pb-16">
            @foreach($externalFeedItems as $externalFeedItem)
                @include('front.pages.blog.partials.externalFeedItem')
            @endforeach
            {{ $externalFeedItems->links() }}
        </div>
    </div>
</x-page>
