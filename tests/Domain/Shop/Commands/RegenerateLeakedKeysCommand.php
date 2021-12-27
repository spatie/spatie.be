<?php

it('can find a leaked key', function() {
    $searchResult = test()->getJsonStubContent('leakedKey.json');

    //(new \App\Console\Commands\RegenerateLeakedKeysCommand())->processResult($searchResult);
});
