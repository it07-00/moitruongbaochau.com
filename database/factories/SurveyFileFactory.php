<?php

namespace Database\Factories;

use App\Models\EnvironmentSurvey;
use App\Models\SurveyFile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SurveyFile>
 */
class SurveyFileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'environment_survey_id' => EnvironmentSurvey::factory(),
            'category' => 'environment_report_2025',
            'original_name' => 'bao-cao-2025.pdf',
            'stored_name' => 'example.pdf',
            'path' => 'environment-surveys/example.pdf',
            'mime_type' => 'application/pdf',
            'size' => 100,
            'uploaded_at' => now(),
        ];
    }
}
