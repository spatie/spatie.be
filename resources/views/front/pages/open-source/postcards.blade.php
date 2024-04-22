<x-page
    title="Postcards"
    description="This is our postcardware license in action."
    body-class="bg-oss-black text-oss-gray font-medium font-pt antialiased"
    dark
>
    @push('head')
        @vite(['resources/js/front/gradient.jsx'])
        <style>html { scroll-behavior: smooth; background: #050508; }</style>
        <script defer src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
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
            <div id="gradient" class="aspect-[9/16] sm:aspect-video w-full"
                 data-url="https://www.shadergradient.co/customize?animate=on&axesHelper=on&bgColor1=%23000000&bgColor2=%23000000&brightness=1.1&cAzimuthAngle=180&cDistance=3.9&cPolarAngle=115&cameraZoom=1&color1=%234c00ed&color2=%234f7f76&color3=%23000000&destination=onCanvas&embedMode=off&envPreset=city&format=gif&fov=45&frameRate=10&grain=off&lightType=3d&pixelDensity=1.5&positionX=-0.5&positionY=0.1&positionZ=0&range=disabled&rangeEnd=40&rangeStart=0&reflection=0.5&rotationX=0&rotationY=0&rotationZ=235&shader=defaults&toggleAxis=false&type=waterPlane&uAmplitude=0&uDensity=1&uFrequency=5.5&uSpeed=0.05&uStrength=2.3&uTime=0.2&wireframe=false"></div>
            <div
                class="absolute inset-0 z-10 w-full h-full aspect-video bg-gradient-to-b from-transparent to-oss-black"></div>
        </div>
    @endpush

    <div class="px-3 sm:px-16 md:px-10 lg:px-16 flex flex-col gap-y-16 sm:gap-y-20">
        <x-oss-menu title="Postcards">
            <x-slot:subtitle>
                <span>All of our packages are postcardware: free to use if you send us a postcard. We enjoy receiving mail from all around the world!</span>
                <a class="mt-10 flex items-center gap-x-6" href="#postcards">
                    <svg class="w-12 h-12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 48 48"><rect width="46" height="46" x="1" y="1" stroke="#A5A4A3" stroke-width="2" rx="23"/><path fill="#EAE8E5" d="m24 29.416.706-.707 6-6 .71-.709L30 20.584l-.707.707L24 26.584l-5.294-5.29-.706-.71L16.584 22l.706.706 6 6 .71.71Z"/></svg>
                    All postcards ({{ \App\Models\Postcard::count() }})
                </a>
            </x-slot:subtitle>
        </x-oss-menu>

        <section class="w-full px-7 lg:px-0">
            <x-oss-staggered-title offset="md:-ml-[11rem]">
                <x-slot:icon>
                    <svg class="w-8 h-8 sm:w-12 sm:h-12 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 48 48"><g fill="#3CF" clip-path="url(#clip0_541_3429)"><path d="M24 48a24 24 0 1 0 0-48 24 24 0 0 0 0 48ZM12 18c0-1.66 1.34-3 3-3h18c1.66 0 3 1.34 3 3v.872l-11.184 5.09a2.026 2.026 0 0 1-.816.179 1.91 1.91 0 0 1-.816-.178L12 18.871V18Zm14.053 8.69L36 22.173V30c0 1.66-1.34 3-3 3H15c-1.66 0-3-1.34-3-3v-7.828l9.947 4.528c.647.29 1.34.45 2.053.45.712 0 1.406-.15 2.053-.45v-.01Z" opacity=".4"/><path d="M15 15c-1.66 0-3 1.34-3 3v.872l11.184 5.09c.253.113.535.179.816.179.281 0 .553-.057.816-.178L36 18.871V18c0-1.66-1.34-3-3-3H15Zm21 7.172-9.947 4.519c-.647.29-1.34.45-2.053.45-.712 0-1.406-.15-2.053-.45L12 22.17V30c0 1.66 1.34 3 3 3h18c1.66 0 3-1.34 3-3v-7.828Z"/></g><defs><clipPath id="clip0_541_3429"><path fill="#fff" d="M0 0h48v48H0z"/></clipPath></defs></svg>
                </x-slot:icon>
                <x-slot:line1>Greetings to</x-slot:line1>
                <x-slot:line2>Antwerp</x-slot:line2>
            </x-oss-staggered-title>
            <x-oss-content>
                <p class="text-[20px]">We have received about {{ floor(\App\Models\Postcard::count() / 100) * 100 }} postcards, which means we are still missing about a billion cards. Would you like to send us a card?
                    <a href="{{ route('about') }}" class="underline">Find our address here</a>!</p>
            </x-oss-content>
        </section>

        @include('front.pages.open-source.partials.postcards')
    </div>
</x-page>
