<?php

namespace App\Nova\Actions;

use App\Domain\Shop\Models\License;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Nova\Actions\DestructiveAction;
use Laravel\Nova\Fields\ActionFields;

class RegenerateLicenseKeyAction extends DestructiveAction
{
    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(function (License $license) {
            $license->update([
                'key' => Str::random(64),
            ]);
        });
    }
}
