<section
    id="postcards"
    class="border-t border-oss-gray-extra-dark pt-20 mb-20 max-w-[1320px] w-full mx-auto px-3 sm:px-0"
    x-data="{}"
    x-init="() => {
        var elem = $refs.masonry;

        var msnry = new Masonry( elem, {
          // options
          itemSelector: '.grid-item',
          gutter: 16,
        });
    }"
>
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end mb-20 w-full">
        <h2 class="font-druk uppercase font-bold text-[50px] md:text-[96px] leading-[0.9]">All<br/>postcards</h2>
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-12">
            @foreach($countries as $country)
                <li class="flex items-center gap-3 sm:gap-6">
                    <span class="font-druk uppercase text-oss-blue text-[48px]">{{ $country['postcard_count'] }}</span>
                    <span class="uppercase text-[14px] tracking-wide">{{ $country['name'] }}</span>
                </li>
            @endforeach
        </div>
    </div>
    <div x-ref="masonry" class="masonry gap-4">
        @foreach($postcards as $postcard)
            @include('front.pages.open-source.partials.postcard')
        @endforeach
    </div>
</section>
