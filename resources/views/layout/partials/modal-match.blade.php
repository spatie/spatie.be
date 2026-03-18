<div id="match" class="modal" onclick="history.back()">
    <div class="mr-16 bg-oss-black max-w-xl max-h-screen p-8 z-20 overflow-auto shadow-lg rounded-2xl | md:p-16 md:mx-8" onclick="event.stopPropagation()">
        <h2 class="text-white font-druk uppercase text-3xl md:text-4xl leading-[0.9]">{{ $caption ?? 'A good match' }}</h2>

        <div class="mt-10 grid gap-10">
            <div>
                <h3 class="text-white font-bold uppercase text-sm tracking-wider">What we do best</h3>
                <ul class="mt-4 line-l line-l-green text-oss-gray space-y-1">
                    <li>All things Laravel</li>
                    <li>Custom frontend components</li>
                    <li>Building APIs</li>
                    <li>AI-powered features & products</li>
                    <li>Simplifying things</li>
                    <li>Clean solutions</li>
                    <li>Integrating services</li>
                </ul>
            </div>
            <div>
                <h3 class="text-white/50 font-bold uppercase text-sm tracking-wider">Not our cup of tea</h3>
                <ul class="mt-4 line-l text-white/30 space-y-1">
                    <li>Wordpress themes</li>
                    <li>Cutting corners</li>
                    <li>Free mockups to win a job</li>
                    <li>'Just execute the briefing'</li>
                </ul>
            </div>
        </div>

        <p class="mt-10 text-lg text-oss-gray">
            In short: we'd like to be a <strong class="text-white">substantial part</strong> of your project.
        </p>
        <p class="mt-6">
            <a href="{{ mailto(
'A good match!',
'Tell us as much as you can about
- your online project
- your planning
- your budget
- …

Anything that helps us to start straightforward!'
) }}">
    <x-button>
        <span class="my-2 inline-block">Get in touch via email</span>
    </x-button>
    </a>
        </p>
    </div>
</div>
