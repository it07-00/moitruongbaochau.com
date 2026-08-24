<?php

namespace Tests\Feature;

use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_admin_login_page_is_accessible(): void
    {
        $this->get(route('filament.admin.auth.login'))->assertOk();
    }

    public function test_admin_user_can_access_filament_panel(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@baochauenvir.com',
            'is_admin' => true,
        ]);

        $panel = Filament::getPanel('admin');
        $this->assertTrue($admin->canAccessPanel($panel));

        $this->actingAs($admin)
            ->get(route('filament.admin.pages.dashboard'))
            ->assertOk();
    }

    public function test_non_admin_cannot_access_filament_panel(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
        ]);

        $panel = Filament::getPanel('admin');
        $this->assertFalse($user->canAccessPanel($panel));

        $this->actingAs($user)
            ->get(route('filament.admin.pages.dashboard'))
            ->assertForbidden();
    }
}
