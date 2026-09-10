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

        $normalizedHtml = RichContentNormalizer::normalize($legacyHtml);
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
            RichContentNormalizer::normalize($normalizedHtml),
        );
    }

    public function test_it_wraps_legacy_list_item_text_in_paragraphs_required_by_tiptap(): void
    {
        $legacyHtml = '<ul><li>Nội dung thứ nhất</li><li><strong>Nội dung thứ hai</strong></li></ul>';

        $normalizedHtml = RichContentNormalizer::normalize($legacyHtml);
        $document = RichContentRenderer::make($normalizedHtml)->toArray();

        foreach ($document['content'][0]['content'] as $listItem) {
            $this->assertSame('paragraph', $listItem['content'][0]['type']);
        }
    }

    public function test_it_preserves_nested_lists_while_wrapping_the_leading_text(): void
    {
        $legacyHtml = '<ul><li>Mục cha<ul><li>Mục con</li></ul></li></ul>';

        $normalizedHtml = RichContentNormalizer::normalize($legacyHtml);
        $document = RichContentRenderer::make($normalizedHtml)->toArray();
        $parentListItem = $document['content'][0]['content'][0];

        $this->assertSame(['paragraph', 'bulletList'], array_column($parentListItem['content'], 'type'));
        $this->assertSame('paragraph', $parentListItem['content'][1]['content'][0]['content'][0]['type']);
    }
}
