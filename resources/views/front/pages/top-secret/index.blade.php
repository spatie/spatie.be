<div>
    @push('head')
        <link rel="stylesheet" href="https://use.typekit.net/oso3hdx.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Special+Elite&display=swap" rel="stylesheet">
    @endpush

    <header class="absolute grid grid-cols-3 h-16 items-center z-10 w-full">

        <nav class="text-bf-beige px-6 py-4 text-xs font-obviously-narrow uppercase font-semibold tracking-[0.15em]">
            <ul class="flex gap-4">
                <li><a href="#" class="hover:underline">About</a></li>
                <li><a href="#" class="hover:underline">Daily challenge</a></li>
            </ul>
        </nav>

        <div class="text-bf-beige text-base font-obviously-narrow uppercase font-semibold tracking-[0.2em] col-start-2 pt-4">
            <div class="text-center">
                <p>Day {{ $currentDay }}</p>
                <x-countdown :expires="$days[$currentDay]->endOfDay()">
                    <time datetime="{{ $days[$currentDay]->endOfDay()->format('Y-m-d H:i:s') }}" class="tabular-nums">
                        <span x-text="timer.hours"></span>:<span x-text="timer.minutes"></span>:<span x-text="timer.seconds"></span>
                    </time>
                </x-countdown>
            </div>
        </div>

    </header>

    @auth
        <div class="bf-page page-challenge">
            <div class="grid justify-center h-full pt-16">

                <div class="relative challenge-sheet">

                    <div class="max-w-[800px] overflow-hidden">

                        <div class="flex flex-col gap-6 p-12 pb-0 bg-white shadow-bf-hard">

                            <div class="font-special-elite">
                                @if ($reward)
                                    <div>
                                        Good work agent! You've completed the cipher for this day.

                                        Your reward: {{ $reward }}
                                    </div>
                                @else
                                    <div
                                        x-data="{
                                            showInput: false,
                                        }"
                                        class="grid gap-6 items-start"
                                    >
                                        <div
                                            x-on:click="showInput = true"
                                            class="px-8 border-b border-bf-beige paper-markup text-lg"
                                            x-bind:class="showInput ? '' : 'cursor-pointer underline decoration-bf-beige'"
                                        >
                                            {{ $question }}
                                        </div>

                                        <textarea
                                            x-show="showInput"
                                            x-on:click="$el.focus();$el.select();"
                                            class="form-input mx-8 border border-bf-dark-gray h-24"
                                            name="answer"
                                            id="answer"
                                            wire:model="answer"
                                        ></textarea>

                                        <div x-show="showInput" class="px-8 border-b border-bf-beige">
                                            <button class="underline decoration-bf-beige" wire:click="submitAnswer">> Submit your solution</button>
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>

                        <div class="mt-[-1px] pointer-events-none">
                            <img src="../images/black-friday/scrap-1.svg" alt="">
                        </div>

                        <div class="textured-paper absolute inset-0"></div>

                    </div>

                    <div class="flex text-white gap-4">
                        @foreach ($days as $day => $date)
                            <div
                                class="
                                    {{ $currentDay === $day ? 'border border-white' : '' }}
                                    {{ $date->isFuture() ? 'opacity-50' : 'cursor-pointer' }}
                                "
                                @if ($date->isPast())
                                wire:click="setDay({{ $day }})"
                                @endif
                            >
                                @if (Auth::user()->hasFlag("bf-day-{$day}"))
                                    ✔︎
                                @endif

                                Day {{ $day }}
                            </div>
                        @endforeach
                    </div>

                </div>

                <div class="bf-overlay place-items-end hidden">

                    <div class="relative max-w-[632px] w-full bg-white p-8 shadow-bf-smooth paper-holes">

                        <button class="raffle-token">
                            <img src="../images/black-friday/raffle-token.svg" alt="Get a secret prize" class="w-56">
                        </button>

                        <div class="p-8 text-lg font-special-elite paper-markup paper-dotted-border">
                            <p>Agent,</p>
                            <p>Your last transmission was positive. Good job.</p>
                            <p>You've earned a token of encouragement.</p>
                            <div
                                class="sheet-highlight-markup text-bf-red-dark p-4 paper-dotted-border text-center mb-[1em]">
                                <p>Use the next coupon to get <em>20% off</em> on every next purchase on <a
                                        href="https://spatie.be/products">spatie.be</a>:</p>
                                <p>24-TOPSECRET-CODE</p>
                            </div>
                            <p>Information regarding the reward will also be transmitted to your secure channel.</p>
                            <p>Awaiting your transmission tomorrow.</p>
                            <p>Broadcast your success on: <a href="#">Bluesky</a>, <a href="#">X</a></p>
                        </div>

                        <div class="absolute inset-0 pointer-events-none flex place-content-center">
                            <img src="../images/black-friday/spatie-logo.svg" alt="Spatie"
                                class="w-96 opacity-[0.05] rotate-[-12.5deg]">
                        </div>

                        <div class="textured-paper absolute inset-0"></div>
                    </div>

                </div>

                <div class="bf-overlay place-items-end hidden">
                    <div class="relative max-w-[632px] w-full bg-white p-8 shadow-bf-smooth paper-holes">

                        <div class="p-8 text-lg font-special-elite paper-markup paper-dotted-border">
                            <p>Agent,</p>
                            <p>Your last transmission was inaccurate.</p>
                            <p>Decipher the code using this hint:</p>
                            <div
                                class="sheet-highlight-markup text-bf-red-dark p-4 paper-dotted-border text-center mb-[1em]">
                                <p>Hint</p>
                            </div>
                            <p>No additional assistance will follow.</p>
                            <p>Proceed with caution.</p>
                            <p><a href="#">Discard</a></p>
                        </div>

                        <div class="absolute inset-0 pointer-events-none flex place-content-center">
                            <img src="../images/black-friday/spatie-logo.svg" alt="Spatie"
                                class="w-96 opacity-[0.05] rotate-[-12.5deg]">
                        </div>

                        <div class="textured-paper absolute inset-0"></div>
                    </div>

                </div>
                <div class="bf-overlay hidden">

                    <div class="relative max-w-[460px] bg-bf-red p-4 shadow-bf-smooth">

                        <div class="p-4 paper-markup border-2 leading-snug border-[#DA5A55]">
                            <h2 class="text-3xl font-obviously-condensed uppercase font-bold mb-4 tracking-wide leading-none">Smart
                                agents are capable agents!</h2>
                            <p class="mb-4">Enter the daily raffle for a chance to <strong>win a one-hour face-to-face
                                    meeting</strong> with Special Agent Know-It-All, the sharpest mind in packaging at
                                S.P.A.T.I.E.</p>
                            <label for="raffle" class="flex items-center mb-4">
                                <input class="form-checkbox mr-4" type="checkbox" name="raffle" id="raffle">
                                <span class="text-sm leading-tight">Yes, include me in the daily raffle to win a chance for a one hour consultation with Spatie</span>
                            </label>
                            <button
                                class="text-2xl font-obviously-condensed uppercase font-bold underline hover:no-underline tracking-wide">Enter
                                the raffle</button>
                        </div>

                        <div class="textured-paper absolute inset-0"></div>
                    </div>
                </div>
            </div>
        </div>
    @endauth

    <div class="bf-page page-about">

        @guest
            <div class="bf-overlay">
                <div class="max-w-xl mx-auto">
                    @include('front.pages.top-secret.components.login')
                </div>
            </div>
        @endguest

        <div class="grid justify-center paper-stack h-full pt-16">

            <div class="relative max-w-[760px] bg-paper-cover-beige overflow-hidden paper-stack-item">
                <div class="flex relative">

                    <div class="p-12 lg:p-24 text-lg w-full paper-markup">
                        <div class="flex flex-col items-center text-center">
                            <img src="../images/black-friday/spatie-logo.svg" alt="Spatie" class="w-56 mb-8">
                            <h1
                                class="font-obviously-condensed font-bold text-[4rem] uppercase leading-[80%] text-bf-brown text-balance lg:text-8xl">
                                Instructions for new Agents</h1>
                            <img src="../images/black-friday/confidential-stamp.png" alt="" class="w-[365px]">
                            <a href="#"
                                class="text-bf-red-dark text-2xl font-obviously-condensed uppercase font-bold underline hover:no-underline tracking-wide">Do
                                not click to open</a>
                        </div>
                    </div>

                </div>

                <div class="textured-paper absolute inset-0"></div>
            </div>

            <div class="relative max-w-[760px] bg-white shadow-bf-hard paper-stack-item lg:rotate-[-2.5deg]">

                <div class="absolute right-0 aspect-square w-32 flex items-center red-sticky">
                    <span class="block font-marker p-4 text-center font-sm leading-tight">
                        <a href="#" class="underline hover:no-underline">Note to self: be sure to check out all
                            the
                            rewards</a>
                    </span>
                </div>

                <div class="flex overflow-hidden">

                    <div class="p-14 lg:p-28 font-special-elite text-lg paper-markup">
                        <p>Agent,</p>
                        <p>Welcome to <abbr title="Secure Packages And Technical Intelligence Extraction">S.P.A.T.I.E.</abbr>.—the elite force of package builders. Prepare to forget everything you
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
                        <p><a href="#">Start deciphering</a></p>
                    </div>

                    <div class="textured-paper absolute inset-0"></div>

                </div>

                <div
                    class="max-w-[632px] w-full bg-bf-red-light p-8 shadow-bf-smooth overflow-hidden rewards-card rewards-card-markup">
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
