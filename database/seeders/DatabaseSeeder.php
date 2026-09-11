<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@moitruongbaochau.com'],
            [
                'name' => 'Administrator',
                'password' => 'Plt212843240@@!',
                'is_admin' => true,
            ]
        );

        $this->call([
            WebsiteSeeder::class,
            SliderSeeder::class,
            TestimonialSeeder::class,
            PartnerSeeder::class,
            SharedContentSettingsSeeder::class,
            ContentTagsAndViewCountSeeder::class,
        ]);
    }
}
