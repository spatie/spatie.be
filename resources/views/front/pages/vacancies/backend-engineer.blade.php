<x-page
        background="/backgrounds/vacancies.jpg"
        title="Backend engineer vacancy"
        description="Vacancy for a Backend engineer. Location: Antwerp."
>
<script type="application/ld+json"> {
	"@context": "http://schema.org",
	"@type": "JobPosting",
	"datePosted": "2022-02-27T00:00:00",
    "validThrough": "2023-02-27T00:00:00",
	"description": "<p>
                        You're in love with the React + TypeScript combo.
                    </p> 
                    <ul>
                        <li>You know where JavaScript comes from.</li>
                        <li>You know Git. That's it.</li>
                        <li>You don't run away from Tailwind CSS</li>
                        <li>You can work independently but aren't afraid to ask when you're stuck.</li>
                        <li>You can speak Dutch and you love Italian food.</li>
                    </ul>
                    <p>
                        Learn and grow together with a team that has made its name in open source. You'll have an enormous impact on users worldwide.
                    </p>",
	"title": "Backend Engineer",
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
                Backend Engineer
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
                            @include('front.pages.vacancies.partials.clients')
                        </div>

                        <div class="mt-16">
                            <h3 class="title">First rule: stagnation means decline</h3>
                            <ul class="bullets bullets-green">
                                <li>
                                    <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                    There is a strong mentality to stay on top of things: through Slack, in-house presentations or conferences.
                                    Spend <strong>half a day each week</strong> on experiments and open source work.</li>
                                <li>
                                    <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                    Get €1500,- <strong>extra budget</strong> every year for personal growth. Spend it on books, courses and conferences (including train rides, hotels) like
                                    Laracon EU and US, DDD Europe, PHP Benelux, PHPUKConference, DPC, PHPDay ...
                                </li>
                                <li>
                                    <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                    <strong>Juggle with work-life balance</strong> in our little circus after that umpteenth quarantine. We don't do overtime.
                                    We're open to changing our ways as an organization to keep things fresh.
                                </li>
                                <li>
                                    <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                    <strong>Regularly working from home</strong> has become an efficient routine. 
                                    Yet we value personal connections and visit the office at least two days a week. We get that those who have to commute have a different regime than someone who only has to jump on a bike.
                                </li>
                                <li>
                                    <span class="icon">{{ svg('icons/far-angle-right') }}</span> We <strong>put our heads together</strong>: on a daily basis to get our code working, weekly in our planning update or monthly for knowledge sharing and a company lunch. 
                                    Every six months we sit together to discuss your personal track and ambitions. Don't forget to bring a (reimbursed) present to the yearly Secret Santa dinner! 
                                </li>
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                    Grow together with a team that has <strong>made its name in open source</strong>, with more than 250.000.000 downloads of packages worldwide. 
                                    Spot your fellow team members as experts in user groups or conference speakers.
                                </li>
                            </ul>
                        </div>

                        <div class="mt-16">
                            <h3 class="title">And you?</h3>
                            <ul class="bullets bullets-green">
                                <li>
                                   <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                   You love the PHP + Laravel combo.
                                </li>
                                <li>
                                   <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                   You know Git. That's it.
                                </li>
                                <li>
                                   <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                   You don't run away from technologies in our <a href="#stack">tech stack</a>.
                                </li>
                                <li>
                                    <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                    You can work independently but aren't afraid to ask when you're stuck.
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
        @include('front.pages.vacancies.partials.cta', ['github' => true ])
    </div>

</x-page>
