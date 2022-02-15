<x-page
        background="/backgrounds/vacancies.jpg"
        title="React developer vacancy"
        description="Vacancy for a react developer. Location: Antwerp."
>

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                React Developer
            </h1>
            <p class="mt-4">
                <span class="icon mr-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-left') }}</span> <a
                        href="{{ route('vacancies.index')}}" class="link-underline link-blue">Vacancies overview</a>
            </p>
        </div>
    </section>

    <div class="section section-group pt-0 section-fade">
        <section id="intro" class="section">
            <div class="wrap wrap-6">
                <div class="sm:col-span-4">
                    <div class="markup links-underline links-blue">


                        <div class="">
                            <h3 class="title">Spatie</h3>
                            <p>We are architects and builders, tinkering at the front line; an open-source mastodon, operated by a highly talented bunch the size of a football team.
                            </p>
                            <p>
                            What this brings to you? Learn and grow fast in an almost familiar, respectful environment. Yet you'll have an enormous impact on users worldwide.
                            Together we'll decide where we'll go next. 
                            </p>
                            <p>Rest assured: there will be laughs and great food along the way.</p>
                        </div>

                        <div class="mt-16">
                            @include('front.pages.vacancies.partials.clients')
                        </div>

                        <div class="mt-16">
                            <h3 class="title">First rule: stagnation means decline</h3>
                            <ul class="bullets bullets-green">
                                <li>
                                    <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                    There is a strong mentality to stay on top of things: through Slack, in-house presentations or conferences.
                                    Spend <strong>half a day each week</strong> on experiment and open source work</li>
                                <li>
                                    <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                    Get €1500,- <strong>extra budget</strong> every year for personal growth. Spend it on courses, train rides and hotels for conferences like
                                    dotJS/dotCSS, nordic.JS, Frontend United.
                                </li>
                                <li>
                                    <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                    <strong>Juggle your work-life balls</strong> in our little circus after that umpteenth quarantine. We don't do overtime.
                                    We're open to changing our ways as organization to keep things fresh.
                                </li>
                                <li>
                                    <span class="icon">{{ svg('icons/far-angle-right') }}</span> We <strong>put our heads together</strong>: on a daily basis to get our code working, weekly in our planning update, monthly for knowledge sharing and a company lunch, 
                                    twice a year to discuss your personal track/ambitions, and yearly for secret santa's diner. 
                                </li>
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                    Grow together with a team that has <strong>made its name in open source</strong>, with more that 250.000.000 downloads of packages worldwide. 
                                    Spot your fellow team members as experts in user groups or as conference speakers.
                                </li>
                            </ul>
                        </div>

                        <div class="mt-16">
                            <h3 class="title">And you?</h3>
                            <ul class="bullets bullets-green">
                                <li>
                                   <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                   You love the React + Typescript combo, and you know where JavaScript comes from.
                                </li>
                                <li>
                                   <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                   You know Git. That's it.
                                </li>
                                <li>
                                    <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                    You work independently but aren't afraid to ask when you're stuck.
                                </li>
                                <li>
                                    <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                    You love Italian food.
                                 </li>
                                 <li>
                                    <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                    …
                                 </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="offer" class="section">
            @include('front.pages.vacancies.partials.offer')
        </section>
    </div>

    <div class="section section-group">
        @include('front.pages.web-development.partials.stack')
        @include('front.pages.vacancies.partials.cta', ['github' => true ])
    </div>

</x-page>
