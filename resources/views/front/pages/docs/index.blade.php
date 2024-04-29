<x-page title="Documentation" body-class="bg-oss-gray font-pt antialiased font-medium leading-[1.4]">
    @push('head')
        @vite(['resources/js/front/gradient.jsx'])
    @endpush
    @push('startBody')
        <div
            x-show="show"
            x-data="{ show: false }"
            x-init="setTimeout(() => show = true, 50)"
            x-transition.opacity.duration.1000ms
            x-cloak
            class="absolute top-0 left-0 right-0 z-0 pointer-events-none"
        >
            <div id="gradient" class="aspect-[9/16] sm:aspect-[1440/700] w-full" data-url="https://www.shadergradient.co/customize?animate=on&axesHelper=off&bgColor1=%23000000&bgColor2=%23000000&brightness=1.8&cAzimuthAngle=180&cDistance=2&cPolarAngle=80&cameraZoom=9.1&color1=%23197593&color2=%23328c7d&color3=%23EAE8E5&destination=onCanvas&embedMode=off&envPreset=city&format=gif&fov=20&frameRate=10&gizmoHelper=hide&grain=off&lightType=3d&pixelDensity=1&positionX=1&positionY=-0.8&positionZ=0&range=enabled&rangeEnd=40&rangeStart=0&reflection=0.1&rotationX=50&rotationY=0&rotationZ=-60&shader=defaults&type=waterPlane&uAmplitude=0&uDensity=2&uFrequency=0&uSpeed=0.05&uStrength=0.6&uTime=8&wireframe=false"></div>
            <div class="absolute inset-0 z-10 w-full h-full aspect-[9/16] sm:aspect-[1440/700] bg-gradient-to-b from-transparent to-oss-gray"></div>
        </div>
    @endpush

    <section class="w-full max-w-[1080px] mx-auto mt-20">
        <div class="flex w-full justify-between items-end text-white">
            <h1 class="font-druk uppercase text-[72px] lg:text-[144px] leading-[0.8] font-bold mb-4">Docs</h1>
            <p class="text-[28px] leading-tight text-right">Find extensive documentation for<br>many of our packages here.</p>
        </div>
        <div x-data x-on:click="$dispatch('open-spotlight')" class="w-full relative mt-16">
            <input class="w-full bg-white rounded-[12px] h-16 px-7" type="search" placeholder="Find a package ...">
            <svg class="w-6 h-6 right-0 top-0 mt-5 mr-5 absolute" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="#3A3C3E" stroke-width="2" d="m19 19-4-4m-4 2a6 6 0 1 1 0-12 6 6 0 0 1 0 12Z"/></svg>
        </div>
        <p class="mt-4 inline-block text-xs text-oss-gray-darker">
            Pro tip: Use <kbd class="text-monospace text-xs font-bold">CMD/CTRL+K</kbd> to navigate quickly.
        </p>
    </section>

    <section class="my-32 w-full max-w-[1320px] mx-auto">
        @foreach($repositories->groupBy('category') as $category => $repositories)
            <div class="border-t border-oss-gray-dark pt-20 mt-20">
                <h2 class="font-druk uppercase text-oss-royal-blue text-[96px] mb-16">{{ $category }}</h2>
                <div class="grid gap-10 | sm:grid-cols-3 items-stretch">
                    @each('front.pages.docs.partials.repository', $repositories, 'repository')
                </div>
            </div>
        @endforeach
    </section>

    @livewire('spotlight')
</x-page>
