<?php

namespace App\Nova;

use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\Comments\Models\Comment as CommentModel;

class Comment extends Resource
{
    public static $group = "Courses";

    public static $model = CommentModel::class;

    public static $search = [
        'id', 'title',
    ];

    public function fields(NovaRequest $request)
    {
        return [
            Text::make('title', function (CommentModel $comment) {
                return $comment->topLevel()->commentable->commentableName();
            })->readonly(),

            MorphTo::make('Commentator')->types([
                \App\Nova\User::class,
            ]),

            Markdown::make('Original text'),

            Text::make('', function (CommentModel $comment) {
                return "<a target=\"comment_preview\" href=\"{$comment->commentUrl()}\">Show</a>";
            })->asHtml(),

            DateTime::make('Created at'),


        ];
    }
}
