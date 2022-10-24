<?php

use App\Support\Search\DocsVersion;

beforeEach(function() {
    $this->url = 'https://spatie.be.test/docs/browsershot/v2/miscellaneous-options/disable-sandboxing';
});

it('can get the version from an url', function() {
    expect(DocsVersion::getVersion($this->url))->toBe('v2');
});

it('can get the repo from an url', function() {
    expect(DocsVersion::getRepo($this->url))->toBe('browsershot');
});
