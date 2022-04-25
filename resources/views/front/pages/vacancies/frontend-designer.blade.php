<x-page
        background="/backgrounds/vacancies.jpg"
        title="Frontend designer vacancy"
        description="Vacancy for a frontend designer. Location: Antwerp."
>
<script type="application/ld+json"> {
	"@context": "http://schema.org",
	"@type": "JobPosting",
	"datePosted": "2022-04-22T00:00:00",
    "validThrough": "2023-04-22T00:00:00",
	"description": "<p>
                        You will be working at the front-of-the-front-end.
                    </p> 
                    <ul>
                        <li>You help defining personality for our own products.</li>
                        <li>You can discuss and design UIs.</li>
                        <li>You design and implement concrete marketing actions.</li>
                        <li>You write fluent HTML, (Tailwind) CSS and pieces of JavaScript.</li>
                        <li>You can speak Dutch and you love Italian food.</li>
                    </ul>
                    <p>
                        Learn and grow together with a team that has made its name in open source. You'll have an enormous impact on users worldwide.
                    </p>",
	"title": "Frontend Designer",
	"employmentType": "FULL_TIME",
	"hiringOrganization": {
		"@type": "Organization",
		"name": "Spatie",
        "sameAs": "https://spatie.be",
        "logo": "http://spatie.be/images/spatie.png"
	},
	"jobLocation": {
		"@type": "Place",
		"address": {
			"@type": "PostalAddress",
			"streetAddress": "Kruikstraat 22",
			"addressLocality": "Antwerp",
            "addressRegion": "Antwerp",
			"postalCode": "2018",
			"addressCountry": "BE"
		}
	}
} </script>

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Frontend Designer
            </h1>
            <p class="mt-4">
                <span class="icon mr-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-left') }}</span> <a
                        href="{{ route('vacancies.index')}}" class="link-underline link-blue text-xl">Vacancies overview</a>
            </p>
        </div>
    </section>

    <div class="section section-group pt-0 section-fade">
        <section id="intro" class="section">
            <div class="wrap wrap-6">
                <div class="sm:col-span-4">
                    <div class="markup links-underline links-blue">

                        <p class="text-2xl">
                            Cool that you found out about this vacancy! 
                            <br>Are you a recruiter? <a title="📵 Stop calling us and dance 🕺!" href="{{ route('vacancies.recruiters')}}">Read on</a>.
                        </p>
                        <div class="mt-16">
                            <h3 class="title">Spatie</h3>
                            <p>We are architects and builders, tinkering on the front line; an open-source mastodon operated by a highly talented bunch the size of a soccer team.
                                We purposefully keep the company small but knowledgeable.
                            </p>
                            <p>
                            What does this bring to you? Learn and grow fast in a respectful, almost familiar environment. Yet you'll have an enormous impact on users worldwide.
                            Together we'll decide where we'll go next. 
                            </p>
                            <p>Rest assured: there will be laughs and great food along the way.</p>
                        </div>

                        <div class="mt-16">
                            @include('front.pages.vacancies.partials.clients', ['profile' => 'front'])
                        </div>

                        @include('front.pages.vacancies.partials.stagnation-decline', ['profile' => 'front']) 

                        <div class="mt-16">
                            <h3 class="title">And you?</h3>
                            <ul class="bullets bullets-green">
                                <li>
                                   <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                   You will be working at the front-of-the-front-end (see this <a href="https://bradfrost.com/blog/post/front-of-the-front-end-and-back-of-the-front-end-web-development/">definition</a> by Brad Frost).
                                </li>
                                <li>
                                    <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                    You help defining personality for our own products — sketch logos, pick fonts, define color palettes, provide illustrations or create short animations.
                                </li>
                                <li>
                                    <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                    You can discuss and design UIs — from idea, to prototype, to implementation. We use paper, Figma and Illustrator, but are open to any tool that gets the job done.
                                </li>
                                <li>
                                    <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                    You design and implement concrete marketing actions: banners, newsletters or one-page promo sites.
                                </li>
                                <li>
                                    <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                    You love to play with new technologies, try out new things that won't make production or tinker on your secret side project.
                                </li>
                                <li>
                                   <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                   You write fluent HTML, (Tailwind) CSS and pieces of JavaScript. You know a bit of Git.
                                </li>
                                <li>
                                    <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                    You can speak Dutch and you love Italian food.
                                 </li>
                            </ul>

                            <div class="mt-16 gradient gradient-blue p-8 rounded">
                                More of a <strong>React/JS</strong> type? Check our <a href="{{ route('vacancies.show', 'react-engineer') }}">React vacancy</a> as well.
                            </div>
                            
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
        @include('front.pages.vacancies.partials.cta')
    </div>

</x-page>
