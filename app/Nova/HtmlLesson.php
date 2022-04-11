<?php

namespace App\Nova;

use App\Models\HtmlLesson as EloquentHtmlLesson;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class HtmlLesson extends Resource
{
    public static $group = "Courses";

    public static $title = 'title';

    public static $model = EloquentHtmlLesson::class;

    public static $search = [
        'id', 'title',
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Title')
                ->sortable()
                ->hideWhenCreating()
                ->hideWhenUpdating(),
        ];
    }
}
