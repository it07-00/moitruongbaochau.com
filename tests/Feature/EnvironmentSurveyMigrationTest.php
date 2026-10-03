<?php

namespace Tests\Feature;

use App\ContentStatus;
use App\Models\EnvironmentSurvey;
use App\Models\Service;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class EnvironmentSurveyMigrationTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_migrations_provision_the_bvmt_service_without_seeders_or_demo_surveys(): void
    {
        $service = Service::query()->where('slug', 'bao-cao-cong-tac-bao-ve-moi-truong-dinh-ky')->sole();
        $this->assertSame(ContentStatus::Published, $service->status);
        $this->assertSame(route('bvmt.index'), $service->getDeclarationFormUrl());
        $this->assertSame(0, EnvironmentSurvey::query()->count());
        $this->get($service->getPublicUrl())->assertOk()->assertSee('href="'.route('bvmt.index').'"', false)->assertSee('Điền phiếu khảo sát theo 7 bước');
    }

    public function test_data_migration_does_not_overwrite_existing_cms_content_or_duplicate_services(): void
    {
        $service = Service::query()->where('slug', 'bao-cao-cong-tac-bao-ve-moi-truong-dinh-ky')->sole();
        $service->update(['name' => 'Tên do quản trị chỉnh sửa', 'content' => '<p>Nội dung riêng của doanh nghiệp.</p>', 'status' => ContentStatus::Draft]);
        $before = $service->getRawOriginal();
        $migration = $this->dataMigration();
        $migration->up();
        $migration->up();
        $migration->down();
        $this->assertSame($before, $service->refresh()->getRawOriginal());
        $this->assertSame(1, Service::query()->where('slug', $service->slug)->count());
    }

    public function test_data_migration_creates_service_when_missing(): void
    {
        Service::query()->where('slug', 'bao-cao-cong-tac-bao-ve-moi-truong-dinh-ky')->delete();
        $this->dataMigration()->up();
        $service = Service::query()->where('slug', 'bao-cao-cong-tac-bao-ve-moi-truong-dinh-ky')->sole();
        $this->assertSame(ContentStatus::Published, $service->status);
        $this->assertNotNull($service->published_at);
    }

    private function dataMigration(): Migration
    {
        return require database_path('migrations/2026_10_03_092906_ensure_environment_report_service_exists.php');
    }
}
