<aside class="z-20 fixed flex bottom-0 w-full">
    <div class="mx-auto">
        <div class="bg-purple text-white flex flex-col items-end sm:flex-row sm:items-center justify-center rounded-t p-2 pr-6 shadow-light text-xs sm:text-sm">
            <div class="flex items-center">
                <div class="mr-2 text-lg icon bg-black bg-opacity-25 text-white rounded-full w-8 flex items-center justify-center h-8">
                    {{ app_svg('icons/far-graduation-cap') }}
                </div>
                <div>
                    <div>
                        Check out our course on Laravel development for large apps:
                        <span class="font-semibold">Laravel beyond CRUD</span>
                    </div>
                </div>
            </div>
            <a href="https://laravel-beyond-crud.com">
                <button class="mt-2 md:mt-0 ml-4 px-2 py-1 rounded text-purple bg-white uppercase tracking-wide font-semibold">
                    Learn&nbsp;more
                </button>
            </a>
            @include('front.pages.docs.banners.hideButton')
        </div>
    </div>
</aside>
