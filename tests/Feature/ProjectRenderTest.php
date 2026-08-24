<?php

namespace Tests\Feature;

use App\ContentStatus;
use App\Models\Project;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class ProjectRenderTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_projects_index_view_renders(): void
    {
        Project::factory()->create([
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ]);

        $this->get(route('projects.index'))->assertOk();
    }

    public function test_projects_show_view_renders(): void
    {
        $project = Project::factory()->create([
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ]);

        $this->get(route('projects.show', $project->slug))->assertOk();
    }
}
