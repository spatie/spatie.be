<div id="match" class="modal" onclick="history.back()">
    <div class="mr-16 bg-white max-w-xl max-h-screen p-8 z-20 overflow-auto shadow-lg | md:p-16 md:mx-8">
        <h2 class="text-center title-xl">{{ $caption ?? 'A good match' }}</h2>

        <p class="mt-8 bg-green-lightest py-2 px-4 rounded text-sm">
            We are fully booked at the moment! <br>We have room for new projects starting from <strong>May 2021</strong>.
        </p>

        <div class="mt-8 markup grid gap-8 | md:grid-cols " style="--cols: 1fr 1fr">
            <div class=text-green-dark>
                <h3 class=title-sm>What we do best</h3>
                <ul class="mt-4 line-l">
                    <li>All things Laravel</li>
                    <li>Custom frontend components</li>
                    <li>Building APIs</li>
                    <li>Simplifying things</li>
                    <li>Clean solutions</li>
                    <li>Integrating services</li>
                </ul>
            </div>
            <div class="text-gray">
                <h3 class=title-sm>Not our cup of tea</h3>
                <ul class="mt-4 line-l">
                    <li>Wordpress themes</li>
                    <li>Cutting corners</li>
                    <li>Free mockups to win a job</li>
                    <li>'Just execute the briefing'</li>
                </ul>
            </div>
        </div>

        <p class="mt-8 text-xl">
            In short: we'd like to be a <strong>substantial part</strong> of your project.
        </p>
        <p class="mt-4 text-xl">
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
