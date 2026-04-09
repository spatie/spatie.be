<x-section-glow color="#B21E4E" position="top-right" class="w-full max-w-[1320px] mx-auto">
    <h2 class="font-druk uppercase text-white text-[40px] sm:text-[72px] leading-[0.9] mb-10">Building for<wbr/> the AI era</h2>

    <p class="text-lg max-w-[640px] mb-12">
        We don't just use AI tools. We build them. Our open source packages help Laravel developers work better with AI, and that same expertise goes into every client project.
    </p>

    <div class="grid sm:grid-cols-2 gap-x-12 gap-y-16">
        <div>
            <h3 class="text-lg md:text-2xl font-bold text-white mb-4">AI coding guidelines</h3>
            <p class="text-oss-gray">We converted our PHP and Laravel coding standards into AI-friendly guidelines. Coding agents that follow these guidelines produce code matching our style from the first prompt. Published openly for the community.</p>
            <a class="inline-flex items-center gap-x-2 mt-4 underline hover:text-white" href="{{ url('guidelines') }}">
                <svg class="w-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
                <span>View our guidelines</span>
            </a>
        </div>

        <div>
            <h3 class="text-lg md:text-2xl font-bold text-white mb-4">Markdown responses for AI</h3>
            <p class="text-oss-gray">Our laravel-markdown-response package serves clean markdown to AI agents instead of bloated HTML. Fewer tokens, faster processing, lower costs.</p>
            <a class="inline-flex items-center gap-x-2 mt-4 underline hover:text-white" href="https://github.com/spatie/laravel-markdown-response" target="_blank">
                <svg class="w-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
                <span>View on GitHub</span>
            </a>
        </div>

        <div>
            <h3 class="text-lg md:text-2xl font-bold text-white mb-4">llms.txt</h3>
            <p class="text-oss-gray">We support the llms.txt standard to make documentation and content accessible to AI agents. We can set this up for your project too.</p>
            <a class="inline-flex items-center gap-x-2 mt-4 underline hover:text-white" href="{{ url('llms.txt') }}">
                <svg class="w-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
                <span>View our llms.txt</span>
            </a>
        </div>

        <div>
            <h3 class="text-lg md:text-2xl font-bold text-white mb-4">MCP and AI integrations</h3>
            <p class="text-oss-gray">We practice what we preach. <a class="underline" href="https://flareapp.io">Flare</a>, our error tracker, ships with an MCP server and a Claude Code skill so AI agents can diagnose errors and review performance directly. <a class="underline" href="https://myray.app">Ray</a>, our debugging tool, includes AI-powered features to help developers work faster.</p>
        </div>
    </div>
</x-section-glow>
