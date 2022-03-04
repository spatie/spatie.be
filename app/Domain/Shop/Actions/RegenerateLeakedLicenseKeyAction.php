<?php

namespace App\Domain\Shop\Actions;

use App\Domain\Shop\Models\License;
use App\Mail\LeakedLicenseKeyRegeneratedMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegenerateLeakedLicenseKeyAction
{
    public function execute(License $license, string $foundOnUrl)
    {
        $license->update([
            'key' => Str::random(64),
        ]);

        Mail::to($license->assignment->user->email)->queue(
            new LeakedLicenseKeyRegeneratedMail($license, $foundOnUrl)
        );

        Log::channel('slack')->info("🙅‍♂️ Regenerating license id {$license->id} found on {$foundOnUrl}");
    }
}
