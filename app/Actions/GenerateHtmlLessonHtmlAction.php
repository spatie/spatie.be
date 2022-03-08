<?php

namespace App\Actions;

use App\Models\HtmlLesson;
use Spatie\LaravelMarkdown\MarkdownRenderer;

class GenerateHtmlLessonHtmlAction
{
    public function execute(HtmlLesson $htmlLesson)
    {
        $html = app(MarkdownRenderer::class)->toHtml($htmlLesson->markdown);

        $htmlLesson->updateQuietly([
                'html' => $html,
            ]);
    }
}
