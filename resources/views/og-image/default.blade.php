<div class="flex h-full w-full flex-col p-16 font-pt text-white bg-oss-gray">

    @isset ($image)
        <div class="absolute right-0 top-0 h-full opacity-75">
            <img src="{{ $image->getUrl() }}" alt="">
        </div>
    @endisset

    <div class="h-[90px] w-auto self-start">
        @app_svg('logo')
    </div>

    <div class="flex flex-col pt-12 justify-between h-full text-balance">
        <h1 class="font-druk uppercase text-blue font-bold text-[144px]/[0.8] mb-5">{{ $title }}</h1>
        <p class="mt-6 text-[42px]/tight font-semibold text-oss-royal-blue">{{ $url }}</p>
    </div>
</div>
