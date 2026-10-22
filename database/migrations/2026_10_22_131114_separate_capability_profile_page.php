<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::transaction(function (): void {
            $about = DB::table('pages')->where('slug', 'gioi-thieu')->first();
            $metadata = json_decode($about?->metadata ?? '{}', true, flags: JSON_THROW_ON_ERROR);
            $profile = DB::table('pages')->where('slug', 'ho-so-nang-luc')->first();
            $profileMetadata = json_decode($profile?->metadata ?? '{}', true, flags: JSON_THROW_ON_ERROR);

            if (! $profile) {
                DB::table('pages')->insert([
                    'title' => 'Hồ sơ năng lực Môi Trường Bảo Châu',
                    'slug' => 'ho-so-nang-luc',
                    'template' => 'capability-profile',
                    'excerpt' => 'Tìm hiểu về đội ngũ, lĩnh vực hoạt động và năng lực triển khai của Môi Trường Bảo Châu.',
                    'metadata' => json_encode(array_intersect_key($metadata, ['capability_pdf' => true]), JSON_THROW_ON_ERROR),
                    'status' => 'published',
                    'published_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } elseif (empty($profileMetadata['capability_pdf']) && ! empty($metadata['capability_pdf'])) {
                DB::table('pages')->where('id', $profile->id)->update([
                    'metadata' => json_encode([...$profileMetadata, 'capability_pdf' => $metadata['capability_pdf']], JSON_THROW_ON_ERROR),
                    'updated_at' => now(),
                ]);
            }

            $menu = DB::table('menus')->where('location', 'primary')->first();
            $parent = $menu ? DB::table('menu_items')->where('menu_id', $menu->id)
                ->where('route_name', 'about')->whereNull('parent_id')->first() : null;

            if ($menu && ! DB::table('menu_items')->where('menu_id', $menu->id)->where('route_name', 'capability-profile')->exists()) {
                DB::table('menu_items')->insert([
                    'menu_id' => $menu->id,
                    'parent_id' => $parent?->id,
                    'label' => 'Hồ sơ năng lực',
                    'route_name' => 'capability-profile',
                    'sort_order' => 1,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
        Cache::forget('website.menu.primary');
    }

    /**
     * Preserve CMS content and files that may have been edited after migration.
     */
    public function down(): void {}
};
