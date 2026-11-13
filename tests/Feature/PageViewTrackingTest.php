<?php

namespace Tests\Feature;

use App\ContentStatus;
use App\Filament\Resources\Pages\Pages\ListPages;
use App\Filament\Resources\PageViews\Pages\ListPageViews;
use App\Filament\Resources\Posts\Pages\ListPosts;
use App\Filament\Resources\Services\Pages\ListServices;
use App\Models\Page;
use App\Models\PageView;
use App\Models\Post;
use App\Models\Service;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PageViewTrackingTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_visiting_ghg_landing_page_records_page_view_and_deduplicates_refresh_in_same_session(): void
    {
        $this->get(route('ghg-service.index'))->assertOk();

        $this->assertDatabaseHas('page_views', [
            'page_key' => 'landing:ghg-service',
            'page_type' => 'landing',
            'page_title' => 'Landing Page: Dịch vụ Kiểm kê Khí nhà kính',
        ]);
        $this->assertSame(1, PageView::where('page_key', 'landing:ghg-service')->count());

        // Immediate refresh in the same session should be deduplicated
        $this->get(route('ghg-service.index'))->assertOk();
        $this->assertSame(1, PageView::where('page_key', 'landing:ghg-service')->count());
    }

    public function test_visiting_main_pages_increments_page_view_count_and_logs_page_view(): void
    {
        $homePage = Page::factory()->create([
            'title' => 'Trang chủ Bảo Châu',
            'slug' => 'trang-chu',
            'template' => 'home',
            'status' => ContentStatus::Published,
            'view_count' => 10,
        ]);

        $aboutPage = Page::factory()->create([
            'title' => 'Giới thiệu Bảo Châu',
            'slug' => 'gioi-thieu',
            'template' => 'about',
            'status' => ContentStatus::Published,
            'view_count' => 25,
        ]);

        $this->get(route('home'))->assertOk();
        $this->get(route('about'))->assertOk();

        $this->assertSame(11, $homePage->refresh()->view_count);
        $this->assertSame(26, $aboutPage->refresh()->view_count);

        $this->assertDatabaseHas('page_views', [
            'page_key' => 'page:home',
            'page_type' => 'page',
            'viewable_type' => Page::class,
            'viewable_id' => $homePage->id,
        ]);

        $this->assertDatabaseHas('page_views', [
            'page_key' => 'page:about',
            'page_type' => 'page',
            'viewable_type' => Page::class,
            'viewable_id' => $aboutPage->id,
        ]);
    }

    public function test_visiting_service_and_post_details_increments_view_count_once_per_session(): void
    {
        $service = Service::factory()->create([
            'view_count' => 100,
            'status' => ContentStatus::Published,
        ]);
        $post = Post::factory()->create([
            'view_count' => 200,
            'status' => ContentStatus::Published,
        ]);

        $this->get(route('services.show', $service->slug))->assertOk();
        $this->get(route('services.show', $service->slug))->assertOk();

        $this->get(route('posts.show', $post->slug))->assertOk();
        $this->get(route('posts.show', $post->slug))->assertOk();

        $this->assertSame(101, $service->refresh()->view_count);
        $this->assertSame(201, $post->refresh()->view_count);

        $this->assertDatabaseHas('page_views', [
            'page_key' => 'service:'.$service->slug,
            'page_type' => 'service',
            'viewable_type' => Service::class,
            'viewable_id' => $service->id,
        ]);

        $this->assertDatabaseHas('page_views', [
            'page_key' => 'post:'.$post->slug,
            'page_type' => 'post',
            'viewable_type' => Post::class,
            'viewable_id' => $post->id,
        ]);
    }

    public function test_admin_can_view_page_views_resource_and_view_count_columns_in_filament(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $page = Page::factory()->create(['view_count' => 543]);
        $service = Service::factory()->create(['view_count' => 876]);
        $post = Post::factory()->create(['view_count' => 321]);
        $pageView = PageView::factory()->create([
            'page_key' => 'landing:ghg-service',
            'page_type' => 'landing',
            'page_title' => 'Landing Page: Dịch vụ Kiểm kê Khí nhà kính',
        ]);

        $this->actingAs($admin);
        Filament::setCurrentPanel(Filament::getPanel('admin'));

        Livewire::test(ListPageViews::class)
            ->assertSuccessful()
            ->assertCanSeeTableRecords([$pageView]);

        Livewire::test(ListPages::class)
            ->assertSuccessful()
            ->assertCanSeeTableRecords([$page])
            ->assertTableColumnExists('view_count');

        Livewire::test(ListServices::class)
            ->assertSuccessful()
            ->assertCanSeeTableRecords([$service])
            ->assertTableColumnExists('view_count');

        Livewire::test(ListPosts::class)
            ->assertSuccessful()
            ->assertCanSeeTableRecords([$post])
            ->assertTableColumnExists('view_count');
    }
}
