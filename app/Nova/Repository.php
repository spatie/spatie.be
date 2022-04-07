<?php

namespace App\Nova;

use App\Nova\Actions\ImportDocsAction;
use App\Nova\Actions\UpdateSatisAction;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Repository extends Resource
{
    public static $model = \App\Models\Repository::class;

    public static $title = 'name';

    public static $group = "GitHub";

    public static string $defaultSort = 'name';

    public static $search = [
       'name', 'description',
    ];

    public function fields(NovaRequest $request)
    {
        return [
            Text::make('Name')
                ->sortable()
                ->rules(['required', 'max:255']),

            BelongsTo::make('Ad'),

            Boolean::make('Ad should be randomized'),
        ];
    }

    public function actions(NovaRequest $request)
    {
        return [
          //  (new ImportDocsAction())->onlyOnIndexToolbar(),
          //  (new UpdateSatisAction())->onlyOnIndexToolbar(),
        ];
    }
}
