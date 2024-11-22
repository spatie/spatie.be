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
            self::NextPurchaseDiscount => 'Use the next coupon to get 20% discount on your next purchase on spatie.be:',
            self::Mailcoach50Off => 'Use the next coupon to get 50% off Mailcoach plan:',
            self::Flare50Off => 'Use the next coupon to get 50% off Flare plan:',
            self::FreeMerch => 'A free piece of Spatie merch, we will contact you to get your details',
            self::FreeRay => 'A free yearly Ray license, we will contact you to get your details',
        };
    }
}
