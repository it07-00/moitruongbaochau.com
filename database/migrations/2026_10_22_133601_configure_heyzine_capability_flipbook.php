<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $page = DB::table('pages')->where('slug', 'ho-so-nang-luc')->first();

        if (! $page) {
            return;
        }

        $metadata = json_decode($page->metadata ?? '{}', true, flags: JSON_THROW_ON_ERROR);

        if (! empty($metadata['capability_flipbook_url'])) {
            return;
        }

        DB::table('pages')->where('id', $page->id)->update([
            'metadata' => json_encode([
                ...$metadata,
                'capability_flipbook_url' => 'https://heyzine.com/flip-book/3997d6e66b.html',
            ], JSON_THROW_ON_ERROR),
            'updated_at' => now(),
        ]);
    }

    /**
     * Preserve the link because it may have been edited in the CMS.
     */
    public function down(): void {}
};
