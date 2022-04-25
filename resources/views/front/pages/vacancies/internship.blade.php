<x-page
        title="Internship"
        background="/backgrounds/internship.jpg"

>
    <x-slot name="description">
        We are looking for interns in the field of digital design and development. Location: Antwerp.
    </x-slot>

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Internships <br>in Antwerp
            </h1>
            <p class="mt-4">
                <span class="icon mr-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-left') }}</span> <a
                        href="{{ route('vacancies.index')}}" class="link-underline link-blue">Vacancies overview</a>
            </p>
        </div>
    </section>

    <div class="section section-group pt-0">
        <section id="intro" class="section">
            <div class="wrap wrap-6">
                <div class="sm:col-span-4">
                    <div class="markup links-underline links-blue">
                        <h3 class="title">Backend, frontend or full-stack student?</h3>
                        <p class="text-lg">
                            We'd like to meet you. During an internship, you'll be working on actual client projects,
                            open source components or side projects. You learn from our daily routine, and we get
                            triggered by your fresh insights. 
                        </p>

                        <p class="text-lg">
                            We are looking for internships with a minimum duration of <strong
                                    class="whitespace-no-wrap">8 weeks</strong>.
                        </p>

                        <div class="mt-16">
                            <h3 class="title">Spatie</h3>
                            <p>We are architects and builders, tinkering on the front line; an open-source mastodon operated by a highly talented bunch the size of a soccer team.
                                We purposefully keep the company small but knowledgeable.
                            </p>
                            <p>
                            What does this bring to you? Learn and grow fast in a respectful, almost familiar environment. Yet you'll have an enormous impact on users worldwide.
                            Who knows you'll stick with us! 
                            </p>
                            <p>Rest assured: there will be laughs and great food along the way.</p>
                        </div>

                        <div class="mt-16">
                            @include('front.pages.vacancies.partials.clients', ['profile' => 'front'])
                        </div>

                        <div class="mt-16">
                            <h3 class="title">First rule: stagnation means decline</h3>
                            <ul class="bullets bullets-green">
                                <li>
                                    <span class="icon">{{ svg('icons/far-angle-right') }}</span>
                                    There is a strong mentality to stay on top of things: through Slack, in-house presentations or conferences.
                                    Spend <strong>half a day each week</strong> on experiments and open source work.
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
                                   You are a student in web development or web design looking for a valuable internship. 
                                </li>
                                <li>
                                    <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                    You don't run away from technologies in our <a href="#stack">tech stack</a> below.
                                 </li>
                                <li>
                                    <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                    You love to play with new technologies, try out new things that won't make production or tinker on your secret side project.
                                </li>
                                <li>
                                    <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                    You know Git. That's it.
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

                            
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>

        @include('front.pages.web-development.partials.stack')
        @include('front.pages.vacancies.partials.cta', ["github" => true])

    </div>

</x-page>
