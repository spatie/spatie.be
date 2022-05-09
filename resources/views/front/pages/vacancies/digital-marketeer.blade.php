<x-page
        background="/backgrounds/jobs.jpg"
        title="Digital marketeer vacancy"
        description="Vacancy for a digital marketeer. Location: Antwerp."
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
	"title": "Digital Marketeer",
	"employmentType": "PART_TIME",
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
                Digital Marketeer
            </h1>
            <p class="mt-4">
                <span class="icon mr-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-left') }}</span> <a
                        href="{{ route('vacancies.index')}}" class="link-underline link-blue text-xl">Vacancies overview</a>
            </p>
        </div>
    </section>

    <div class="section section-group pt-0 section-fade">
        <section id="intro" class="section">
            @include('front.pages.vacancies.partials.about')
            
            <div class="wrap wrap-6">
                <div class="mt-16 sm:col-span-4 markup links-underline links-blue">
                    @include('front.pages.vacancies.partials.clients', ['profile' => 'marketing'])
                </div>
            </div>
            
            @include('front.pages.vacancies.partials.stagnation-decline', ['profile' => 'marketing']) 
                
            <div class="wrap wrap-6">
                <div class="sm:col-span-4 mt-16 markup links-underline links-blue">
                    <h3 class="title">And you?</h3>
                    <ul class="bullets bullets-green">
                        <li>
                            <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                            You're looking for a part-time job, optionally remote.
                        </li>
                        <li>
                            <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                            You know how to grow a digital product.
                        </li>
                        <li>
                            <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                            You can connect with our primary target group: developers in the Laravel ecosystem.
                        </li>
                        <li>
                            <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                            Yet you have a nose for untapped potential.
                        </li>
                        <li>
                            <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                            You can work independently and can formulate actionable campaigns.
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <section id="offer" class="section">
            @include('front.pages.vacancies.partials.offer', ['marketing' => true])
        </section>
    </div>

    <div class="section section-group">
        @include('front.pages.web-development.partials.stack')
        @include('front.pages.vacancies.partials.cta')
    </div>

</x-page>
