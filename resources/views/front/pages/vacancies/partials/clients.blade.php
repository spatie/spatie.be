<h3 class="title">The best is yet to come</h3>
<p>
    We don't take on just any new project but only those where we all can learn something new.
    We love to work with the latest and greatest. Here are some examples of exciting stuff you could be working on:</p>
<ul class="bullets bullets-green">
    @if($profile == 'front' || $profile == 'back')
        <li>
            <span class="icon">{{ app_svg('icons/far-angle-right') }}</span>
            Business-critical apps for Tomorrowland and the rest of our worldwide client base
        </li>
        <li>
            <span class="icon">{{ app_svg('icons/far-angle-right') }}</span>
            In-house applications for the Laravel ecosystem,
            <a href="https://mailcoach.app" target="_blank" rel="noopener nofollow">Mailcoach</a> or
            <a href="https://flareapp.io" target="_blank" rel="noopener nofollow">Flare</a>
        </li>
    @endif
    @if($profile == 'front')
        <li>
            <span class="icon">{{ app_svg('icons/far-angle-right') }}</span>
            Build and maintain <a href="https://myray.app" target="_blank" rel="noopener nofollow">Ray</a>, an Electron-based debugging tool
        </li>
    @endif

    <li><span class="icon">{{ app_svg('icons/far-angle-right') }}</span> Our enormous collection of <a
                href="{{ route('open-source.packages') }}">open-source packages</a> and projects</li>
</ul>

<p>
    You'll have a say in what you'll be working on. No really, we áre listening.
    @if($profile == 'back')
        If you're curious to see how we work, these public <a href="https://spatie.be/guidelines">guidelines</a> could
        give you a first impression.
    @endif
    @if($profile == 'front')
        If you're curious to see what we create, check out a selection of work on <a href="https://spatie.be">our
            homepage</a>.
    @endif
</p>






