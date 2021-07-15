<section id="banner" class="banner" role="banner">
    <div class="wrap">
        <h1 class="banner-slogan">
            Our technology <br>stack
        </h1>
        <p class="banner-intro">
            Tools to get our work done, at home or in the office
        </p>
        <p class="mt-4 links-underline links-blue space-x-2">
            @foreach (\App\Models\Enums\TechnologyType::toLabels() as $type => $label)
                <a href="#{{ $type }}">{{ $label }}</a>
                <span class="char-separator">|</span>
            @endforeach
        </p>
    </div>
</section>
