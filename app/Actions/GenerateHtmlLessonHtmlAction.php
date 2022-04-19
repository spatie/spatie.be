<?php

namespace App\Actions;

use App\Models\HtmlLesson;
use Illuminate\Support\Str;
use League\CommonMark\Extension\Table\TableExtension;
use Spatie\LaravelMarkdown\MarkdownRenderer;

class GenerateHtmlLessonHtmlAction
{
    public function execute(HtmlLesson $htmlLesson)
    {
        $html = app(MarkdownRenderer::class)
            ->addExtension(new TableExtension())
            ->toHtml($htmlLesson->markdown);

        $html = Str::of($html)
            ->replace('[good]', '<div class="shiki-good">')
            ->replace('[bad]', '<div class="shiki-bad">')
            ->replace(['[/good]', '[/bad]'], '</div>')
            ->toString();

        $htmlLesson->updateQuietly([
            'html' => $html,
        ]);
    }
}
