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
                            You have a good understanding of our primary target group: developers in the Laravel and PHP ecosystem, and you know what drives them. 
                        </li>
                        <li>
                            <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                            You have a strong opinion –loosely held– what makes a great digital product, how to grow it, and how to reach untapped potential.
                        </li>
                        <li>
                            <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                            You’re eager to dissect our products: spot the strengths and the shortcomings, and define strategies to communicate about these.
                        </li>
                        <li>
                            <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                            Writing positive, enthusiastic messages in a non-salesy way is natural for you. You like experimenting with marketing strategies and know how to measure results.
                        </li>
                        <li>
                            <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                            You know your way around Google Tag Manager, Google Analytics (or comparable), Facebook &amp; Twitter ads and tools like Hubspot or SharpSpring. 
                            We're open for any suggestion that fits your toolbox better.
                        </li>
                        <li>
                            <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                            Your English is spotless, given our international market.
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
