<?php

namespace App\Http\Controllers;

use App\Domain\Shop\Models\License;
use Illuminate\Support\Str;

class RegenerateLicenseKeyController
{
    public function __invoke(License $license)
    {
        if (! $license->isAssignedTo(current_user())) {
            abort(403, "License {$license->id} is not assigned to user id" . current_user()->id);
        }

        $license->update([
            'key' => Str::random(64),
        ]);

        flash()->success('License key regenerated.');

        return redirect()->back();
    }
}
