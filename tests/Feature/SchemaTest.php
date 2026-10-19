<?php

use App\Models\Member;
use App\Services\Schema\Schema;

it('keeps member websites separate from social profiles without exposing private emails', function (?string $twitter, ?string $github, array $profiles) {
    $member = Member::factory()->make([
        'first_name' => 'Sebastian',
        'last_name' => 'De Deyne',
        'role' => 'Developer',
        'website' => 'https://sebastiandedeyne.com',
        'twitter' => $twitter,
        'github' => $github,
        'email' => 'sebastian@spatie.be',
        'public_email' => false,
    ]);

    $schema = $member->schema()->toArray();

    expect($schema['name'])->toBe('Sebastian De Deyne')
        ->and($schema['jobTitle'])->toBe('Developer')
        ->and($schema['url'])->toBe('https://sebastiandedeyne.com')
        ->and($schema['sameAs'])->toBe($profiles)
        ->and($schema)->not->toHaveKey('email');
})->with([
    'both profiles' => ['sebdedeyne', 'sebastiandedeyne', ['https://x.com/sebdedeyne', 'https://github.com/sebastiandedeyne']],
    'only GitHub' => [null, 'sebastiandedeyne', ['https://github.com/sebastiandedeyne']],
    'only Twitter' => ['sebdedeyne', null, ['https://x.com/sebdedeyne']],
    'no profiles' => [null, null, []],
]);

it('includes company social profiles and member schemas in the organization', function () {
    Member::factory()->create([
        'first_name' => 'Freek',
        'last_name' => 'Van der Herten',
        'founder' => true,
        'website' => null,
        'twitter' => null,
        'github' => 'freekmurze',
        'email' => 'freek@spatie.be',
        'public_email' => true,
    ]);

    $schema = app(Schema::class)->organization()->toArray();

    expect($schema['sameAs'])->toContain('https://bsky.app/profile/spatie.be', 'https://www.instagram.com/spatie_be')
        ->and($schema['founders'][0]['name'])->toBe('Freek Van der Herten')
        ->and($schema['founders'][0]['sameAs'])->toBe(['https://github.com/freekmurze'])
        ->and($schema['founders'][0]['email'])->toBe('freek@spatie.be')
        ->and($schema['founders'][0])->not->toHaveKey('url');
});
