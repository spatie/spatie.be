<html>
<head>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

    <style>
        {{--
            I've added these styles to make it easier to see how the image would render.
            Feel free to change this
        --}}
        .meta-container {
            height: 630px;
            width: 1200px;
            background-color: #fff;
        }

        body {
            background-color: #000;
        }
    </style>
</head>
<body>
<div class="py-6 flex flex-col justify-center sm:py-12 p-20 meta-container">
    <div class="relative py-3">
        <div class="absolute inset-0 bg-gradient-to-r transform skew-y-0 -rotate-5 sm:rounded-3xl"></div>
        <div class="relative px-4 py-10 bg-white sm:p-10">
            <div class="mx-auto">
                <div class="divide-y divide-gray-200">
                    <div class="pb-4 text-base space-y-4 leading-9">
                        <p class="font-display text-6xl font-bold">{{ $achievement->title }}</p>
                        {{ $user->name }}
                    </div>
                    <div class="pt-6 text-base leading-6 font-bold sm:text-lg sm:leading-7">
                        <div class="md:flex items-end">
                            <div>
                                <h1 class="text-lg font-display uppercase tracking-wider font-extrabold">
                                    <a href="/">Spatie.be</a>
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
