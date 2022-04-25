<aside class="z-20 fixed flex bottom-0 w-full">
    <div class="mx-auto">
        <div style="background-color: rgba(246,202,96)" class="flex flex-col items-end sm:flex-row sm:items-center justify-center rounded-t p-2 pr-6 shadow-light text-xs sm:text-sm">
            <div class="flex items-center">
                <div class="mr-2 text-lg icon bg-white bg-opacity-25 text-black rounded-full w-8 flex items-center justify-center h-8">
                    {{ svg('icons/far-graduation-cap') }}
                </div>
                <div>
                    <div>
                        Learn everything about maintainable code in our online course
                        <span class="font-semibold">Writing Readable PHP</span>
                    </div>
                </div>
            </div>
            <a href="https://writing-readable-php.com">
                <button class="mt-2 md:mt-0 ml-4 px-2 py-1 rounded text-black bg-white uppercase tracking-wide font-semibold">
                    Learn&nbsp;more
                </button>
            </a>
            @include('front.pages.docs.banners.hideButton')
        </div>
    </div>
</aside>
