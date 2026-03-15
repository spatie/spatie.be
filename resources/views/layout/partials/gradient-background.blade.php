@props([
    'color1' => '#B21E4E',
    'color2' => '#015389',
    'color3' => '#E0614E',
    'rotationZ' => '235',
    'positionX' => '-1.5',
    'positionY' => '0.1',
    'uDensity' => '1.2',
    'uFrequency' => '5.5',
    'uStrength' => '3',
    'uSpeed' => '0.05',
])

@push('head')
    @vite(['resources/js/front/gradient.jsx'])
    <style>html { background: #050508 }</style>
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
        <div id="gradient" class="aspect-[9/16] sm:aspect-video w-full" data-url="https://www.shadergradient.co/customize?animate=on&axesHelper=on&bgColor1=%2300da00&bgColor2=%23c90000&brightness=0.4&cAzimuthAngle=180&cDistance=2.5&cPolarAngle=115&cameraZoom=1&color1=%23{{ ltrim($color1, '#') }}&color2=%23{{ ltrim($color2, '#') }}&color3=%23{{ ltrim($color3, '#') }}&destination=onCanvas&embedMode=off&envPreset=city&format=gif&fov=50&frameRate=10&grain=off&lightType=3d&pixelDensity=1.5&positionX={{ $positionX }}&positionY={{ $positionY }}&positionZ=0&range=disabled&rangeEnd=40&rangeStart=0&reflection=0.2&rotationX=0&rotationY=0&rotationZ={{ $rotationZ }}&shader=defaults&type=waterPlane&uAmplitude=0&uDensity={{ $uDensity }}&uFrequency={{ $uFrequency }}&uSpeed={{ $uSpeed }}&uStrength={{ $uStrength }}&uTime=0.2&wireframe=false"></div>
        <div class="absolute inset-0 z-10 w-full h-full aspect-video bg-gradient-to-b from-transparent to-oss-black"></div>
    </div>
@endpush
