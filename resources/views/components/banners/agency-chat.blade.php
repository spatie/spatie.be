<x-agency-banner
    color="green"
    :ref="$ref ?? 'spatie-docs'"
    :thin="$thin ?? false"
    class="{{ $class ?? '' }}"
>
    <div class="agency-banner-chat">
        <div class="agency-banner-message agency-banner-message-client">
            <div class="agency-banner-avatar" aria-hidden="true"></div>
            <p class="agency-banner-bubble">We're building a Laravel app and need help with our API, front end and AI features. Any help?</p>
        </div>
        <div class="agency-banner-message agency-banner-message-spatie">
            <div class="agency-banner-avatar" aria-hidden="true">S</div>
            <p class="agency-banner-bubble">That's exactly what we do! Our Laravel, React &amp; Livewire experts would love to take a look.</p>
        </div>
    </div>
</x-agency-banner>
