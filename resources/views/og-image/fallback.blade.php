<?php $image = image('/backgrounds/home-new.jpg') ?>

<div class="flex h-full w-full flex-col p-16 font-pt text-white bg-oss-footer-dark">

    <div class="absolute right-0 top-0 h-full opacity-70">
        <img src="{{ $image->getUrl() }}" alt="">
    </div>

    <div class="h-[90px] w-auto self-start">
        @app_svg('logo')
    </div>

    <div class="flex flex-col pt-16 justify-between h-full text-balance text-oss-gray">
        <h1 class="font-druk uppercase font-bold text-[192px]/[0.8] mb-5">{!! $title !!}</h1>
    </div>

</div>
