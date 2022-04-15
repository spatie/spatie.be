<?php

namespace App\Nova;

use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\Comments\Models\Comment as CommentModel;

class Comment extends Resource
{
    public static $model = CommentModel::class;

    public function fields(NovaRequest $request)
    {
        Text::make('', function (CommentModel $comment) {
            $comment->topLevel()->commentable->title;
        })->readonly();

        MorphTo::make('Commentable')->types([
            \App\Models\User::class,
        ]);

        Markdown::make('original_text');

        Text::make('', function (CommentModel $comment) {
            return "<a target=\"comment_preview\" href=\"{$comment->commentUrl()}\">Show</a>";
        })->asHtml();
    }
}
