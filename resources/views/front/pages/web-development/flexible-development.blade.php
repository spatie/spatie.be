<x-services-process-page title="Flexible Development" phase="03" current="flexible-development" :sections="[
    'small-steps' => 'From sprints to small steps',
    'backlog' => 'Now, next, later',
    'communication' => 'Always in the loop',
    'maintenance' => 'Built to keep going',
]">
    <x-slot:heading>Flexible<br>development</x-slot:heading>
    <x-slot:description>Once the foundation is in place, your priorities drive development. We work in small, achievable chunks, so changing course stays cheap.</x-slot:description>
    <x-slot:intro>Once the foundation is in place, ideas and opportunities start piling up. We'll likely change course once or twice as we all learn more about the software taking shape. That's fine. From here on, your priorities and the backlog drive development.</x-slot:intro>

    <section id="small-steps" class="process-section">
        <h2>From sprints to small steps</h2>
        <p>Planning sprints ahead of time has a downside: you end up with a waterfall of tasks that depend on each other. Rigid planning helps us stay focused early on. Once the foundation is solid, it becomes easier to carve a large body of work into small chunks we can finish one at a time.</p>
    </section>

    <section id="backlog" class="process-section">
        <h2>Now, next, later</h2>
        <p>Instead of spreading tasks across sprints, we sort them into three buckets:</p>
        <dl class="process-buckets">
            <div><dt>Now</dt><dd>What we're actively working on.</dd></div>
            <div><dt>Next</dt><dd>What we'll pick up in the short term.</dd></div>
            <div><dt>Later</dt><dd>Everything else. Low-priority features, and ideas we don't want to lose track of.</dd></div>
        </dl>
        <p>Everything in now and next is actionable and ready to work on. Tasks in later can still have plenty of unknowns. Once a week, we review what's done and decide what moves up from next and later.</p>
    </section>

    <aside class="process-callout">
        <h2>Changing your mind is cheap.</h2>
        <p>We stick to small, confined tasks instead of a long all-or-nothing path we can't step off. When priorities shift, switching costs little.</p>
    </aside>

    <section id="communication" class="process-section">
        <h2>Always in the loop</h2>
        <p>This rhythm starts on day one of the project:</p>
        <ul>
            <li><strong>Weekly status call</strong> at a fixed day and time, to review progress, ask questions, and choose priorities.</li>
            <li><strong>Shared Slack channel</strong> for quick questions in between.</li>
            <li><strong>Shared Asana project</strong> to follow progress asynchronously, with an agenda that keeps meetings short and focused.</li>
        </ul>
    </section>

    <section id="maintenance" class="process-section">
        <h2>Built to keep going</h2>
        <p>Accuse us of job protection, but our most successful projects are never finished.</p>
        <ul>
            <li><strong>Up to date:</strong> we regularly upgrade to the latest PHP, Laravel, and React versions. Staying current brings free performance improvements, higher productivity, easier maintenance, and stronger security.</li>
            <li><strong>Secure:</strong> we follow security best practices and keep track of security advisories for the technologies we use. For extensive penetration testing, we bring in partners from our network.</li>
            <li><strong>Monitored:</strong> depending on the project, we add extra backup strategies, run load tests, and set up monitoring and observability with tools like Flare, Sentry, Grafana, and Prometheus.</li>
        </ul>
    </section>

    <x-slot:next>
        <a class="process-next" href="#match">
            <span>It's time to talk</span><span aria-hidden="true">↗</span>
        </a>
    </x-slot:next>
</x-services-process-page>
