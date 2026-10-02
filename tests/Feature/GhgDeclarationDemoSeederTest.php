<?php

namespace Tests\Feature;

use App\Models\GhgDeclaration;
use App\Support\GhgSurveyDefinition;
use Database\Seeders\GhgDeclarationDemoSeeder;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class GhgDeclarationDemoSeederTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_seeder_adds_complete_records_and_preserves_existing_data(): void
    {
        Storage::fake('local');
        $existing = GhgDeclaration::factory()->create();
        $this->seed(GhgDeclarationDemoSeeder::class);
        $samples = GhgDeclaration::query()->where('company_name', 'like', '[DỮ LIỆU MẪU]%')->get();
        $this->assertCount(3, $samples);
        $this->assertSame(2, $samples->where('status', 'submitted')->count());
        $this->assertSame(1, $samples->where('status', 'draft')->count());
        foreach ($samples as $record) {
            foreach (range(1, 6) as $step) {
                $this->assertFalse(Validator::make(['data' => $record->data[$step]], GhgSurveyDefinition::rules($step))->fails());
                if ($step > 1) {
                    foreach (GhgSurveyDefinition::sections($step) as $key => $section) {
                        $this->assertNotEmpty($record->data[$step][$key]);
                        if ($section['monthly']) {
                            $this->assertCount(12, $record->data[$step][$key]);
                        }
                    }
                }
            }
            $this->assertSame(7, $record->current_step);
            $this->assertSame($record->status === 'submitted', $record->submitted_at !== null);
            Storage::disk('local')->assertExists($record->evidence[0]['path']);
            $this->assertStringStartsWith('%PDF-1.4', Storage::disk('local')->get($record->evidence[0]['path']));
        }
        $sample = $samples->first();
        $sample->update(['company_name' => 'Tên đã sửa']);
        $this->seed(GhgDeclarationDemoSeeder::class);
        $this->assertSame(4, GhgDeclaration::query()->count());
        $this->assertSame('Tên đã sửa', $sample->refresh()->company_name);
        $this->assertModelExists($existing);
        $this->assertCount(3, Storage::disk('local')->allFiles());
    }
}
