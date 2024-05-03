<?php

namespace App\Guidelines;

use Illuminate\Support\Collection;
use Spatie\Sheets\Sheets;

class ResolveGuidelinesAction
{
    public function execute(bool $refresh = false): Collection
    {
        if ($refresh) {
            cache()->forget('guidelines');
        }

        return cache()->rememberForever('guidelines', function () {
            return app(Sheets::class)->collection('guidelines')->all()->sortBy('weight');
        });
    }
}
