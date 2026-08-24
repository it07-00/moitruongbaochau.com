<?php

namespace Tests\Feature;

use App\Models\Redirect;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class RedirectTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_active_legacy_url_redirects_and_tracks_hits(): void
    {
        $redirect = Redirect::factory()->create([
            'old_path' => '/dich-vu-cu.html',
            'new_path' => '/dich-vu/quan-trac-moi-truong',
            'status_code' => 301,
            'is_active' => true,
        ]);

        $this->get('/dich-vu-cu.html?utm_source=old-site')
            ->assertRedirect('/dich-vu/quan-trac-moi-truong')
            ->assertStatus(301);

        $this->assertSame(1, $redirect->fresh()->hit_count);
        $this->assertNotNull($redirect->fresh()->last_hit_at);
    }

    public function test_inactive_redirect_is_ignored(): void
    {
        Redirect::factory()->create([
            'old_path' => '/khong-chuyen',
            'is_active' => false,
        ]);

        $this->get('/khong-chuyen')->assertNotFound();
    }
}
