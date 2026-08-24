<?php

namespace App\Models\Concerns;

use App\ContentStatus;
use Illuminate\Database\Eloquent\Builder;

trait HasPublicationStatus
{
    protected function initializeHasPublicationStatus(): void
    {
        $this->mergeCasts([
            'status' => ContentStatus::class,
            'published_at' => 'datetime',
        ]);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', ContentStatus::Published->value)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
}
