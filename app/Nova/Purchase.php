<?php

namespace App\Nova;

use App\Domain\Shop\Models\Purchase as EloquentPurchase;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Purchase extends Resource
{
    public static $group = "Products";

    public static $tableStyle = 'tight';

    public static $model = EloquentPurchase::class;

    //public static $title = 'title';

    public static $search = [
        'id',
    ];

    public static $with = ['assignments.user', 'bundle', 'purchasable'];

    public function fields(Request $request)
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

            Number::make('Quantity'),
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

            BelongsTo::make('Receipt')->nullable()->hideFromIndex(),

            DateTime::make('Created at')->format('d/M/YYYY hh:mm'),
        ];
    }
}
