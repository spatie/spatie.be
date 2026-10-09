<x-services-process-page title="Research &amp; Analysis" phase="01" current="research-and-analysis" :sections="[
    'starting-point' => 'Every project starts somewhere different',
    'questions' => 'Time to ask questions',
    'input' => 'Bring everything you’ve got',
    'design' => 'Sketch it before we build it',
    'roadmap' => 'From notes to a roadmap',
]">
    <x-slot:heading>Research &amp;<br>Analysis</x-slot:heading>
    <x-slot:description>Before we write any code, we dig into your domain. Notes, wireframes, and many questions become a roadmap toward a strong foundation.</x-slot:description>
    <x-slot:intro>Kicking off a new project is intimidating. You show up with a stack of notes, documents, wireframes, and sketches. Before we touch any code, we dig into your domain and turn that stack into a roadmap to design, build, and ship.</x-slot:intro>

    <section id="starting-point" class="process-section">
        <h2>Every project starts somewhere different</h2>
        <p>A greenfield application needs a different approach than a rewrite of a tried and tested legacy application that's bursting at the seams. Some clients bring a bound book of detailed wireframes and documentation. Others bring a few rough notes. We're happy to work from either. It only changes how long this phase takes and how we approach it.</p>
    </section>

    <section id="questions" class="process-section">
        <h2>Time to ask questions</h2>
        <p>Sometimes a few short meetings are enough. Sometimes it takes several days of event-storming sessions. Either way, we start by asking:</p>
        <ul class="process-questions">
            <li>What are we building?</li>
            <li>Why are we building it? <span class="text-oss-gray-dark">(Especially important for rewrites.)</span></li>
            <li>What do you and your users like and dislike about the current application?</li>
            <li>Which features have the biggest impact on end users?</li>
            <li>Which features have the biggest impact on the technical architecture?</li>
            <li>What's critical for launch?</li>
        </ul>
    </section>

    <section id="input" class="process-section">
        <h2>Bring everything you've got</h2>
        <p>The more input, the better. We'll ask you for:</p>
        <ul>
            <li>User stories for the most common flows</li>
            <li>A list of the screens the application needs, as a guideline before we draw wireframes</li>
            <li>Your ideas on architecture and infrastructure, when we're consulting for your in-house technical team</li>
        </ul>
    </section>

    <section id="design" class="process-section">
        <h2>Sketch it before we build it</h2>
        <p>Wireframes make sure we're all picturing the same project. Depending on the complexity of the interface, that takes a round or two before we move on. For user-facing frontends, we also deliver visual designs: one screen for a simple interface, or many screens in various sizes for a complex one. We design in Figma, but we're happy to use other tools if you prefer.</p>
    </section>

    <section id="roadmap" class="process-section">
        <h2>From notes to a roadmap</h2>
        <p>We'll never know everything, and we don't need to. Once we know enough, we list and categorize your application's features and affordances, and group them into sprints that work toward a foundation.</p>
    </section>

    <aside class="process-callout">
        <h2>Known unknowns are fine. Unknown unknowns aren't.</h2>
        <p>Before we start building, we want to rule out surprises. Open questions are welcome, as long as they're written down on the roadmap.</p>
    </aside>

    <x-slot:next>
        <a class="process-next" href="{{ route('web-development.strong-foundation') }}">
            <span>Build a Strong Foundation</span><span aria-hidden="true">↗</span>
        </a>
    </x-slot:next>
</x-services-process-page>
