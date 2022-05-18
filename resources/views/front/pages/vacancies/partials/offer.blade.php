<section class=section>
    <div class="wrap wrap-6 items-center">
        <div class="sm:col-span-3">
            <div class="markup links-underline links-blue">
               <h2 class="title-2xl">Our offer
                </h2>
                
                <ul class="bullets bullets-green">
                    @unless($marketing ?? false)
                        <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> A full-time position in a fostering environment</li>
                        <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> A renumeration package with a competitive salary and extras tailored to your personal needs: eg. an e-bike, bike allowance, hardware, internet at home, pension plan, additional holidays …</li>
                        <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Health insurance</li>
                        <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Meal and Eco vouchers</li>
                        <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Velo card for public bikes in Antwerp</li>
                        <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Apple laptop + second screen, most recent iPhone or Android smartphone</li>
                        <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Bose noise-cancelling headphones</li>
                        <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Any software you prefer or need</li>
                    @else
                        <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> A <strong>part-time contract</strong>, as an employee or freelancer.
                            <br>Starting with a regime of 8–10 hours per week, with potential to grow in the future.</li>
                        <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Work on location in Antwerp, partially from home or even <strong>fully remote</strong>.</li>
                        <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> A renumeration package with a competitive salary and optional extras tailored to your personal needs.</li>
                        <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Any software you prefer or need.</li>
                        <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> You may start immediately.</li>

                        @endif
                </ul>

                @unless($marketing ?? false)
                <h3 class="mt-16 title">Extras that will feel familiar quickly</h3>

                <ul class="bullets bullets-green">
                    <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Partially remote work to help you get in the zone or combine work and family</li>
                    <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> A modern office in the centre of Antwerp, right in between 2 train stations</li>
                    <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Standing desks and a roof terrace</li>
                    <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> A genuine drive to learn from each other: code reviews, in-house presentations and chit-chat on Slack</li>
                    <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> A flat company structure where you can make a clear difference</li>
                    <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> <a href="https://www.kiva.org" target="_blank" rel="nofollow noreferrer noopener">Kiva</a> budget for micro-loans</li>
                    <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Authentic espresso &amp; fresh fruit in the office</li>
                    <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Board game evenings for those who like to play</li>
                    <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Monthly Italian lunch with the team; wine from a chicken jug</li>
                </ul>
              
                <p class="mt-6 text-sm text-gray">
                        We are not looking into full-time remote work or relocation.
                        <br>
                        You may start immediately.
                    </p>
                @endif
            </div>
        </div>
        <div class="hidden | sm:block sm:col-span-3 sm:col-start-4">
            <div class="ml-24 w-full h-0" style="padding-bottom: 75%">
                <div class="absolute inset-0 illustration h-full" title="Team">
                    {{ image('vacancies/about-3.jpg') }}
                </div>
            </div>
        </div>
    </div>
</section>
