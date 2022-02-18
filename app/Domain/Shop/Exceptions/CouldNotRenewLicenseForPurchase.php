<?php

namespace App\Domain\Shop\Exceptions;

use App\Domain\Shop\Models\Purchase;
use Exception;

class CouldNotRenewLicenseForPurchase extends Exception
{
    public static function make(Purchase $purchase)
    {
        return new self("Could not find a license to renew for purchase id `{$purchase->id}`");
    }
}
