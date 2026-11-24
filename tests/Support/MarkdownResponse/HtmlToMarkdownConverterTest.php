<?php

use Spatie\MarkdownResponse\HtmlToMarkdownConverter;

it('preserves angle brackets and the content after code when exporting Markdown', function (string $template, string $language) {
    $code = <<<'RUST'
let paths: Vec<OsString> = Vec::new();
fn run() -> Result<(), Error> { Ok(()) }
let html = "<script>alert('example')</script>";
impl HasTranslations for Translations<'_> {
    fn to_array(&self) -> Result<Attributes> { todo!() }
}
RUST;

    $highlighted = str_replace('OsString', '<span class="hl-type">OsString</span>', e($code));

    $html = '<main><p>Use <code>Vec&lt;<span class="hl-type">OsString</span>&gt;</code>.</p>'
        .' '.sprintf($template, $highlighted)
        .'<p>See <a href="https://example.com/PARITY.md#serialization">serialization differences</a>.</p>'
        .'<p>Contact <a href="mailto:security@example.com">security@example.com</a>.</p></main>';

    expect(app(HtmlToMarkdownConverter::class)->convert($html))->toBe(
        "Use `Vec<OsString>`.\n\n```{$language}\n{$code}\n```\n\n"
        ."See [serialization differences](https://example.com/PARITY.md#serialization).\n\n"
        ."Contact <security@example.com>.\n"
    );
})->with([
    'Tempest block' => ['<pre data-lang="rust">%s</pre>', ''],
    'standard block' => ['<pre><code class="language-rust">%s</code></pre>', 'rust'],
]);

it('still converts ordinary PHP docs markup without leaking layout tags or scripts', function () {
    $html = <<<'HTML'
<div><header>Navigation</header><main><h1>Usage</h1>
<p>A <strong>simple</strong> <em>example</em> with <span class="highlight">highlighting</span> and <a href="https://example.com/docs">a guide</a>.</p>
<pre><code class="language-php">$name = &quot;Spatie&quot;;
echo $name;</code></pre>
<ul><li>Install</li><li>Run</li></ul>
<script>alert('not documentation');</script><style>.example { color: red; }</style>
</main><footer>Footer</footer></div>
HTML;

    expect(app(HtmlToMarkdownConverter::class)->convert($html))->toBe(<<<'MARKDOWN'
Usage
=====

A **simple** *example* with highlighting and [a guide](https://example.com/docs).

```php
$name = "Spatie";
echo $name;
```

- Install
- Run

MARKDOWN);
});
