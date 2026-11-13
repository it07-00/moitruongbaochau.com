<?php

namespace Database\Factories;

use App\CtaType;
use App\Models\CtaClick;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CtaClick>
 */
class CtaClickFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement([
                CtaType::Hotline,
                CtaType::Zalo,
                CtaType::Consultation,
                CtaType::Pdf,
                CtaType::Map,
                CtaType::FormSubmit,
            ]),
            'label' => fake()->randomElement([
                'Hotline: 0915 549 148',
                'Tư vấn Zalo',
                'Nhận tư vấn ngay',
                'Tải hồ sơ năng lực',
                'Chỉ đường Google Maps',
            ]),
            'target_url' => 'tel:0915549148',
            'page_url' => '/',
            'position' => fake()->randomElement(['header', 'floating', 'cta_section', 'footer', 'content']),
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
            'metadata' => null,
        ];
    }
}
