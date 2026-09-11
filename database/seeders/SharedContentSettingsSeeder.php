<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SharedContentSettingsSeeder extends Seeder
{
    /**
     * Seed shared content values without overwriting administrator changes.
     */
    public function run(): void
    {
        foreach ($this->settings() as $key => $setting) {
            Setting::query()->firstOrCreate(
                ['key' => $key],
                $setting,
            );
        }
    }

    /**
     * @return array<string, array{value: string, type: string, group: string}>
     */
    private function settings(): array
    {
        return [
            'seo_locale' => [
                'value' => 'vi_VN',
                'type' => 'string',
                'group' => 'seo',
            ],
            'content_editor_name' => [
                'value' => 'Ban Biên Tập Kỹ Thuật Môi Trường Bảo Châu',
                'type' => 'string',
                'group' => 'content',
            ],
            'content_editor_bio' => [
                'value' => 'Đội ngũ Thạc sĩ, Kỹ sư Môi trường với hơn 10 năm kinh nghiệm trong tư vấn hồ sơ môi trường và giải pháp kỹ thuật tại Việt Nam.',
                'type' => 'string',
                'group' => 'content',
            ],
            'content_editor_logo' => [
                'value' => 'assets/images/logo-leave-png-min.png',
                'type' => 'string',
                'group' => 'content',
            ],
            'footer_sales_contacts' => [
                'value' => json_encode([
                    ['phone' => '0915 219 148', 'name' => 'Ms. Nhật Quỳnh'],
                    ['phone' => '0915 549 148', 'name' => 'Ms. San San'],
                    ['phone' => '094 224 1148', 'name' => 'Ms. Thanh Thảo'],
                    ['phone' => '0917 283 148', 'name' => 'Ms. Tường Vy'],
                ], JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR),
                'type' => 'json',
                'group' => 'contact',
            ],
            'footer_consulting_contacts' => [
                'value' => json_encode([
                    ['phone' => '0917 297 338', 'name' => 'Ms. Mỹ Trân'],
                ], JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR),
                'type' => 'json',
                'group' => 'contact',
            ],
            'phone_2' => [
                'value' => '0915 219 148',
                'type' => 'string',
                'group' => 'contact',
            ],
            'phone_support' => [
                'value' => '0915 219 148',
                'type' => 'string',
                'group' => 'contact',
            ],
            'hr_contact_name' => [
                'value' => 'Ms. San San - HR Manager',
                'type' => 'string',
                'group' => 'contact',
            ],
            'hr_contact_phone' => [
                'value' => '0915 549 148',
                'type' => 'string',
                'group' => 'contact',
            ],
        ];
    }
}
