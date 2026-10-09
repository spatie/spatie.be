<?php

it('links each services phase to its detail page', function () {
    $this->get(route('web-development'))
        ->assertOk()
        ->assertSee(route('web-development.research-and-analysis'), false)
        ->assertSee(route('web-development.strong-foundation'), false)
        ->assertSee(route('web-development.flexible-development'), false);
});

it('renders the process page with its content and onward link', function (string $phase, string $title, string $content, string $next) {
    $this->get(route('web-development.'.$phase))
        ->assertOk()
        ->assertSee('<title>'.$title.' | Spatie</title>', false)
        ->assertSeeText($content)
        ->assertSee('href="'.($next === '#match' ? $next : url($next)).'"', false)
        ->assertSee('id="match"', false);
})->with([
    'research' => ['research-and-analysis', 'Research &amp; Analysis', 'Known unknowns are fine.', '/web-development/strong-foundation'],
    'foundation' => ['strong-foundation', 'Build a Strong Foundation', 'A multi-tenant app:', '/web-development/flexible-development'],
    'development' => ['flexible-development', 'Flexible Development', 'This rhythm starts on day one', '#match'],
]);
