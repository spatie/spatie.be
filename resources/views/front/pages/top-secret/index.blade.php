<div>
    @push('head')
        <link rel="stylesheet" href="https://use.typekit.net/oso3hdx.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Special+Elite&display=swap" rel="stylesheet">
    @endpush

    <nav class="text-bf-beige px-6 py-4 text-xs font-obviously-narrow uppercase font-semibold tracking-[0.15em]">
        <ul class="flex gap-4">
            <li><a href="#" class="hover:underline">About</a></li>
            <li><a href="#" class="hover:underline">Daily challenge</a></li>
        </ul>
    </nav>

    <div class="text-bf-beige text-base font-obviously-narrow uppercase font-semibold tracking-[0.2em]">
        <div class="text-center">
            <p>Day {{ $currentDay }}</p>
            <x-countdown :expires="$days[$currentDay]->endOfDay()">
                <time datetime="{{ $days[$currentDay]->endOfDay()->format('Y-m-d H:i:s') }}" class="tabular-nums">
                    <span x-text="timer.hours"></span>:<span x-text="timer.minutes"></span>:<span x-text="timer.seconds"></span>
                </time>
            </x-countdown>
        </div>
    </div>

    @auth
        <div class="bg-white font-special-elite max-w-lg mx-auto py-8">
            @if (Auth::user()->hasFlag("bf-day-{$currentDay}"))
                <div>
                    Good work agent! You've completed the cipher for this day.
                </div>
            @else
                <div class="grid gap-6 items-start">
                    <div class="px-8 border-b border-bf-beige paper-markup text-lg">
                        {{ $question }}
                    </div>

                    <textarea
                        x-data x-on:click="$el.focus();$el.select();"
                        class="form-input mx-8 border border-bf-dark-gray h-24"
                        name="answer"
                        id="answer"
                        wire:model="answer"
                    ></textarea>

                    <div class="px-8 border-b border-bf-beige">
                        <button class="underline underline-offset-1 decoration-bf-beige" wire:click="submitAnswer">> Submit your solution</button>
                    </div>
                </div>
            @endif
        </div>

        <div class="flex text-white gap-4">
            @foreach ($days as $day => $date)
                <div class="{{ $currentDay === $day ? 'border border-white' : '' }}" wire:click="setDay({{ $day }})">
                    @if (Auth::user()->hasFlag("bf-day-{$day}"))
                        ✔︎
                    @endif

                    Day {{ $day }}
                </div>
            @endforeach
        </div>
    @else
        <div class="max-w-xl mx-auto">
            @include('front.pages.top-secret.components.login')
        </div>
    @endauth

    <div class="stack grid">

        <div class="relative max-w-[760px] bg-paper-cover-beige rounded-lg">
            <div class="flex relative z-[1]">
                <div class="p-24 text-lg w-full paper-markup">

                    <div class="flex flex-col items-center text-center">
                        <img src="../images/black-friday/spatie-logo.svg" alt="Spatie" class="w-56 mb-8">
                        <h1 class="title text-5xl uppercase text-bf-brown text-balance">Instructions for new Agents</h1>
                        <img src="../images/black-friday/confidential-stamp.png" alt="" class="w-[365px]">
                        <a href="#" class="text-bf-red-dark text-lg underline hover:no-underline uppercase font-bold">Do not click to open</a>
                    </div>

                </div>
            </div>
            <div class="textured-paper absolute inset-0"></div>
        </div>

        <div class="relative max-w-[760px] bg-white shadow-bf-hard">

            <div class="absolute right-0 aspect-square w-32 flex items-center z-10 red-sticky">
                <span class="block font-marker p-4 text-center font-sm leading-tight">
                    <a href="#" class="underline hover:no-underline">Note to self: be sure to check out all the rewards</a>
                </span>
            </div>

            <div class="flex z-[1] overflow-hidden">

                <div class="p-28 font-special-elite text-lg paper-markup">
                    <p>Agent,</p>
                    <p>Welcome to <abbr title="Secure Packages And Technical Intelligence Extraction">S.P.A.T.I.E.</abbr>—the elite force of package builders. Prepare to forget everything you
                        think
                        you know about how the package gets made.</p>
                    <p>To deploy you quickly, we’ve prepared a simple challenge to be completed over the next few days.
                    </p>
                    <p>Enclosed within this folder are <em>five encrypted fragments</em>. Decipher <em>one fragment
                            daily</em> and relay
                        the
                        solution to your contact. Submit a correct solution, and <em>you’ll earn a reward</em>. </p>
                    <p>Once you deciphered all the fragments, read the full message and carry out the command.</p>
                    <p>No questions. No hesitation. Don’t fail.</p>
                    <p>Sgt. Murze</p>
                    <p><a href="#">Start deciphering</a></p>
                </div>

                <div class="textured-paper absolute inset-0 pointer-events-none"></div>

            </div>

            <div class="bg-bf-red-light p-8 shadow-bf-smooth">
                <div class="border p-8 font-special-elite paper-markup">
                    <p>Some of the incentives we provide new agents:</p>
                    <ul>
                        <li>20% discount on your next purchase on <a href="https://spatie.be" class="underline">spatie.be</a></li>
                        <li>30% discount on merchandise on our <a href="https://spatie.spreadshop.be" class="underline">Merch Store</a></li>
                        <li>50% off on Mailcoach and Flare plans</li>
                        <li>Free Spatie merchandise</li>
                        <li>Free yearly licenses for Ray</li>
                    </ul>
                </div>
            </div>

        </div>

        <div class="relative max-w-[760px] bg-white">
            <div class="textured-paper absolute inset-0"></div>
        </div>

    </div>
</div>
