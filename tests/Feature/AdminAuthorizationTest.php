<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class AdminAuthorizationTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_guests_are_redirected_to_filament_login(): void
    {
        $this->get(route('filament.admin.pages.dashboard'))
            ->assertRedirect(route('filament.admin.auth.login'));
    }

    public function test_admin_can_access_dashboard_and_resources(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)->get(route('filament.admin.pages.dashboard'))->assertOk();
        $this->actingAs($admin)->get(route('filament.admin.resources.services.index'))->assertOk();
        $this->actingAs($admin)->get(route('filament.admin.resources.posts.index'))->assertOk();
        $this->actingAs($admin)->get(route('filament.admin.resources.projects.index'))->assertOk();
        $this->actingAs($admin)->get(route('filament.admin.resources.pages.index'))->assertOk();
        $this->actingAs($admin)->get(route('filament.admin.resources.contacts.index'))->assertOk();
    }
}
