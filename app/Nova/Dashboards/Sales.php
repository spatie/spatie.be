<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\Earnings;
use App\Nova\Metrics\EarningsPerProduct;
use App\Nova\Metrics\EarningsPerProductPerDay;
use App\Nova\Metrics\EarningsPerProductPerMonth;
use App\Nova\Metrics\EarningsPerPurchasablePerDay;
use App\Nova\Metrics\EarningsPerPurchasablePerMonth;
use App\Nova\Metrics\PurchasesPerProduct;
use App\Nova\Metrics\PurchasesPerProductPerDay;
use App\Nova\Metrics\PurchasesPerProductPerMonth;
use App\Nova\Metrics\PurchasesPerPurchasablePerDay;
use App\Nova\Metrics\PurchasesPerPurchasablePerMonth;
use Laravel\Nova\Dashboard;

class Sales extends Dashboard
{
    public static function label()
    {
        return 'Sales';
    }

    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            new Earnings(),
            new PurchasesPerProduct(),
            new EarningsPerProduct(),
            PurchasesPerProductPerDay::create(),
            PurchasesPerPurchasablePerDay::create(),
            PurchasesPerProductPerMonth::create(),
            PurchasesPerPurchasablePerMonth::create(),
            EarningsPerProductPerDay::create(),
            EarningsPerPurchasablePerDay::create(),
            EarningsPerProductPerMonth::create(),
            EarningsPerPurchasablePerMonth::create(),
        ];
    }

    /**
     * Get the URI key for the dashboard.
     *
     * @return string
     */
    public static function uriKey()
    {
        return 'sales';
    }
}
