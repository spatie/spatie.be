@php($color = $repositoryModel->accent_color)

<style>
    :root {
        --accent-color: {{ $color }};
    }
</style>

<div class="docs-branded-header bg-oss-gray-light p-14 rounded-[16px] text-[18px] mb-5">
    <div class="absolute w-full flex justify-center left-0 right-0 top-0">
        <svg width="780" height="140" viewBox="0 0 780 140" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g opacity="0.3" filter="url(#filter0_f_36_5504)">
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

    <div class="flex items-center space-x-6 mb-10">
        <div class="logo">
            {!! $repositoryModel->logo_svg !!}
        </div>
        <h1 class="text-[30px] font-bold">
            {{ ($repositoryModel->banner_title) ? $repositoryModel->banner_title : str()->headline($repositoryModel->name) }}
        </h1>
    </div>

    <h2 class="text-[24px] leading-[1.2] font-bold mb-3">{{ $repositoryModel->intro_title }}</h2>
    <div class="mb-5">
        {{ $repositoryModel->intro_text}}
    </div>

    <div class="flex justify-between">
        <div class="space-x-2">
            <a href="{{ $alias->githubUrl }}" target="_blank" class="bg-[--accent-color] rounded drop-shadow-sm px-4 py-2 inline-flex items-center space-x-2 text-[16px] hover:brightness-90">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.0003 1.67095C5.40443 1.67095 1.68359 5.39595 1.68359 9.99179C1.68359 13.571 3.97526 16.7501 7.36693 17.8793C7.78359 17.9585 7.96276 17.7001 7.96276 17.4793V16.0668C5.65026 16.5668 5.16276 14.9501 5.16276 14.9501C5.0003 14.4411 4.65818 14.0087 4.20026 13.7335C3.44609 13.221 4.25859 13.2293 4.25859 13.2293C4.79193 13.3043 5.26276 13.621 5.52943 14.0918C5.76003 14.5043 6.14496 14.8085 6.59966 14.9374C7.05435 15.0663 7.54162 15.0094 7.95443 14.7793C7.98776 14.3585 8.17526 13.9626 8.47443 13.6668C6.63276 13.4543 4.69109 12.7418 4.69109 9.55429C4.67703 8.72737 4.98341 7.92707 5.54609 7.32095C5.29161 6.60393 5.32143 5.81667 5.62943 5.12095C5.62943 5.12095 6.32526 4.89595 7.91693 5.97095C9.27824 5.60013 10.714 5.60013 12.0753 5.97095C13.6628 4.89595 14.3586 5.12095 14.3586 5.12095C14.6669 5.81679 14.6953 6.60429 14.4419 7.32095C15.0047 7.92697 15.3108 8.72741 15.2961 9.55429C15.2961 12.7501 13.3544 13.4501 11.4994 13.6585C11.8994 14.0668 12.1078 14.6251 12.0628 15.196V17.4793C12.0628 17.7543 12.2128 17.9626 12.6586 17.8793C17.0169 16.4251 19.3703 11.7126 17.9169 7.35429C17.3624 5.69415 16.2983 4.25121 14.8762 3.23083C13.4541 2.21044 11.7464 1.66459 9.99609 1.67095H10.0003Z" fill="#172A3D"/>
                </svg>

                <span>Repository</span>
            </a>

            @if($repositoryModel->has_issues)
            <a href="{{ $alias->githubUrl }}/issues" target="_blank" class="bg-[--accent-color] rounded drop-shadow-sm px-4 py-2 inline-flex items-center space-x-2 text-[16px] hover:brightness-90">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 2C8.34375 2 7 3.34375 7 5V6H13V5C13 3.34375 11.6562 2 10 2ZM4.28125 5.21875L3.75 4.6875L2.69063 5.75L3.22187 6.28125L5.00312 8.0625L5 8.5V10.25H2.75H2V11.75H2.75H5V12C5 12.85 5.2125 13.65 5.5875 14.3531L3.56875 16.3687L3.0375 16.9L4.09687 17.9594L4.62812 17.4281L6.49375 15.5625C7.39687 16.4531 8.63438 17 10 17C11.3656 17 12.6031 16.4531 13.5063 15.5656L15.3719 17.4312L15.9031 17.9625L16.9625 16.9031L16.4312 16.3719L14.4125 14.3531C14.7875 13.6531 15 12.85 15 12V11.75H17.25H18V10.25H17.25H15V8.5V8.05937L16.7812 6.27812L17.3125 5.74687L16.25 4.69062L15.7188 5.22187L13.9375 7.00312L13.5 7H6.5H6.05937L4.28125 5.21875ZM9.25 15.4187C7.67812 15.075 6.5 13.675 6.5 12V8.5H13.5V12C13.5 13.675 12.3219 15.075 10.75 15.4187V10.75V10H9.25V10.75V15.4187Z" fill="#172A3D"/>
                </svg>

                <span>Open Issues</span>
            </a>
            @endif
        </div>
        <div class="flex items-center space-x-4 text-xs">
            <div class="flex items-center space-x-2">
                <svg width="21" height="22" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.875 10.125L10.5 14.5L6.125 10.125V9.25H8.75V4.875H12.25V9.25H14.875V10.125ZM6.125 15.375H14.875H15.75V17.125H14.875H6.125H5.25V15.375H6.125Z" fill="#172A3D"/>
                </svg>

                <span>{{number_format($repositoryModel->downloads)}}</span>
            </div>
            <div class="flex items-center space-x-2">
                <svg width="21" height="22" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.5016 4L12.8668 8.48438L17.8625 9.34844L14.327 12.9824L15.0488 18L10.5016 15.7633L5.95156 18L6.67344 12.9824L3.14062 9.34844L8.13359 8.48438L10.5016 4Z" fill="#172A3D"/>
                </svg>

                <span>{{number_format($repositoryModel->stars)}}</span>
            </div>
        </div>
    </div>
</div>
