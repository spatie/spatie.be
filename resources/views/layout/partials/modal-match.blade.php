@php
    $doItems = [
        'All things Laravel',
        'Custom frontend components',
        'Building APIs',
        'AI-powered features',
        'Simplifying things',
        'Clean solutions',
        'Integrating services',
    ];

    $notItems = [
        'WordPress themes',
        'Cutting corners',
        'Free mockups to win a job',
        '"Just execute the briefing"',
    ];
@endphp

<div id="match" class="modal font-pt font-medium" onclick="history.back()">
    <div class="bg-oss-black max-w-xl max-h-[90dvh] p-8 z-20 overflow-auto shadow-lg shadow-oss-gray-light/5 rounded-2xl border border-oss-gray-light/20 mx-4 | md:p-12 md:mx-8" onclick="event.stopPropagation()">

        <div class="flex items-start justify-between gap-4 mb-8">
            <h2 class="text-white font-druk uppercase text-7xl leading-[0.9]">A good<br>match?</h2>
            <button
                onclick="history.back()"
                class="shrink-0 size-8 rounded-full flex items-center justify-center text-white/40 hover:text-white/70 hover:bg-white/10 transition"
                aria-label="Close"
            >
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="grid gap-8 md:grid-cols-2 md:gap-6">
            <div>
                <h3 class="text-white font-bold uppercase text-xs tracking-wider mb-3">What we do best</h3>
                <ul role="list" class="space-y-2.5">
                    @foreach($doItems as $item)
                        <li class="flex gap-3 items-center text-oss-gray">
                            <div class="shrink-0 size-[22px] rounded border-2 border-oss-green-pale flex items-center justify-center">
                                <svg class="size-3 text-oss-green-pale" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            {{ $item }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="md:border-l md:border-white/10 md:pl-6">
                <h3 class="text-white/40 font-bold uppercase text-xs tracking-wider mb-3">Not our cup of tea</h3>
                <ul role="list" class="space-y-2.5">
                    @foreach($notItems as $item)
                        <li class="flex gap-3 items-center text-white/25">
                            <div class="shrink-0 size-[22px] rounded border-2 border-white/15 flex items-center justify-center">
                                <svg class="size-3 text-white/25" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            {{ $item }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <p class="mt-8 text-lg text-oss-gray">
            In short: we'd like to be a <strong class="text-white">substantial part</strong> of your project.
        </p>

        <a
            href="{{ mailto('A good match!', "Tell us as much as you can about\n- your online project\n- your planning\n- your budget\n- …\n\nAnything that helps us to start straightforward!") }}"
            class="mt-6 flex items-center justify-center w-full px-4 py-3 bg-oss-green-pale text-oss-black font-bold rounded-xl transition hover:opacity-90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-oss-green-pale"
        >
            Get in touch via email
        </a>
    </div>
</div>
