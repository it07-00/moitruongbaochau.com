<?php

namespace Tests\Feature;

use App\Filament\Resources\Services\Pages\EditService;
use App\Models\Service;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class ServiceImageUploadTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_admin_can_replace_a_service_thumbnail(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['is_admin' => true]);
        $service = Service::factory()->create(['thumbnail' => null]);
        $replacement = UploadedFile::fake()->image('replacement.png', 1600, 900);

        $this->actingAs($admin);
        Filament::setCurrentPanel(Filament::getPanel('admin'));

        Livewire::test(EditService::class, ['record' => $service->getRouteKey()])
            ->fillForm(['thumbnail' => $replacement])
            ->call('save')
            ->assertHasNoFormErrors();

        $thumbnail = $service->refresh()->thumbnail;

        $this->assertNotNull($thumbnail);
        $this->assertStringStartsWith('uploads/services/', $thumbnail);
        Storage::disk('public')->assertExists($thumbnail);
    }
}
