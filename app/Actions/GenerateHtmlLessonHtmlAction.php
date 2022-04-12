<?php

namespace App\Actions;

use App\Models\HtmlLesson;
use League\CommonMark\Extension\Table\TableExtension;
use Spatie\LaravelMarkdown\MarkdownRenderer;

class GenerateHtmlLessonHtmlAction
{
    public function execute(HtmlLesson $htmlLesson)
    {
        $html = app(MarkdownRenderer::class)
            ->addExtension(new TableExtension())
            ->toHtml($htmlLesson->markdown);

        $htmlLesson->updateQuietly([
            'html' => $html,
        ]);
    }
}
