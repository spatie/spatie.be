<?php


namespace App\Exceptions;

use App\Models\Purchase;
use Exception;

class CouldNotRenewLicenseForPurchase extends Exception
{
    public static function make(Purchase $purchase)
    {
        return new self("Could not find a license to renew for purchase id `{$purchase->id}`");
    }
}
