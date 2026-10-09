<x-services-process-page title="Build a Strong Foundation" phase="02" current="strong-foundation" :sections="[
    'foundation' => 'Shallow, but polished',
    'scope' => 'Just enough',
    'sprints' => 'Sprints with a goal',
    'technical' => 'Under the hood',
]">
    <x-slot:heading>Build a strong<br>foundation</x-slot:heading>
    <x-slot:description>A Laravel codebase built for the long haul. We build a shallow but polished foundation in focused sprints, with automated tests, code review, and deployments in place from day one.</x-slot:description>
    <x-slot:intro>The first stages of a project are a balancing act between building too little and building too much. We aim for a foundation: a Laravel codebase built for the long haul, for developers and agents, that doesn't fight you when requirements change.</x-slot:intro>

    <section id="foundation" class="process-section">
        <h2>Shallow, but polished</h2>
        <p>A foundation isn't always an MVP ready for launch. It's our checkpoint before we can plan and build features with more flexibility. Features still miss a lot of affordances, but the version of each feature that exists is complete.</p>
    </section>

    <aside class="process-callout">
        <h2>What that looks like</h2>
        <ul>
            <li><strong>A multi-tenant app:</strong> tenants exist in the architecture, but there's no overarching settings or reporting tool on day one.</li>
            <li><strong>A drawing app:</strong> if we can draw rectangles, we know how to add circles and triangles later. One shape is enough to start.</li>
            <li><strong>Most apps:</strong> not everything needs a UI yet. We can seed users in the database and add registration flows later.</li>
        </ul>
    </aside>

    <section id="scope" class="process-section">
        <h2>Just enough</h2>
        <p>Each feature gets fleshed out just enough to avoid sudden overhauls later. Deciding what counts as "just enough" is never easy, and it changes as we build and learn.</p>
        <ul class="process-mini-cards">
            <li><strong>Small surface, lots of complexity:</strong> we touch every feature to some degree before we call the foundation done.</li>
            <li><strong>Massive surface, many simple create/edit/delete screens:</strong> we hold off on most features that don't affect the rest of the codebase.</li>
        </ul>
    </section>

    <section id="sprints" class="process-section">
        <h2>Sprints with a goal</h2>
        <p>We split the work into sprints with specific goals and fill them with actionable tasks. A good sprint goal reads as "after this sprint, a user can…".</p>
        <ul>
            <li>A sprint isn't tied to a number of days or points. It's a chunk of work that makes sense to tackle together.</li>
            <li>Project goals and team size and shape decide how we lay sprints out. Sometimes the plan is linear. Sometimes team members work on separate chunks in parallel.</li>
            <li>Sprints can include non-development work too: wireframes, visual designs, or a closer look at specific business requirements.</li>
        </ul>
        <p>In this phase, the development team broadly decides the priorities. We're building an architectural foundation, not finished features with all the bells and whistles. That's why we're careful with scope changes here: they're the fastest way to start running in circles.</p>
    </section>

    <section id="technical" class="process-section">
        <h2>Under the hood</h2>
        <details class="process-details">
            <summary>The tools we build with</summary>
            <div>
                <p>On the backend, we almost always use Laravel and PHP. On the frontend, we prefer React or Livewire. We'll pick another framework when it's a better fit, or when the codebase will be maintained by an external team that's heavily invested in it.</p>
                <ul>
                    <li><strong>Standards:</strong> we follow established programming standards, sharpened with our own.</li>
                    <li><strong>Linting and formatting:</strong> Prettier, PHP CS Fixer, Laravel Pint, and PHPStan keep the codebase stable and consistent.</li>
                    <li><strong>Tests:</strong> mandatory, not optional. A mix of unit, integration, and end-to-end tests lets us ship with confidence.</li>
                </ul>
            </div>
        </details>
        <details class="process-details">
            <summary>A workflow that catches mistakes early</summary>
            <div>
                <ul>
                    <li>Every project lives in Git. We keep branching simple with a minimal take on Gitflow.</li>
                    <li>We have a strong code review culture, so technical debt and regressions don't sneak in with new features.</li>
                    <li>Code is merged and deployed only after it passes a pipeline of automated tests, code formatting, and build steps in GitHub Actions (or a similar tool like CircleCI or Travis CI).</li>
                </ul>
            </div>
        </details>
        <details class="process-details">
            <summary>Hosting that fits</summary>
            <div>
                <p>Your requirements decide where we deploy:</p>
                <ul>
                    <li>Containers on Docker or Kubernetes</li>
                    <li>Serverless on AWS with Laravel Vapor, optionally with Laravel Octane</li>
                    <li>Laravel Octane on FrankenPHP, for apps that need extra speed</li>
                    <li>Laravel Envoy or Envoyer on bare metal or virtual servers</li>
                    <li>Ansible for automated provisioning, when needed</li>
                </ul>
                <p>For most projects, we set up separate production and staging environments, so developers and stakeholders can try out new features before they go live.</p>
            </div>
        </details>
    </section>

    <x-slot:next>
        <a class="process-next" href="{{ route('web-development.flexible-development') }}">
            <span>Flexible Development</span><span aria-hidden="true">↗</span>
        </a>
    </x-slot:next>
</x-services-process-page>
