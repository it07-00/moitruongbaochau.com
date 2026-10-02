<?php

namespace Database\Seeders;

use App\ContentStatus;
use App\Models\Service;
use Illuminate\Database\Seeder;

class DeclarationService2026Seeder extends Seeder
{
    public function run(): void
    {
        $declarations = [
            'khai-bao-kiem-ke-khi-nha-kinh-2026' => [
                'source' => 'kiem-ke-khi-nha-kinh',
                'name' => 'Khai báo kiểm kê khí nhà kính 2026',
            ],
            'khai-bao-kiem-toan-nang-luong-2026' => [
                'source' => 'kiem-toan-nang-luong-va-giai-phap-tiet-kiem',
                'name' => 'Khai báo kiểm toán năng lượng 2026',
            ],
        ];

        foreach ($declarations as $slug => $declaration) {
            if (Service::query()->where('slug', $slug)->exists()) {
                continue;
            }

            $source = Service::query()->where('slug', $declaration['source'])->firstOrFail();

            Service::query()->create([
                ...$source->only([
                    'service_category_id', 'short_description', 'content', 'thumbnail',
                    'icon', 'tags', 'sort_order', 'og_image', 'twitter_image',
                ]),
                'slug' => $slug,
                'name' => $declaration['name'],
                'status' => ContentStatus::Published,
                'published_at' => now(),
                'is_featured' => false,
                'meta_title' => $declaration['name'],
                'meta_description' => $source->meta_description ?: $source->short_description,
            ]);
        }
    }
}
