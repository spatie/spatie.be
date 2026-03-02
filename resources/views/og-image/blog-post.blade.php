<?php $image = image('/backgrounds/blog-post.jpg') ?>

<div class="flex h-full w-full flex-col p-16 font-pt text-white bg-oss-gray">

    <div class="absolute right-0 top-0 h-full">
        <img src="{{ $image->getUrl() }}" alt="">
    </div>

    <div class="h-[90px] w-auto self-start">
        @app_svg('logo')
    </div>

    <div class="flex flex-col pt-12 justify-between h-full text-balance text-oss-royal-blue">
        <h1 class="font-druk uppercase text-[120px]/[0.8] font-bold mt-6 text-balance">{{ $title }}</h1>
        <p class="mt-6 text-[42px]/tight font-semibold text-oss-royal-blue">spatie.be/blog</p>
    </div>

</div>
