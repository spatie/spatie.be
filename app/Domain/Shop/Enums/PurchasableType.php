<?php

namespace App\Domain\Shop\Enums;

use MyCLabs\Enum\Enum;

/** @psalm-immutable */
class PurchasableType extends Enum
{
    public const TYPE_STANDARD = 'standard';
    public const TYPE_STANDARD_RENEWAL = 'standard-renewal';
    public const TYPE_UNLIMITED_DOMAINS = 'unlimited-domains';
    public const TYPE_UNLIMITED_DOMAINS_RENEWAL = 'unlimited-domains-renewal';
    public const TYPE_VIDEOS = 'videos';

    private static array $labelMap = [
        self::TYPE_STANDARD => 'Standard',
        self::TYPE_STANDARD_RENEWAL => 'Standard renewal',
        self::TYPE_UNLIMITED_DOMAINS => 'Unlimited domains',
        self::TYPE_UNLIMITED_DOMAINS_RENEWAL => 'Unlimited domains renewal',
        self::TYPE_VIDEOS => 'Videos',
    ];

    public static function getLabels(): array
    {
        return self::$labelMap;
    }
}
