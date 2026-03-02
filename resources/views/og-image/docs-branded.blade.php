<div class="flex h-full w-full flex-col p-16 font-pt text-white bg-oss-gray">

    <div class="absolute right-0 top-0 h-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-full" fill="none" viewBox="0 0 681 630"><g filter="url(#a)" opacity=".5"><circle cx="680.5" cy=".5" r="360.5" fill="{{ $color ?? "#5597a7" }}"/></g><defs><filter id="a" width="1361" height="1361" x="0" y="-680" color-interpolation-filters="sRGB" filterUnits="userSpaceOnUse"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feBlend in="SourceGraphic" in2="BackgroundImageFix" result="shape"/><feGaussianBlur result="effect1_foregroundBlur_2_8" stdDeviation="160"/></filter></defs></svg>
    </div>

    <div class="h-[90px] w-auto self-start">
        @app_svg('logo')
    </div>

    <div class="flex flex-col pt-12 justify-between h-full text-balance text-oss-royal-blue">
        <h1 class="font-druk uppercase font-bold text-[144px]/[0.8] mb-5">
            <span class="inline-flex w-[112px] h-[112px] [&>svg]:inline [&>svg]:h-[inherit] [&>svg]:w-[inherit]">{!! $icon !!}</span>
            {{ $title }}
        </h1>
        <p class="mt-6 text-[42px]/tight font-semibold opacity-70">spatie.be/open-source</p>
    </div>

</div>
