<?php

namespace App\Nova\Actions;

use App\Domain\Shop\Models\Purchasable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;

class UpdatePriceForCurrencyAction extends Action
{
    use InteractsWithQueue;
    use Queueable;

    public $name = 'Update prices for currency';

    public function handle(ActionFields $fields, Collection $models)
    {
        if ($fields->currency_code === 'USD') {
            Action::message('You should define the USD price on the purchasable itself');

            return;
        }

        $models->each(function (Purchasable $purchasable) use ($fields) {
            $purchasable
                ->prices()
                ->where('currency_code', $fields->currency_code)
                ->update([
                    'amount' => $fields->amount_in_cents,
                    'overridden' => true,
                ]);
        });

        Action::message('Price updated!');
    }

    public function fields()
    {
        return [
            Number::make('Amount in cents'),

            Text::make('Currency code'),
        ];
    }
}
