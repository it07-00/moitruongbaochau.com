<?php

namespace Tests\Feature;

use App\Models\ServiceCategory;
use DOMDocument;
use DOMXPath;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class FrontendAccessibilityTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_service_tabs_have_matching_panels_and_one_keyboard_entry_point(): void
    {
        ServiceCategory::factory()->count(2)->create(['is_active' => true]);
        $html = $this->get(route('home'))->assertOk()->getContent();
        $document = new DOMDocument;
        $previous = libxml_use_internal_errors(true);
        $document->loadHTML($html);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);
        $xpath = new DOMXPath($document);
        $tabs = $xpath->query('//*[@role="tablist"]//*[@role="tab"]');
        $this->assertCount(2, $tabs);
        $selected = 0;
        foreach ($tabs as $tab) {
            $panelId = $tab->getAttribute('aria-controls');
            $panel = $document->getElementById($panelId);
            $this->assertNotNull($panel);
            $this->assertSame('tabpanel', $panel->getAttribute('role'));
            $this->assertSame($tab->getAttribute('id'), $panel->getAttribute('aria-labelledby'));
            $this->assertSame('#'.$panelId, $tab->getAttribute('href'));
            if ($tab->getAttribute('aria-selected') === 'true') {
                $selected++;
                $this->assertSame('0', $tab->getAttribute('tabindex'));
            } else {
                $this->assertSame('-1', $tab->getAttribute('tabindex'));
            }
        }
        $this->assertSame(1, $selected);
    }

    public function test_deferred_styles_do_not_redeclare_fonts_after_first_render(): void
    {
        $this->get(route('home'))->assertOk();
        $critical = file_get_contents(public_path('assets/css/frontend-critical.css'));
        $full = file_get_contents(public_path('assets/css/frontend.min.css'));
        $fonts = file_get_contents(public_path('assets/css/frontend-fonts.css'));
        $this->assertSame(10, substr_count($fonts, '@font-face'));
        $this->assertStringNotContainsString('font-family:Poppins', $critical);
        $this->assertStringNotContainsString('font-family:Poppins;', $full);
        $this->assertStringContainsString('font-display:optional', $fonts);
    }
}
