@php
    
    $profile = $profile ?? '';

@endphp

<div class="sm:mt-16 wrap wrap-6 items-center">
    <div class="sm:col-span-3">
        <div class="sm:-ml-24 sm:mr-24 illustration" title="Team">
            {{ image('vacancies/about.jpg') }}
        </div>
    </div>

    <div class="sm:col-span-3 sm:col-start-4 markup links-underline links-blue">
        <h3 class="title">First rule: stagnation means decline</h3>
        <ul class="bullets bullets-green">
            <li>
                <span class="icon">{{ svg('icons/far-angle-right') }}</span>
                There is a strong mentality to stay on top of things: through Slack, in-house presentations or conferences.
                Spend <strong>half a day each week</strong> on experiments and open source work.
            </li>
            @if($profile == 'front')
            <li>
                <span class="icon">{{ svg('icons/far-angle-right') }}</span>
                Get €1500,- <strong>extra budget</strong> every year for personal growth. Spend it on books, courses and conferences (including train rides, hotels) like
                dotJS/dotCSS, nordic.JS, Frontend United.
            </li>
            @endif
            @if($profile == 'back')
            <li>
                <span class="icon">{{ svg('icons/far-angle-right') }}</span>
                Get €1500,- <strong>extra budget</strong> every year for personal growth. Spend it on books, courses and conferences (including train rides, hotels) like
                Laracon EU and US, DDD Europe, PHP Benelux, PHPUKConference, DPC, PHPDay ...
            </li>
            @endif
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
</div>
