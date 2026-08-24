<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_admin_can_login_and_logout_with_session_regeneration(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('VerySecurePassword123!'),
            'is_admin' => true,
        ]);

        $this->get(route('admin.login'))->assertOk();

        $this->post(route('admin.login.store'), [
            'email' => $admin->email,
            'password' => 'VerySecurePassword123!',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($admin);

        $this->post(route('admin.logout'))->assertRedirect(route('home'));
        $this->assertGuest();
    }

    public function test_non_admin_credentials_cannot_open_an_admin_session(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('VerySecurePassword123!'),
            'is_admin' => false,
        ]);

        $this->from(route('admin.login'))->post(route('admin.login.store'), [
            'email' => $user->email,
            'password' => 'VerySecurePassword123!',
        ])->assertRedirect(route('admin.login'))->assertSessionHasErrors('email');

        $this->assertGuest();
    }
}
