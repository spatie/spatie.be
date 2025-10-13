<x-page background="/backgrounds/jobs.jpg" title="Backend engineer vacancy"
        description="Vacancy for a Backend engineer. Location: Antwerp.">
    <script type="application/ld+json">
        {
            "@context": "http://schema.org"
            , "@type": "JobPosting"
            , "datePosted": "2025-03-01T00:00:00"
            , "validThrough": "2026-03-01T00:00:00"
            , "description": "<p>
            You love the PHP + Laravel combo. <
            /p>  <
            ul >
            li > You know git.</li> <
            li > You can work independently but aren 't afraid to ask when you'
            re stuck. < /li> <
            li > You can speak Dutch and you love Italian food. < /li> <
            /ul> <
            p >
            Learn and grow together with a team that has made its name in open source. You 'll have an enormous impact on users worldwide. <
            /p>",
            "title": "Backend Engineer"
            , "employmentType": "FULL_TIME"
            , "hiringOrganization": {
                "@type": "Organization"
                , "name": "Spatie"
                , "sameAs": "https://spatie.be"
                , "logo": "http://spatie.be/images/spatie.png"
            }
            , "jobLocation": {
                "@type": "Place"
                , "address": {
                    "@type": "PostalAddress"
                    , "streetAddress": "Kruikstraat 22"
                    , "addressLocality": "Antwerp"
                    , "addressRegion": "Antwerp"
                    , "postalCode": "2018"
                    , "addressCountry": "BE"
                }
            }
        }

    </script>

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Backend Engineer
            </h1>
            <p class="mt-4">
                <span class="icon mr-2 opacity-50 fill-current text-blue">{{ app_svg('icons/far-angle-left') }}</span>
                <a href="{{ route('vacancies.index')}}" class="link-underline link-blue text-xl">Vacancies overview</a>
            </p>
        </div>
    </section>

    <div class="section section-group pt-0 section-fade">
        <section id="intro" class="section">
            @include('front.pages.vacancies.partials.about')

            <div class="wrap wrap-6">
                <div class="mt-16 sm:col-span-4 markup links-underline links-blue">
                    <h3 class="title">The best is yet to come</h3>
                    <p>
                        We don't take on just any new project but only those where we all can learn something new.
                        We love to work with the latest and greatest.
                        To get an idea of what we've got in store for you, here are a few examples of projects and tasks
                        you might be involved with:</p>
                    <ul class="bullets bullets-green">
                        <li><span class="icon">{{ app_svg('icons/far-angle-right') }}</span>Build an onboarding
                            interface for a multi-tenant SaaS application that provisions fresh databases on the fly.
                        </li>
                        <li><span class="icon">{{ app_svg('icons/far-angle-right') }}</span>Model & implement an
                            event-sourced subscription engine capable of handling multiple frequencies, proration, and
                            processing thousands of renewals a month.
                        </li>
                        <li><span class="icon">{{ app_svg('icons/far-angle-right') }}</span>Aggregate APIs from a
                            handful of services to a centralized database for real-time financial reporting.
                        </li>
                        <li><span class="icon">{{ app_svg('icons/far-angle-right') }}</span>Develop an algorithm to
                            create bundles of time-sensitive products (hotel stays, flights, event tickets,…) ensuring
                            times don't overlap and taking real-time capacity into account.
                        </li>
                        <li><span class="icon">{{ app_svg('icons/far-angle-right') }}</span>Maintain an API that
                            receives hundreds of raw exception reports per minutes, process them into a human-readable
                            format and dispatch notifications to multiple channels depending on user- and team-specific
                            settings.
                        </li>
                        <li><span class="icon">{{ app_svg('icons/far-angle-right') }}</span>Continually engage in the
                            open source community and provide support for our <a
                                    href="{{ route('open-source.packages') }}">400+ Laravel & PHP packages</a>.
                        </li>
                    </ul>

                    <p>
                        You'll have a say in what you'll be working on. No really, we áre listening.
                        If you're curious to see how we work, these public <a href="https://spatie.be/guidelines">guidelines</a>
                        could give you a first impression.
                    </p>
                </div>
            </div>

            @include('front.pages.vacancies.partials.stagnation-decline', ['profile' => 'back'])

            <div class="wrap wrap-6">
                <div class="sm:col-span-4 mt-16 markup links-underline links-blue">
                    <h3 class="title">And you?</h3>
                    <ul class="bullets bullets-green">
                        <li>
                            <span class="icon">{{ app_svg('icons/far-angle-right') }}</span>
                            You love the PHP + Laravel combo.
                        </li>
                        <li>
                            <span class="icon">{{ app_svg('icons/far-angle-right') }}</span>
                            You know Git. That's it.
                        </li>
                        <li>
                            <span class="icon">{{ app_svg('icons/far-angle-right') }}</span>
                            You don't run away from technologies in our <a href="#stack">tech stack</a>.
                        </li>
                        <li>
                            <span class="icon">{{ app_svg('icons/far-angle-right') }}</span>
                            You can work independently but aren't afraid to ask when you're stuck.
                        </li>
                        <li>
                            <span class="icon">{{ app_svg('icons/far-angle-right') }}</span>
                            You can speak Dutch and you love Italian food.
                        </li>
                    </ul>

                    {{-- <div class="mt-16 gradient gradient-blue p-8 rounded">
                        More of a <strong>React/JS</strong> type? Check our <a href="{{ route('vacancies.show', 'react-engineer') }}">React vacancy</a> as well.
                </div> --}}
                </div>
            </div>

            <div class="wrap wrap-6">
                <div class="sm:col-span-4 mt-16 markup links-underline links-blue">
                    <h3 class="title">Show us your code</h3>
                    <p>
                        To get a better idea of what you're capable of, we'd like to see some code.
                        We don't expect your code to be perfect. We do expect you to be honest about your skills and
                        experience.
                        When applying, please send us:

                    </p>
                    <ul class="bullets bullets-green">
                        <li>
                            <span class="icon">{{ app_svg('icons/far-angle-right') }}</span>
                            A link to your GitHub profile or any open source contributions you've made.
                        </li>
                        <li>
                            <span class="icon">{{ app_svg('icons/far-angle-right') }}</span>
                            If you have no public code, a small project that shows
                            us what you're capable of. This could be a hobby project, or a repo containing a simple Laravel app that fetches data from an API and stores it in the database.
                        </li>
                    </ul>

                    {{-- <div class="mt-16 gradient gradient-blue p-8 rounded">
                        More of a <strong>React/JS</strong> type? Check our <a href="{{ route('vacancies.show', 'react-engineer') }}">React vacancy</a> as well.
                </div> --}}
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
