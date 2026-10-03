<?php

namespace Database\Seeders;

use App\Models\EnvironmentSurvey;
use Illuminate\Database\Seeder;

class EnvironmentSurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EnvironmentSurvey::query()->firstOrCreate(['reference' => '01K6KYNK000000000000000001'], [
            'company_name' => 'Doanh nghiệp mẫu BVMT 2026',
            'data' => ['company_name' => 'Doanh nghiệp mẫu BVMT 2026'],
            'history' => [['action' => 'created', 'at' => now()->toIso8601String(), 'actor' => 'demo_seeder']],
        ]);
    }
}
