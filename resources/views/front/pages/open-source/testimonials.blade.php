<x-page title="100 million downloads" background="/backgrounds/100-million.jpg"
        description="Celebrating 100.000.000 downloads">
    @once
        @push('scripts')
            <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        @endpush
    @endonce

    @include('front.pages.open-source.partials.menu')

    <section id="banner" role="banner" class="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Celebrating <br>100.000.000 downloads
            </h1>
            <p class="banner-intro">
                Testimonials from package users
            </p>
        </div>
    </section>

    <div class="wrap mb-12">
        <div class="markup links-underline links-blue">
            <p class="text-lg">
                In november 2020, we crossed the barrier of 100 million downloads of our open source packages. To
                celebrate this milestone, we asked people on Twitter to send in their testimonials on how they use our
                packages.
                <br>
                These 10 struck a chord with us and win a custom Spatie backpack!
            </p>
        </div>
    </div>

    <div id="testimonials" class="wrap" x-data="{ testimonial: 'tom' }"
         x-init="() => {
            const hash = location.hash.slice(1);
                if(['tom','axel','tim','christian', 'alladin', 'david', 'danyell', 'craig', 'jamie', 'samy'].includes(hash)){
                    testimonial = hash;
                }
            }">
        <div style="grid-template-columns: 4rem 1fr 4rem" class="lg:grid gap-16 | items-stretch links-blue">
            <div class="lg:-ml-16 lg:-mr-16 text-sm">
                <ul class="pb-8 lg:pt-12 grid grid-cols-2 lg:grid-cols-1 gap-2 sticky top-0">
                    <li>
                        <a class="flex items-center" href="#tom" @click="testimonial = 'tom'"
                           :class="{ 'font-semibold' : testimonial === 'tom' }">
                            Tom Witkowski
                            <span x-show="testimonial === 'tom'" class="ml-2 text-pink w-4 icon">
                                {{ app_svg('icons/fas-heart') }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center" href="#axel" @click="testimonial = 'axel'"
                           :class="{ 'font-semibold' : testimonial === 'axel' }">
                            Axel Charpentier
                            <span x-show="testimonial === 'axel'" class="ml-2 text-pink w-4 icon">
                                {{ app_svg('icons/fas-heart') }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center" href="#tim" @click="testimonial = 'tim'"
                           :class="{ 'font-semibold' : testimonial === 'tim' }">
                            Tim Sterker
                            <span x-show="testimonial === 'tim'" class="ml-2 text-pink w-4 icon">
                                {{ app_svg('icons/fas-heart') }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center" href="#christian" @click="testimonial = 'christian'"
                           :class="{ 'font-semibold' : testimonial === 'christian' }">
                            Christian Stefener
                            <span x-show="testimonial === 'christian'" class="ml-2 text-pink w-4 icon">
                                {{ app_svg('icons/fas-heart') }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center" href="#alladin" @click="testimonial = 'alladin'"
                           :class="{ 'font-semibold' : testimonial === 'alladin' }">
                            Alladin Melico
                            <span x-show="testimonial === 'alladin'" class="ml-2 text-pink w-4 icon">
                                {{ app_svg('icons/fas-heart') }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center" href="#david" @click="testimonial = 'david'"
                           :class="{ 'font-semibold' : testimonial === 'david' }">
                            David Hallin
                            <span x-show="testimonial === 'david'" class="ml-2 text-pink w-4 icon">
                                {{ app_svg('icons/fas-heart') }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center" href="#danyell" @click="testimonial = 'danyell'"
                           :class="{ 'font-semibold' : testimonial === 'danyell' }">
                            Danyell Noe
                            <span x-show="testimonial === 'danyell'" class="ml-2 text-pink w-4 icon">
                                {{ app_svg('icons/fas-heart') }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center" href="#craig" @click="testimonial = 'craig'"
                           :class="{ 'font-semibold' : testimonial === 'craig' }">
                            Craig Potter
                            <span x-show="testimonial === 'craig'" class="ml-2 text-pink w-4 icon">
                                {{ app_svg('icons/fas-heart') }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center" href="#jamie" @click="testimonial = 'jamie'"
                           :class="{ 'font-semibold' : testimonial === 'jamie' }">
                            Jamie Peters
                            <span x-show="testimonial === 'jamie'" class="ml-2 text-pink w-4 icon">
                                {{ app_svg('icons/fas-heart') }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center" href="#samy" @click="testimonial = 'samy'"
                           :class="{ 'font-semibold' : testimonial === 'samy' }">
                            Samy Nitsche
                            <span x-show="testimonial === 'samy'" class="ml-2 text-pink w-4 icon">
                                {{ app_svg('icons/fas-heart') }}
                            </span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="-mx-4 md:mx-0 bg-white shadow-lg text-lg markup markup-lists">
                <div id="tom" class="py-12 px-4 sm:px-8 md:py-24 md:px-16" x-show="testimonial === 'tom'">
                    <p>
                        Hey all at Spatie,

                    <p>
                        I just wanted to take the official chance to share my story with you.
                        <del>But please exclude me from the backpack giveaway.</del>
                        😉

                    <p>
                        My story with Spatie started ~5 years ago while I've started to introduce Laravel to my
                        colleagues as a replacement for CakePHP.
                        On top of using packages my real Story with Spatie and therefore the start of my current carrier
                        was in August 2016. So far I was able to filter the GitHub API this was my first interaction
                        with you <a class="break-all" href="https://github.com/spatie/laravel-google-calendar/issues/6">https://github.com/spatie/laravel-google-calendar/issues/6</a>
                        .

                    <p>
                        After this I've leveled up my PHP and Laravel skills by a thousand times. A big if not the
                        biggest part of this process were YOU (all devs at Spatie). I've learned a lot while
                        communicating with you, reading your code and adding my own code. After all I still assume that
                        Spatie made my career - or at least provided everything it needed. The packages you provide are
                        super valuable! But for me the chance to work with you is even more worth! 🚀 I still like the
                        deep discussions with Brent, the frontend knowledge Sebastian shares and the kindness between
                        developers Freek introduced me to.

                    <p>
                        For sure I'm super impressed by your total stats! 😱 And I'm proud of my part. 🎉
                        Until now I've pushed 903 commits to 33 packages and wrote 1185 comments in 754 issues. 🙈
                        In addition two of your packages allowed me to create three plugins and this year Alex trusted
                        me to take over one of your packages. 🙏

                    <p>
                        I can't thank you enough! 🤩 And hope that we will work together a lot more in the future.

                    <p>
                        best regards<br>
                        Tom Witkowski - <a href="https://twitter.com/devgummibeer">@devgummibeer</a>
                    </p>
                </div>

                <div id="axel" class="py-12 px-4 sm:px-8 md:py-24 md:px-16" x-show="testimonial === 'axel'">
                    <p>Hello Spatie!</p>

                    <p>My name is Axel, I work as a backend developer in a digital agency in Paris and I wanted to say a
                        big thank you for all your incredible work for the Laravel ecosystem.</p>

                    <p>At work, we use several of your packages, in particular laravel-permission and
                        laravel-medialibrary which allow us to do in a few minutes everything related to policies and
                        images on our clients' sites.</p>

                    <p>We also use laravel-backup on all our Laravel sites and are thinking about a new workflow with
                        laravel-backup-server to manage the backups of all our sites!</p>

                    <p>For my part, you have helped me enormously to progress. I didn't just use your packages, I also
                        looked at their source code, which allowed me to learn quite a bit.</p>

                    <p>Recently, I created two packages, one to allow my team to quickly start a Laravel project, it's a
                        simple Laravel command to install various presets (fortify, sanctum, nova, laravel-permission,
                        pest, graphql, etc.) and another one I'm still creating.<br>
                        This package allows you to set up a customizable onboarding interface. We have a particular need
                        on a project where Excel is no longer sufficient so I am trying to create this fairly large
                        package.
                    </p>

                    <p>Take care of yourself and good luck!</p>
                    <p>Axel Charpentier - <a href="https://twitter.com/TheDevGrizzly">@TheDevGrizzly</a></p>
                </div>

                <div id="tim" class="py-12 px-4 sm:px-8 md:py-24 md:px-16" x-show="testimonial === 'tim'">
                    <p>Hi spatie team,</p>

                    <p>this is about the Backpack giveaway but I also take the opportunity to thank you for your great
                        contribution to the laravel and php community & ecosystem.</p>

                    <p>Your packages helped me by</p>

                    <ul>
                        <li>providing well written baselines to compose complex applications</li>
                        <li>serve as a great example how open source can bring a whole ecosystem forward</li>
                        <li>serve as great inspiration on how to write & host quality documentation</li>
                        <li>serve as great example on how to write well architected & tested packages</li>
                        <li>inspired me to write my own packages (not quite there yet to open source, unfortunately)
                        </li>
                    </ul>

                    <p>Thanks for all the great work and for being such an integral part of the php/laravel
                        community!</p>

                    <p>Best,
                        <br>Tim - <a href="https://twitter.com/tsterker">@tsterker</a></p>
                </div>

                <div id="christian" class="py-12 px-4 sm:px-8 md:py-24 md:px-16" x-show="testimonial === 'christian'">
                    <p>Dear Spatie Team,</p>
                    <p>We just wanted to say thanks for your great work. In every project we use Spatie packages and we
                        can't get around it anymore. Be it fractal, failed-job-monitor or the media library.</p>

                    <p>With your help we can realize portals like wecreateyour.com or our internal production control.
                        We use the medialibrary for our custom 3D Preset files. <br>
                        Next year we plan to replace our Magento shop with a Vanilo.io based shop, where we also will
                        use a lot of spatie Package and the Medialibrary. This will be a huge advantage over the slow ,
                        expensive Magento experience. <br>
                        With your Dashboard Tutorial we will soon setup several monitors in our production to show our
                        employees which orders still have to be processed or how many packages we sent per day. We also
                        use your query builder in our projects, which allow us to filter advanced search queries for our
                        orders. In combination with the frontend tools this is a huge time saving.<br>
                        More about this may be available next year in our upcoming Tech Blog. We are looking forward to
                        your new book about PHP. Thanks for the great work, you help us to realize big projects with a
                        small team.<br>
                        We have violated the Postcardware so far and I apologize for that ;) We will do this after the
                        Christmas business.
                    </p>
                    <p>
                        Good luck for the next 100 Mio!
                    </p>
                    <p>Best Regards<br>
                        The LOOXIS developer team<br>
                        Christian Stefener - <a href="https://www.looxis.de">Looxis</a>
                    </p>
                </div>

                <div id="alladin" class="py-12 px-4 sm:px-8 md:py-24 md:px-16" x-show="testimonial === 'alladin'">
                    <p>Congratulations for the 100 millionth package downloads! I’m Alladin Melico, a Bachelor of
                        Science in Information Technology undergraduate, I used of one of Spatie’s packages of our
                        capstone research.
                    </p>
                    <p>
                        Hosted: <a class="break-all" href="https://laravel-film.herokuapp.com/">https://laravel-film.herokuapp.com/</a>
                        <br>
                        Repository: <a class="break-all" href="https://github.com/alladinmelico/laravel_movie">https://github.com/alladinmelico/laravel_movie</a>
                    </p>
                    <p>
                        The Spatie Laravel-Medialibrary definitely helped me on setting up photo uploading, validation,
                        retrieving media and so much more. I know that this is a relatively small project but
                        medialibrary saved so much of my time. Thank you!
                    </p>
                </div>

                <div id="david" class="py-12 px-4 sm:px-8 md:py-24 md:px-16" x-show="testimonial === 'david'">
                    <p class="text-xl">
                        The biggest impact your packages have had on me is education. I use them in my projects as well,
                        but many packages I just pulled down for fun/exploration, and it resulted in massive increases
                        in my understanding of how laravel works and better coding practices.
                    </p>
                    <p>
                        David Hallin – <a href="https://twitter.com/david_hallin">@david_hallin</a>
                    <p>
                </div>

                <div id="danyell" class="py-12 px-4 sm:px-8 md:py-24 md:px-16" x-show="testimonial === 'danyell'">
                    <p class="text-xl">
                        If you use no
                        @@spatie_be
                        packages, isn't your
                        @@laravelphp
                        project just a hobby?
                    </p>
                    <p class="text-xl">
                        My most frequently used:
                    </p>
                    <ul class="text-xl">
                        <li>laravel-permission</li>
                        <li>laravel-activitylog</li>
                        <li>laravel-sluggable</li>
                        <li>laravel-analytics</li>
                    </ul>
                    <p class="text-xl">
                        Also, @@freekmurze has always been so nice / approachable at @@LaraconUS.
                        <br>Thanks guys!
                    </p>
                    <p>
                        Danyell Noe – <a href="https://twitter.com/danyellnoe">@DanyellNoe</a>
                    <p>
                </div>

                <div id="craig" class="py-12 px-4 sm:px-8 md:py-24 md:px-16" x-show="testimonial === 'craig'">
                    <p class="text-xl">
                        I don't think there has been a project I have worked on in the last year that hasn't used at
                        least 1 @@spatie_be package. I love how you guys make everything so simple and easy to implement
                        so I don't have to worry about it and I can focus on getting the rest of the project done!
                    </p>
                    <p>
                        Craig Potter – <a href="https://twitter.com/_CPotter">@_CPotter</a>
                    <p>
                </div>

                <div id="jamie" class="py-12 px-4 sm:px-8 md:py-24 md:px-16" x-show="testimonial === 'jamie'">
                    <p class="text-xl">
                        My current big project uses the geocoder package to get lat/lng from a town/city/postcode, a
                        nice php api instead calling Google directly. Mailcoach is great for bringing newsletter
                        management in house, and test time is another favourite for testing time specific artisan
                        commands.
                    </p>
                    <p class="text-xl">
                        All the ones I've used in my projects just saves time, I've got plans for the backup tool when
                        my project launches, and no doubt there'll be others there when I need them, if you need it,
                        there's a good chance the guys at Spatie have already got it covered!
                    </p>
                    <p>
                        Jamie Peters – <a href="https://twitter.com/jpeters8889">@jpeters8889</a>
                    <p>
                </div>

                <div id="samy" class="py-12 px-4 sm:px-8 md:py-24 md:px-16" x-show="testimonial === 'samy'">
                    <p class="text-xl">
                        Congratulations 🎈 Your packages really changed the way I work. When I need some functionality
                        the first thing I do is checking out your packages to see if this already exists. Also I learned
                        so much techniques from you. Thanks for everything!
                    </p>
                    <p>
                        Samy Nitsche – <a href="https://twitter.com/samynitsche">@samynitsche</a>
                    <p>
                </div>
            </div>
        </div>
    </div>

    <section class="section">
        @include('front.pages.open-source.partials.support')
    </section>
</x-page>
