<?php

namespace App\Nova;

use App\Domain\Shop\Models\Purchase as EloquentPurchase;
use App\Nova\Actions\TransferPurchasesAction;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Purchase extends Resource
{
    public static $group = "Sales";

    public static $tableStyle = 'tight';

    public static $model = EloquentPurchase::class;

    //public static $title = 'title';

    public static $search = [
        'id',
    ];

    public static $with = ['assignments.user', 'bundle', 'purchasable'];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('User'),
            BelongsTo::make('Purchasable')->hideFromIndex(),
            BelongsTo::make('Bundle')->hideFromIndex(),

            Text::make('Bought', function () use ($request) {
                $url = '';
                $resource = null;

                if ($this->purchasable) {
                    $resource = (new Purchasable($this->purchasable));
                    $url = '/nova/resources/'.$resource::uriKey().'/'.$resource->getKey();
                }

                if ($this->bundle) {
                    $resource = (new Bundle($this->bundle));
                    $url = '/nova/resources/'.$resource::uriKey().'/'.$resource->getKey();
                }

                return <<<HTML
                    <a class='no-underline dim text-primary font-bold' href='{$url}'>
                        {$resource?->title()}
                    </a>
                HTML;
            })->onlyOnIndex()->asHtml(),

            Text::make('Paddle Fee')->hideFromIndex(),
            Text::make('Earnings')->hideFromIndex(),

            HasMany::make('Purchase Assignments', 'assignments', PurchaseAssignment::class),
            Text::make('Assignments', function () {
                return $this->assignments->unique('user_id')->map(function (\App\Domain\Shop\Models\PurchaseAssignment $assignment) {
                    $resource = (new User($assignment->user));
                    $url = '/nova/resources/'.$resource::uriKey().'/'.$resource->getKey();

                    return <<<HTML
                        <a class='no-underline dim text-primary font-bold' href='{$url}'>
                            {$assignment->user->name}
                        </a>
                    HTML;
                })->join(', ');
            })->onlyOnIndex()->asHtml(),

            BelongsTo::make('Receipt')->nullable(),

            DateTime::make('Created at'),
        ];
    }

    public function actions(NovaRequest $request)
    {
        return [
            new TransferPurchasesAction(),
        ];
    }
}
