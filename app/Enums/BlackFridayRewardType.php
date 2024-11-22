<?php

namespace App\Enums;

enum BlackFridayRewardType: string
{
    case NextPurchaseDiscount = 'next_purchase_discount';
    case Mailcoach50Off = '50_off_mailcoach';
    case Flare50Off = '50_off_flare';
    case FreeMerch = 'free_merch';
    case FreeRay = 'free_ray';

    public function requiresSaasCode(): bool
    {
        return in_array($this, [
            self::Mailcoach50Off,
            self::Flare50Off,
        ]);
    }

    public function wonLabel(): string
    {
        return match ($this) {
            self::NextPurchaseDiscount => 'A coupon for 20% off your next purchase on spatie.be:',
            self::Mailcoach50Off => 'A coupon for 50% off your Mailcoach plan for 3 months (new customers only):',
            self::Flare50Off => 'A coupon for 50% off any Flare plan for 3 months (new customers only):',
            self::FreeMerch => 'A free piece of Spatie merch, we will contact you to get your details',
            self::FreeRay => 'A free yearly Ray license, we will contact you to get your details',
        };
    }
}
