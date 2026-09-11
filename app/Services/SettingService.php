<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class SettingService
{
    /**
     * @return array<string, string|null>
     */
    public function all(): array
    {
        if (! Schema::hasTable((new Setting)->getTable())) {
            return [];
        }

        return Cache::rememberForever('website.settings', fn (): array => Setting::query()
            ->orderBy('key')
            ->pluck('value', 'key')
            ->all());
    }

    public function get(string $key, ?string $default = null): ?string
    {
        return $this->all()[$key] ?? $default;
    }

    /**
     * @param  array<int, array<string, string>>  $default
     * @return array<int, array<string, string>>
     */
    public function json(string $key, array $default = []): array
    {
        $value = $this->get($key);

        if (! is_string($value)) {
            return $default;
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : $default;
    }

    public function forget(): void
    {
        Cache::forget('website.settings');
    }
}
