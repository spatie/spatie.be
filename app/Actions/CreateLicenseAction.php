<?php

namespace App\Actions;

use App\Models\License;
use App\Models\Purchasable;
use App\Models\Purchase;
use App\Models\PurchaseAssignment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CreateLicenseAction
{
    public function execute(PurchaseAssignment $assignment): License
    {
        return License::create([
            'key' => Str::random(64),
            'purchase_assignment_id' => $assignment->id,
            'expires_at' => $this->expiresAt($assignment->purchasable),
        ]);
    }

    protected function expiresAt(Purchasable $purchasable): Carbon
    {
        if ($purchasable->is_lifetime) {
            return Carbon::createFromFormat('Y-m-d H:i:s', '2038-01-19 00:00:00');
        }

        return now()->addYear();
    }
}
