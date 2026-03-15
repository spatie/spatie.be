<x-section-glow color="#50E69B" position="top-right" class="w-full max-w-[1320px] mx-auto">
    <h2 class="font-druk uppercase text-white text-[40px] sm:text-[72px] leading-[0.9] mb-10">Building for<wbr/> the AI era</h2>

    <p class="text-lg max-w-[640px] mb-12">
        We don't just use AI tools. We build them. Our open source packages help Laravel developers work better with AI, and that same expertise goes into every client project.
    </p>

    <div class="grid sm:grid-cols-2 gap-8">
        <x-oss-link-card title="AI coding guidelines" href="{{ url('guidelines') }}" link="View our guidelines">
            We converted our PHP and Laravel coding standards into AI-friendly guidelines. Coding agents that follow these guidelines produce code matching our style from the first prompt. Published openly for the community.
        </x-oss-link-card>

        <x-oss-link-card title="Markdown responses for AI" href="https://github.com/spatie/laravel-markdown-response" link="View on GitHub" target="_blank">
            Our laravel-markdown-response package serves clean markdown to AI agents instead of bloated HTML. Fewer tokens, faster processing, lower costs.
        </x-oss-link-card>

        <x-oss-link-card title="llms.txt" href="{{ url('llms.txt') }}" link="View our llms.txt">
            We support the llms.txt standard to make documentation and content accessible to AI agents. We can set this up for your project too.
        </x-oss-link-card>

        <x-oss-link-card title="MCP and AI integrations">
            We practice what we preach. <a class="underline" href="https://flareapp.io">Flare</a>, our error tracker, ships with an MCP server and a Claude Code skill so AI agents can diagnose errors and review performance directly. <a class="underline" href="https://myray.app">Ray</a>, our debugging tool, includes AI-powered features to help developers work faster.
        </x-oss-link-card>
    </div>
</x-section-glow>
