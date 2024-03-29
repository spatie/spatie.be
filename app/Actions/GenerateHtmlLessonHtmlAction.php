<?php

namespace App\Actions;

use App\Models\HtmlLesson;
use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use League\CommonMark\Extension\Table\TableExtension;
use Spatie\LaravelMarkdown\MarkdownRenderer;
use Spatie\SidecarShiki\Commonmark\HighlightCodeExtension;
use Tempest\Highlight\CommonMark\CodeBlockRenderer;
use Tempest\Highlight\CommonMark\InlineCodeBlockRenderer;

class GenerateHtmlLessonHtmlAction
{
    public function execute(HtmlLesson $htmlLesson)
    {
        $html = app(MarkdownRenderer::class)
            ->addExtension(new TableExtension())
            ->addInlineRenderer(FencedCode::class, new CodeBlockRenderer(), 10)
            ->addInlineRenderer(Code::class, new InlineCodeBlockRenderer(), 10)
            ->toHtml($htmlLesson->markdown);

        $html = Str::of($html)
            ->replace('[good]', '<div class="hl-addition">')
            ->replace('[bad]', '<div class="hl-deletion">')
            ->replace(['[/good]', '[/bad]'], '</div>')
            ->toString();

        $htmlLesson->updateQuietly([
            'html' => $html,
        ]);
    }
}
