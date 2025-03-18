<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="author" content="">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <link href="https://fonts.cdnfonts.com/css/pt-root-ui" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist+Mono:wght@500&display=swap" rel="stylesheet">

    <style>
        .logo svg {
            width: 72px;
            height: 72px;
            filter: drop-shadow(0px 52.56px 78.48px rgba(0, 0, 0, 0.0646228)) drop-shadow(0px 11.74px 17.5295px rgba(0, 0, 0, 0.0953772)) drop-shadow(0px 3.49529px 5.219px rgba(0, 0, 0, 0.16));
        }

        h1 {
            font-family: 'PT Root UI', sans-serif;
            font-weight: 700;
        }

        .text-gheist {
            font-family: "Geist Mono", monospace;
        }
    </style>
</head>

@php($color = $repository->accent_color)
@php($dark = $mode === 'dark')

<body class="bg-transparent">
    <div @class([
        'max-w-[830px] font-smoothing relative',
        'text-white bg-[#0E1117]' => $dark,
        'text-black bg-white' => ! $dark,
        'rounded-2xl border border-[#4D4D4D]',
        'border-[#A7ADB4]' => !$dark,
    ])>
        <div class="absolute w-full flex justify-center">
            <svg width="780" height="140" viewBox="0 0 780 140" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g opacity="0.7" filter="url(#filter0_f_36_5504)">
                    <ellipse cx="390" rx="300" ry="50" fill="{{$color}}"/>
                </g>
                <defs>
                    <filter id="filter0_f_36_5504" x="0" y="-140" width="780" height="280" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                        <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                        <feGaussianBlur stdDeviation="45" result="effect1_foregroundBlur_36_5504"/>
                    </filter>
                </defs>
            </svg>
        </div>

        <div class="flex items-center justify-center py-10 space-x-6">
            <div class="w-[72px] logo">
                {!! $repository->logo_svg !!}
            </div>

            <div>
                <h1 class="text-[34px] font-['PT Root UI']">{{ str()->title($repository->name) }}</h1>
            </div>
        </div>

        <footer class="flex items-top w-full justify-between px-2 relative z-0">
            <div @class([
                'border-t absolute top-0 left-0 right-0',
                'border-t-[#4D4D4D]' => $dark,
                'border-[#A7ADB4]' => !$dark,
            ])></div>
            <div class="pt-[12px] pb-2">
                <div class="package-header-pattern-left bg-repeat-x w-[635px] h-[13px] bg-contain py-2"></div>
            </div>
            <div class="border-t border-t-[{{$color}}] h-[20px] z-5 pt-[3px]">
                <span class="text-gheist text-xs">spatie.be/open-source</span>
            </div>
            <div class="pt-[12px] pb-2">
                <div class="package-header-pattern-right bg-repeat-x w-[13px] h-[13px] bg-contain"></div>
            </div>
        </footer>
    </div>
</body>
</html>
