<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class AdminAuthorizationTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_guests_are_redirected_and_non_admins_are_forbidden(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));

        $this->actingAs(User::factory()->create(['is_admin' => false]))
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_admin_can_access_dashboard_and_content_management(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
        $this->actingAs($admin)->get(route('admin.content.index', 'pages'))->assertOk();
        $this->actingAs($admin)->get(route('admin.contacts.index'))->assertOk();
    }
}
