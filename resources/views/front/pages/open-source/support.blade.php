<x-page
        title="Support us"
        background="/backgrounds/open-source.jpg"
        description="Learn how to support us via our paid products or via GitHub sponsors."
>

    @include('front.pages.open-source.partials.banner-support')

    <div class="section-group pt-0">
        <section id="resources" class="section">
            <div class="wrap">
                <div class="markup links-underline links-blue">
                    
                    <div class="mb-16 inset-blue">
                        <div class="wrap-inset md:items-center" style="--cols: 1fr">
                            <ul class="grid gap-4 links-blue links-underline bullets bullets-blue">
                                <li>
                                    <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                    <a class="text-xl font-sans-bold" href="https://laravel-beyond-crud.com">
                                        Laravel Beyond CRUD</a>
                                    <br><span class="text-base">Learn how to build larger-than-average Laravel applications 
                                        and maintain them for years to come.<br>
                                       Coming <strong>September 2020</strong>.</span>
                                </li>
                                <li>
                                    <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                    <a class="text-xl font-sans-bold" href="https://laravelpackage.training">
                                        Laravel Package Training</a>
                                    <br><span class="text-base">Become the next package maestro. 
                                        <br>
                                        Learn how to build reusable components like we build them.<br>
                                        For only <strong>$79</strong>.</span>
                                </li>
                                <li>
                                    <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                    <a class="text-xl font-sans-bold" href="https://mailcoach.app/register">
                                        Mailcoach.app</a>
                                    <br><span class="text-base">Self-host your email newsletter campaigns. 
                                        <br>
                                        Includes <a href="https://mailcoach.app/videos">a video course</a> on how to improve your Laravel skills.<br>
                                        For only <strong>$149</strong>.</span>
                                </li>
                                <li>
                                    <span class="icon">{{ svg('icons/far-angle-right') }}</span> 
                                    <a class="text-xl font-sans-bold" href="https://flareapp.io/register">Flareapp.io</a>
                                    <br>
                                    <span class="text-base">Error tracker for Laravel, made together with <a href="https://beyondco.de" target="_blank" rel="nofollow noreferrer noopener">Beyondco.de</a>
                                    <br>
                                    From <strong>$29/Mo</strong>.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> 

            <div class="wrap">
                <div class="markup links-underline links-blue">
                    <p class="text-lg">
                        The easiest way to support us financially is by buying or subscribing to one of our paid products.
                        We tried to put as much love into these as in our open source work—and we hope it shows.
                    </p>
                    <p class="text-lg">
                        You can help with our open source efforts in many ways: by resolving <a href='https://github.com/issues?q=is%3Aopen+is%3Aissue+user%3Aspatie+is%3Apublic+label%3A%22good+first+issue%22'
                        class="link-black">open issues</a> or just by sending us a <a href="{{ route('open-source.postcards') }}">postcard</a>. An easy way to send us a postcard is via <a href="https://spatie.cards">spatie.cards</a>.
                    </p>
                </div>

            </div>
        </section>

        <section class="section">
            @include('front.pages.open-source.partials.donations')
        </section>
    </div>
</x-page>
