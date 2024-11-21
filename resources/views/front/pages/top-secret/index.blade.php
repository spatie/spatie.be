<?php $image = image("/backgrounds/bf-24-desk.jpg") ?>

<div x-data="{
    currentPage: 'about',
    showCover: true,
    showAwards: false,
    showToken: false
}">

    <div class="wallpaper">
        <img srcset="{{ $image->getSrcset() }}" src="{{ $image->getUrl() }}" width="2400" sizes="100vw" alt="" class="h-full object-cover">
    </div>

    @push('head')
        <link rel="stylesheet" href="https://use.typekit.net/oso3hdx.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Special+Elite&display=swap" rel="stylesheet">
    @endpush

    <header class="absolute grid grid-cols-3 h-16 items-center z-10 w-full">

        <nav class="text-bf-beige px-6 py-4 text-xs font-obviously-narrow font-semibold tracking-[0.15em] col-span-2 md:col-auto">
            <ul class="flex gap-4">
                <li>
                    <button @click="currentPage = 'about'" class="uppercase hover:underline" :class="{ 'underline': currentPage === 'about' }">About</button>
                </li>
                <li>
                    <button @click="currentPage = 'challenge'" class="uppercase hover:underline" :class="{ 'underline': currentPage === 'challenge' }">Daily Challenge</button>
                </li>
            </ul>
        </nav>

        <div
            class="pt-4 text-bf-beige text-base font-obviously-narrow uppercase font-semibold tracking-[0.2em] md:col-start-2">
            <div class="text-center">
                <p>Day {{ $currentDay }}</p>
                @if($days[$currentDay]->isToday())
                    <x-countdown :expires="$days[$currentDay]->endOfDay()">
                        <time datetime="{{ $days[$currentDay]->endOfDay()->format('Y-m-d H:i:s') }}" class="tabular-nums">
                            <span x-text="timer.hours"></span>:<span x-text="timer.minutes"></span>:<span
                                x-text="timer.seconds"></span>
                        </time>
                    </x-countdown>
                @else
                    <p>Challenge closed</p>
                @endif
            </div>
        </div>

    </header>

    @auth
        <div
            class="bf-page page-challenge"
            x-show="currentPage === 'challenge'"
            x-data="{
                showReward: @entangle('showReward'),
                showHint: @entangle('showHint')
            }"
        >
            <div class="grid justify-center h-full mt-16">

                <div class="relative challenge-sheet">

                    <div class="w-full max-w-[800px] m-auto">

                        @if ($reward)
                            <div class="red-sticky absolute right-0 -bottom-[4.5em] md:aspect-square w-32 flex items-center z-[1]">
                                <span class="block font-marker p-4 text-center text-sm md:text-base md:leading-tight">
                                    <button
                                        class="underline hover:no-underline"
                                        x-on:click="showReward = true"
                                    >
                                        Note to self: Got this one! Received a cool reward.
                                    </button>
                                </span>
                            </div>
                        @else
                            <div class="red-sticky absolute right-0 -bottom-[4.5em] md:aspect-square w-32 flex items-center z-[1]">
                                <span class="block font-marker p-4 text-center text-sm md:text-base md:leading-tight">
                                        Note to self: Too late to solve this one
                                </span>
                            </div>
                        @endif

                        <div class="flex flex-col gap-6 p-8 pb-0 lg:p-20 lg:pb-4 bg-white shadow-bf-hard">

                            <div class="font-special-elite">
                                @if ($reward)
                                    <p class="mb-2">{{ $question }}</p>
                                    <p class="text-blue mb-2">> {{ $answer }}</p>
                                @elseif($days[$currentDay]->endOfDay()->isPast())
                                    <p>{{ $question }}</p>
                                @else
                                    <div x-data="{
                                    showInput: @entangle('showInput').live,
                                }" class="grid gap-6 items-start">
                                        <div x-on:click="showInput = true" class="paper-markup group"
                                             x-bind:class="showInput ? '' : 'cursor-pointer'">
                                            <p class="group-hover:underline">{{ $question }}</p>
                                        </div>

                                        <textarea x-show="showInput" x-on:click="$el.focus();$el.select();"
                                                  class="form-input border border-bf-gray resize-none h-24 font-sans" name="answer" id="answer" wire:model="answer"></textarea>

                                        <div x-show="showInput">
                                            <button class="paper-action-btn" wire:click="submitAnswer">
                                                Submit your solution
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>

                        <div class="mt-[-2px] pointer-events-none">
                            <img src="../images/black-friday/scrap-{{ $currentDay }}.svg" alt="">
                        </div>

                        <div class="textured-paper absolute inset-0"></div>

                    </div>

                    <div class="p-12 lg:p-24 flex flex-wrap text-white gap-4 justify-center">
                        @foreach ($days as $day => $date)
                            <div class="p-2 lg:p-8
                                    {{ $currentDay === $day ? 'bf-date-border' : '' }}
                                    {{ $date->isFuture() ? 'opacity-50' : 'cursor-pointer' }}
                                "
                                 @if ($date->isPast()) wire:click="setDay({{ $day }})" @endif>
                                @if (in_array($day, $completedDays))
                                    ✔︎
                                @endif

                                <span class="font-obviously-narrow uppercase font-semibold tracking-[0.2em]">Day
                                    {{ $day }}</span>
                            </div>
                        @endforeach
                    </div>

                </div>

                <div class="bf-overlay place-items-end" x-show="showReward" x-transition.opacity>
                    @if($reward)
                        <div class="relative max-w-[632px] w-full max-h-[65vh] h-full bg-white p-8 shadow-bf-smooth paper-holes">

                            @if($reward->enteredRaffle === false && $days[$currentDay]->isToday())
                                <button class="raffle-token" x-on:click="showToken = true">
                                    <img src="../images/black-friday/raffle-token.svg" alt="Get a secret prize" class="w-56">
                                </button>
                            @endif

                            <div class="h-full p-8 text-lg font-special-elite paper-markup paper-dotted-border">
                                <p>Agent,</p>
                                <p>Your last transmission was positive. Good job.</p>
                                <p>You've earned a token of encouragement.</p>
                                <div
                                    class="sheet-highlight-markup text-bf-red-dark p-4 paper-dotted-border text-center mb-[1em]">
                                    {{ $reward->type->wonLabel() }}
                                    @if($reward->code)
                                        {{ $reward->code }}
                                    @endif
                                </div>
                                <p>Information regarding the reward will also be transmitted to your secure channel.</p>
                                <p>Awaiting your transmission tomorrow.</p>
                                <p>Broadcast your success on: 
                                    <a href="https://bsky.app/intent/compose?text={{ Str::of("I decoded my daily message on topsecret.spatie.be and got a nice prize!") }}">Bluesky</a>, 
                                    <a href="https://twitter.com/intent/tweet?text={{ Str::of("I decoded my daily message on topsecret.spatie.be and got a nice prize!") }}">X</a>
                                </p>
                                <p><button class="underline hover:no-underline" x-on:click="showReward = false">Discard</button></p>
                            </div>

                            <div class="absolute inset-0 pointer-events-none flex place-content-center">
                                <img src="../images/black-friday/spatie-logo.svg" alt="Spatie"
                                     class="w-96 opacity-[0.05] rotate-[-12.5deg]">
                            </div>

                            <div class="textured-paper absolute inset-0"></div>
                        </div>
                    @endif
                </div>

                <div class="bf-overlay place-items-end" x-show="showHint" x-transition.opacity>
                    <div class="relative max-w-[632px] w-full max-h-[65vh] h-full bg-white p-8 shadow-bf-smooth paper-holes">

                        <div class="h-full p-8 text-lg font-special-elite paper-markup paper-dotted-border">
                            <p>Agent,</p>
                            <p>Your last transmission was inaccurate.</p>
                            <p>Decipher the code using this hint:</p>
                            <div
                                class="sheet-highlight-markup text-bf-red-dark p-4 paper-dotted-border text-center mb-[1em]">
                                <p>{{ $hint }}</p>
                            </div>
                            <p>No additional assistance will follow.</p>
                            <p>Proceed with caution.</p>
                            <p><button class="underline hover:no-underline" x-on:click="showHint = false">Discard</button></p>
                        </div>

                        <div class="absolute inset-0 pointer-events-none flex place-content-center">
                            <img src="../images/black-friday/spatie-logo.svg" alt="Spatie"
                                 class="w-96 opacity-[0.05] rotate-[-12.5deg]">
                        </div>

                        <div class="textured-paper absolute inset-0"></div>
                    </div>

                </div>

                <div id="token-message" class="bf-overlay" x-show="showToken" x-transition>
                    <div class="relative max-w-[460px] bg-bf-red p-4 shadow-bf-smooth" x-data="{enteringRaffle: false}">

                        <div class="p-4 paper-markup border-2 leading-snug border-[#DA5A55]">
                            <h2
                                class="text-3xl font-obviously-condensed uppercase font-bold mb-4 tracking-wide leading-none">
                                Smart
                                agents are capable agents!</h2>
                            <p class="mb-4">Enter the raffle for a chance to
                                <strong>win a one-hour face-to-face
                                    meeting</strong> with Special Agent Know-It-All, the sharpest mind in packaging at
                                S.P.A.T.I.E.</p>
                            <label for="raffle" class="flex items-center mb-4">
                                <input x-model="enteringRaffle" class="form-checkbox mr-4" type="checkbox" name="raffle" id="raffle">
                                <span class="text-sm leading-tight">Yes, include me in a prize draw for a chance to win a one-hour consultation with Spatie.</span>
                            </label>
                            <button
                                wire:click="enterRaffle"
                                x-on:click="showToken = false"
                                x-bind:disabled="!enteringRaffle"
                                class="text-2xl font-obviously-condensed uppercase font-bold underline hover:no-underline tracking-wide">Enter the raffle
                            </button>
                        </div>

                        <div class="textured-paper absolute inset-0"></div>
                    </div>
                </div>

            </div>
        </div>
    @endauth

    <div class="bf-page page-about" x-show="currentPage === 'about'">

        @guest
            <div class="bf-overlay">
                <div class="max-w-xl mx-auto">
                    @include('front.pages.top-secret.components.login')
                </div>
            </div>
        @endguest

        <div
            class="grid justify-center paper-stack h-full pt-16 overflow-scroll md:overflow-visible"
        >

            <div
                class="relative max-w-[760px] bg-paper-cover-beige overflow-hidden paper-stack-item"
                x-show="showCover"
                x-transition
            >
                <div class="flex relative h-full">

                    <div class="p-12 lg:p-24 text-lg w-full paper-markup">
                        <div class="flex flex-col items-center text-center h-full">
                            <img src="../images/black-friday/spatie-logo.svg" alt="Spatie" class="w-56 mb-8">
                            <h1
                                class="font-obviously-condensed font-bold text-[3.5rem] uppercase leading-[80%] text-bf-brown text-balance lg:text-[7rem]">
                                Instructions for new Agents</h1>
                            <img src="../images/black-friday/confidential-stamp.png" alt=""
                                 class="w-[360px]">
                            <div class="md:mt-auto">
                                <button
                                    class="text-bf-red-dark text-2xl font-obviously-condensed uppercase font-bold underline hover:no-underline tracking-wide"
                                    x-on:click="showCover = false">
                                    Do not click to open
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="textured-paper absolute inset-0"></div>
            </div>

            <div class="relative max-w-[760px] bg-white shadow-bf-hard paper-stack-item rotate-0 md:rotate-[-2.5deg]">

                <div class="absolute right-0 md:aspect-square w-32 flex items-center red-sticky z-[1]">
                    <span class="block font-marker p-4 text-center text-sm md:text-base md:leading-tight">
                        <button
                            class="underline hover:no-underline"
                            x-on:click="showAwards = !showAwards"
                        >
                            Note to self: be sure to check out all the rewards
                        </button>
                    </span>
                </div>

                <div class="flex overflow-hidden">

                    <div class="p-12 lg:p-28 font-special-elite md:text-lg paper-markup">
                        <p>Agent,</p>
                        <p>Welcome to <abbr
                                title="Secure Packages And Technical Intelligence Extraction">S.P.A.T.I.E.</abbr>—the
                            elite force of package builders. Prepare to forget everything you
                            think
                            you know about how the package gets made.</p>
                        <p>To deploy you quickly, we’ve prepared a simple challenge to be completed over the next few
                            days.
                        </p>
                        <p>Enclosed within this folder are <em>five encrypted fragments</em>. Decipher <em>one fragment
                                daily</em> and relay
                            the
                            solution to your contact. Submit a correct solution, and <em>you’ll earn a reward</em>. </p>
                        <p>Once you deciphered all the fragments, read the full message and carry out the command.</p>
                        <p>No questions. No hesitation. Don’t fail.</p>
                        <p>Sgt. Murze</p>
                        <button @click="currentPage = 'challenge'" class="paper-action-btn underline hover:no-underline">Start deciphering</button>
                    </div>

                    <div class="textured-paper absolute inset-0"></div>

                </div>

                <div
                    class="max-w-[632px] w-full bg-bf-red-light p-8 shadow-bf-smooth overflow-hidden rewards-card rewards-card-markup"
                    x-show="showAwards"
                >
                    <div class="p-8 font-special-elite paper-markup paper-dotted-border">
                        <p>Some of the incentives we provide new agents:</p>
                        <ul>
                            <li>20% discount on your next purchase on <a href="https://spatie.be">spatie.be</a></li>
                            <li>30% discount on merchandise in our <a href="https://spatie.spreadshop.be">Merch
                                    Store</a>
                            </li>
                            <li>50% off on <a href="https://www.mailcoach.app">Mailcoach</a> and <a
                                    href="https://flareapp.io">Flare</a> plans</li>
                            <li>Free Spatie merchandise</li>
                            <li>Free yearly licenses for <a href="https://myray.app">Ray</a></li>
                        </ul>
                    </div>

                    <div class="absolute inset-0 pointer-events-none flex place-content-center">
                        <img src="../images/black-friday/spatie-logo.svg" alt="Spatie"
                             class="w-96 opacity-[0.05] rotate-[-12.5deg]">
                    </div>

                    <div class="textured-paper absolute inset-0"></div>
                </div>

            </div>

            <div class="relative max-w-[760px] bg-white paper-stack-item">
                <div class="textured-paper absolute inset-0"></div>
            </div>

        </div>

    </div>
</div>
