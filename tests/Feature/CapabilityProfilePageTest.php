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

    public function test_admin_can_edit_profile_content_while_retaining_an_existing_pdf(): void
    {
        Storage::fake('public');
        Filament::setCurrentPanel(Filament::getPanel('admin'));
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $page = Page::query()->where('slug', 'ho-so-nang-luc')->firstOrFail();
        $path = 'uploads/company-profile/existing.pdf';
        $url = 'https://heyzine.com/flip-book/3997d6e66b.html';
        Storage::disk('public')->put($path, "%PDF-1.4\nProfile\n%%EOF");
        $page->update(['metadata' => ['capability_pdf' => $path, 'capability_flipbook_url' => $url]]);

        Livewire::test(EditPage::class, ['record' => $page->getRouteKey()])
            ->assertFormSet(['metadata.capability_pdf' => $path])
            ->fillForm(['title' => 'Hồ sơ năng lực Bảo Châu'])
            ->call('save')->assertHasNoFormErrors();

        $this->assertSame($path, $page->refresh()->metadata['capability_pdf']);
        $this->assertSame('Hồ sơ năng lực Bảo Châu', $page->title);
        Storage::disk('public')->assertExists($path);
        Livewire::test(EditPage::class, ['record' => $page->getRouteKey()])
            ->assertFormSet(['metadata.capability_pdf' => $path])
            ->call('save')->assertHasNoFormErrors();
    }

    public function test_admin_cannot_replace_the_pdf_with_an_unrelated_stored_path(): void
    {
        Storage::fake('public');
        Filament::setCurrentPanel(Filament::getPanel('admin'));
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $page = Page::query()->where('slug', 'ho-so-nang-luc')->firstOrFail();
        $path = 'uploads/company-profile/original.pdf';
        $otherPath = 'uploads/company-profile/other.pdf';
        foreach ([$path, $otherPath] as $filePath) {
            Storage::disk('public')->put($filePath, "%PDF-1.4\n%%EOF");
        }
        $page->update(['metadata' => ['capability_pdf' => $path]]);

        Livewire::test(EditPage::class, ['record' => $page->getRouteKey()])
            ->fillForm(['metadata.capability_pdf' => [$otherPath]])
            ->call('save')->assertHasFormErrors(['metadata.capability_pdf']);
        $this->assertSame($path, $page->refresh()->metadata['capability_pdf']);
    }

    public function test_legacy_heyzine_link_is_ignored_with_or_without_a_pdf(): void
    {
        $page = Page::query()->where('slug', 'ho-so-nang-luc')->firstOrFail();
        $url = 'https://heyzine.com/flip-book/3997d6e66b.html';
        $page->update(['metadata' => ['capability_flipbook_url' => $url]]);

        $this->get(route('capability-profile'))->assertOk()
            ->assertDontSee('heyzine.com', false)
            ->assertDontSee('<iframe', false)
            ->assertSee('Hồ sơ năng lực đang được cập nhật')
            ->assertDontSee('Tải bản PDF');

        $path = 'uploads/company-profile/profile.pdf';
        Storage::fake('public');
        Storage::disk('public')->put($path, "%PDF-1.4\n%%EOF");
        $page->update(['metadata' => ['capability_flipbook_url' => $url, 'capability_pdf' => $path]]);
        $this->get(route('capability-profile'))->assertOk()
            ->assertDontSee('heyzine.com', false)
            ->assertSee('Xem trực tuyến')
            ->assertSee(route('capability-profile.pdf', ['download' => 1]), false);
    }

    public function test_invalid_flipbook_urls_are_not_embedded(): void
    {
        $page = Page::query()->where('slug', 'ho-so-nang-luc')->firstOrFail();
        foreach (['https://example.com/flip-book/3997d6e66b.html', 'javascript:alert(1)', 'https://heyzine.com.evil.example/flip-book/3997d6e66b.html', 'https://heyzine.com/flip-book/3997d6e66b.html?bad=1'] as $url) {
            $page->update(['metadata' => ['capability_flipbook_url' => $url]]);
            $this->get(route('capability-profile'))->assertOk()
                ->assertDontSee('<iframe', false)
                ->assertDontSee($url, false)
                ->assertSee('Hồ sơ năng lực đang được cập nhật');
        }
    }

    public function test_pdf_endpoint_supports_byte_range_requests(): void
    {
        Storage::fake('public');
        $page = Page::query()->where('slug', 'ho-so-nang-luc')->firstOrFail();
        $path = 'uploads/company-profile/profile.pdf';
        $contents = "%PDF-1.4\nProfile\n%%EOF";
        Storage::disk('public')->put($path, $contents);
        $page->update(['metadata' => ['capability_pdf' => $path]]);

        $this->get(route('capability-profile.pdf'), ['Range' => 'bytes=0-7'])
            ->assertStatus(206)
            ->assertHeader('Accept-Ranges', 'bytes')
            ->assertHeader('Content-Range', 'bytes 0-7/'.strlen($contents))
            ->assertHeader('Content-Length', '8');
    }

    public function test_page_previews_and_streams_the_pdf_and_has_its_own_canonical(): void
    {
        Storage::fake('public');
        $page = Page::query()->where('slug', 'ho-so-nang-luc')->firstOrFail();
        $path = 'uploads/company-profile/profile.pdf';
        $contents = "%PDF-1.4\nProfile\n%%EOF";
        Storage::disk('public')->put($path, $contents);
        $page->update(['metadata' => ['capability_pdf' => $path]]);

        $this->get(route('capability-profile'))->assertOk()
            ->assertDontSee('<iframe', false)
            ->assertSee('href="'.route('capability-profile.pdf').'" target="_blank"', false)
            ->assertSee('Tải bản PDF')
            ->assertSee('<link rel="canonical" href="'.route('capability-profile').'">', false);
        $preview = $this->get(route('capability-profile.pdf'))->assertOk()
            ->assertHeader('Content-Type', 'application/pdf')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('Content-Disposition', 'inline; filename=ho-so-nang-luc-bao-chau.pdf');
        $download = $this->get(route('capability-profile.pdf', ['download' => 1]))
            ->assertDownload('ho-so-nang-luc-bao-chau.pdf');
        $this->assertSame($contents, $preview->baseResponse->getFile()->getContent());
        $this->assertSame($contents, $download->baseResponse->getFile()->getContent());
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
            ->assertFormSet(['metadata.capability_pdf' => $path])
            ->call('save')->assertHasNoFormErrors();
        config(['livewire.temporary_file_upload.rules' => ['required', 'file', 'max:204800']]);
        Livewire::test(EditPage::class, ['record' => $page->getRouteKey()])
            ->fillForm(['metadata.capability_pdf' => []])
            ->fillForm(['metadata.capability_pdf' => UploadedFile::fake()->create('large.pdf', 102401, 'application/pdf')])
            ->call('save')->assertHasFormErrors(['metadata.capability_pdf']);
        Livewire::test(EditPage::class, ['record' => $page->getRouteKey()])
            ->fillForm(['metadata.capability_pdf' => []])
            ->fillForm(['metadata.capability_pdf' => UploadedFile::fake()->create('invalid.txt', 1, 'text/plain')])
            ->call('save')->assertHasFormErrors(['metadata.capability_pdf']);
    }
}
