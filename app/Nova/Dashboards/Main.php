<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\Earnings;
use App\Nova\Metrics\EarningsPerProduct;
use App\Nova\Metrics\EarningsPerProductPerDay;
use App\Nova\Metrics\EarningsPerProductPerMonth;
use App\Nova\Metrics\EarningsPerPurchasablePerDay;
use App\Nova\Metrics\EarningsPerPurchasablePerMonth;
use App\Nova\Metrics\NewUsers;
use App\Nova\Metrics\PaymentMethods;
use App\Nova\Metrics\PaymentMethodsLastMonth;
use App\Nova\Metrics\PurchasesPerProduct;
use App\Nova\Metrics\PurchasesPerProductPerDay;
use App\Nova\Metrics\PurchasesPerProductPerMonth;
use App\Nova\Metrics\PurchasesPerPurchasablePerDay;
use App\Nova\Metrics\PurchasesPerPurchasablePerMonth;
use Laravel\Nova\Dashboard;

class Main extends Dashboard
{
    public function cards()
    {
        return [
            new NewUsers(),
            new Earnings(),
            new PurchasesPerProduct(),
            new EarningsPerProduct(),
            new PaymentMethods(),
            new PaymentMethodsLastMonth(),
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
}
