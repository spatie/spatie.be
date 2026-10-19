<x-agency-banner
    color="yellow"
    :ref="$ref ?? 'spatie-docs'"
    :thin="$thin ?? false"
    class="{{ $class ?? '' }}"
>
    <div class="agency-banner-logos" role="img" aria-label="Laravel, React and Livewire">
        <span>{{ app_svg('laravel') }}</span>
        <span>{{ app_svg('react') }}</span>
        <span>{{ app_svg('livewire') }}</span>
    </div>
    <div class="agency-banner-body">
        <p class="agency-banner-title">Tailor&#8209;made web dev</p>
        <p class="agency-banner-text">Laravel, React &amp; Livewire specialists using AI to speed up our development.</p>
    </div>
</x-agency-banner>
