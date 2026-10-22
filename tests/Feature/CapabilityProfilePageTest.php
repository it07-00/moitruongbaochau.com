<?php

namespace Tests\Feature;

use App\ContentStatus;
use App\Filament\Resources\Pages\Pages\EditPage;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class CapabilityProfilePageTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_page_previews_and_streams_the_pdf_and_has_its_own_canonical(): void
    {
        Storage::fake('public');
        $page = Page::query()->where('slug', 'ho-so-nang-luc')->firstOrFail();
        $path = 'uploads/company-profile/profile.pdf';
        $contents = "%PDF-1.4\nProfile\n%%EOF";
        Storage::disk('public')->put($path, $contents);
        $page->update(['metadata' => ['capability_pdf' => $path]]);

        $this->get(route('capability-profile'))->assertOk()
            ->assertSee('<iframe', false)
            ->assertSee(route('capability-profile.pdf'))
            ->assertSee('<link rel="canonical" href="'.route('capability-profile').'">', false);
        $this->get(route('capability-profile.pdf'))->assertOk()
            ->assertHeader('Content-Type', 'application/pdf')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('Content-Disposition', 'inline; filename=ho-so-nang-luc-bao-chau.pdf')
            ->assertStreamedContent($contents);
        $this->get(route('capability-profile.pdf', ['download' => 1]))
            ->assertDownload('ho-so-nang-luc-bao-chau.pdf')->assertStreamedContent($contents);
        $this->assertSame(route('capability-profile'), $page->getPublicUrl());
        $this->get(route('pages.show', $page->slug))->assertRedirect(route('capability-profile'));
        $this->get(route('sitemap'))->assertSee(route('capability-profile'), false);
    }

    public function test_missing_invalid_and_unpublished_pdf_is_not_served(): void
    {
        Storage::fake('public');
        $page = Page::query()->where('slug', 'ho-so-nang-luc')->firstOrFail();
        foreach (['', 'uploads/company-profile/missing.pdf', 'uploads/company-profile/../private.pdf', 'uploads/other/file.pdf', 'uploads/company-profile/file.html'] as $path) {
            $page->update(['metadata' => ['capability_pdf' => $path]]);
            $this->get(route('capability-profile'))->assertOk()->assertDontSee('<iframe', false)
                ->assertSee('Hồ sơ năng lực đang được cập nhật');
            $this->get(route('capability-profile.pdf'))->assertNotFound();
        }
        $page->update(['status' => ContentStatus::Draft]);
        $this->get(route('capability-profile'))->assertNotFound();
        $this->get(route('capability-profile.pdf'))->assertNotFound();
        $this->get(route('sitemap'))->assertDontSee(route('capability-profile'), false);
    }

    public function test_migration_preserves_old_pdf_and_adds_a_single_menu_link(): void
    {
        $about = Page::factory()->create([
            'slug' => 'gioi-thieu',
            'metadata' => ['capability_pdf' => 'uploads/company-profile/old.pdf', 'vision_title' => 'Giữ nội dung'],
        ]);
        $menu = Menu::factory()->create(['location' => 'primary']);
        $parent = MenuItem::factory()->for($menu)->create(['route_name' => 'about']);
        $migration = require database_path('migrations/2026_10_22_131114_separate_capability_profile_page.php');
        $migration->up();
        $migration->up();
        $page = Page::query()->where('slug', 'ho-so-nang-luc')->firstOrFail();
        $this->assertSame('uploads/company-profile/old.pdf', $page->metadata['capability_pdf']);
        $this->assertSame('Giữ nội dung', $about->refresh()->metadata['vision_title']);
        $this->assertSame(1, $menu->items()->where('route_name', 'capability-profile')->count());
        $this->assertSame($parent->id, $menu->items()->where('route_name', 'capability-profile')->firstOrFail()->parent_id);
        $page->update(['metadata' => ['capability_pdf' => 'uploads/company-profile/new.pdf']]);
        $migration->up();
        $this->assertSame('uploads/company-profile/new.pdf', $page->refresh()->metadata['capability_pdf']);
    }

    public function test_admin_can_upload_a_pdf_over_fifty_mb_and_reopen_it(): void
    {
        Storage::fake('public');
        Filament::setCurrentPanel(Filament::getPanel('admin'));
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $page = Page::query()->where('slug', 'ho-so-nang-luc')->firstOrFail();
        $file = UploadedFile::fake()->create('profile.pdf', 54000, 'application/pdf');

        Livewire::test(EditPage::class, ['record' => $page->getRouteKey()])
            ->assertFormFieldVisible('metadata.capability_pdf')
            ->fillForm(['metadata.capability_pdf' => $file])
            ->call('save')->assertHasNoFormErrors();

        $path = $page->refresh()->metadata['capability_pdf'];
        Storage::disk('public')->assertExists($path);
        Livewire::test(EditPage::class, ['record' => $page->getRouteKey()])
            ->assertFormSet(['metadata.capability_pdf' => $path]);
        Livewire::test(EditPage::class, ['record' => $page->getRouteKey()])
            ->fillForm(['metadata.capability_pdf' => UploadedFile::fake()->create('large.pdf', 102401, 'application/pdf')])
            ->call('save')->assertHasFormErrors(['metadata.capability_pdf']);
        Livewire::test(EditPage::class, ['record' => $page->getRouteKey()])
            ->fillForm(['metadata.capability_pdf' => UploadedFile::fake()->create('invalid.txt', 1, 'text/plain')])
            ->call('save')->assertHasFormErrors(['metadata.capability_pdf']);
    }
}
