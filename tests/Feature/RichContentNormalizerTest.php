<?php

namespace Tests\Feature;

use App\Support\RichContentNormalizer;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Tests\TestCase;

class RichContentNormalizerTest extends TestCase
{
    public function test_it_converts_legacy_figures_to_a_valid_rich_editor_document(): void
    {
        $legacyHtml = <<<'HTML'
<figure class="wp-caption">
    <img src="/storage/uploads/services/content/replacement.webp" alt="Ảnh mới">
    <figcaption class="wp-caption-text">Chú thích ảnh</figcaption>
</figure>
HTML;

        $normalizedHtml = RichContentNormalizer::normalizeLegacyFigures($legacyHtml);
        $document = RichContentRenderer::make($normalizedHtml)->toArray();

        $this->assertStringNotContainsString('<figure', $normalizedHtml);
        $this->assertStringNotContainsString('<figcaption', $normalizedHtml);
        $this->assertSame(['image', 'paragraph'], array_column($document['content'], 'type'));
        $this->assertNotContains('text', array_column($document['content'], 'type'));
    }

    public function test_normalization_is_idempotent(): void
    {
        $normalizedHtml = '<div data-rich-content-figure="true"><img src="/image.webp"><p data-rich-content-caption="true">Chú thích</p></div>';

        $this->assertSame(
            $normalizedHtml,
            RichContentNormalizer::normalizeLegacyFigures($normalizedHtml),
        );
    }
}
