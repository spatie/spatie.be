<section id="brief" class="section">
    <div class="wrap wrap-8">
        <div class="sm:col-span-3">
            <span class="illustration is-left is-rotated is-postcard-without-caption h-full">
                {{ image('hire.jpg') }}
            </span>
        </div>
        <div class="sm:col-span-3 sm:col-start-5">
            <h2 class="title-2xl">
                Hire <br>a team
            </h2>
            <div class="markup links-underline links-blue">
                <p class="text-lg">
                    We don't just execute, but need to be proud of our work —just like you.
                    That's why we love to work in partnership: as advisors, as architects of technically challenging projects.
                </p>
                <p class="text-lg">
                    <a href="{{ route('about') }}#team">Our team</a> is a fine blend of back &amp; frontend profiles that are used to working together, tightly coupled.
                </p>
                 <p class="text-lg">
                    We'd really like to know what kind of project or problem you're dealing with. Feed us with as much input as you have, so we can get accurate early on.
                </p>
            </div>
        </div>
    </div>
    <div class="wrap mt-32">
        <div class="card gradient gradient-green text-white">
            <div class="wrap-card grid md:grid-cols-2 md:items-start">
                <h2 class="title-xl">
                    <a class="link-white link-underline" href="{{ mailto(
'Potential project brief',
'Tell us as much as you can about
- your online project
- your planning
- your budget
- …

Anything that helps us to start straightforward!'
) }}">Brief us</a> your project
                </h2>
                <div class="line-l-white">
                    <h3 class="title-sm">
                        Topics to discuss
                    </h3>
                    <ul class="mt-4 bullets bullets-white">
                        <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Your main objective</li>
                        <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> The initial budget &amp; planning</li>
                        <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Who's doing content creation?</li>
                        <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> All external services / APIs</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

