<?php

namespace Tests\Docs\Highlighting;

use App\Docs\Highlighting\RustLanguage;
use Tempest\Highlight\Highlighter;

it('highlights Rust without changing the source or treating strings as code', function (string $language) {
    $source = <<<'RUST'
use spatie_crawler::Crawler;
#[tokio::main]
async fn main() -> Result<(), Box<dyn std::error::Error>> {
    // let crawler = Crawler::new();
    /* outer /* inner */ let untouched = true; */
    let crawler = Crawler::builder("https://example.com")?;
    let html = r##"<script>"if let"</script>"##;
    let quoted = "say \"hello\" // not a comment";
    let character = 'x';
    let text: &'static str = "text";
    println!("{text}");
    Ok(())
}
RUST;

    $highlighter = new Highlighter();
    $highlighter->addLanguage(new RustLanguage());

    $html = $highlighter->parse($source, $language);

    expect($html)
        ->toContain('<span class="hl-keyword">async</span> <span class="hl-keyword">fn</span>')
        ->toContain('<span class="hl-type">Crawler</span>')
        ->toContain('<span class="hl-property">builder</span>')
        ->toContain('<span class="hl-property">println!</span>')
        ->toContain('<span class="hl-comment">// let crawler = Crawler::new();</span>')
        ->toContain('<span class="hl-comment">/* outer /* inner */ let untouched = true; */</span>')
        ->toContain('<span class="hl-value">r##&quot;&lt;script&gt;&quot;if let&quot;&lt;/script&gt;&quot;##</span>')
        ->not->toContain('<script>');

    expect(html_entity_decode(strip_tags($html)))->toBe($source);
})->with(['rust', 'rs']);
