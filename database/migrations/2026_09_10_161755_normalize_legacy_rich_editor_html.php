<?php

use App\Support\RichContentNormalizer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        foreach ([
            'services' => ['content'],
            'posts' => ['content'],
            'projects' => ['content'],
            'pages' => ['content'],
            'job_postings' => ['content', 'requirements', 'benefits'],
        ] as $table => $columns) {
            foreach ($columns as $column) {
                DB::table($table)
                    ->whereNotNull($column)
                    ->where($column, 'like', '%<figure%')
                    ->orderBy('id')
                    ->chunkById(100, function ($records) use ($column, $table): void {
                        foreach ($records as $record) {
                            DB::table($table)
                                ->where('id', $record->id)
                                ->update([
                                    $column => RichContentNormalizer::normalizeLegacyFigures($record->{$column}),
                                ]);
                        }
                    });
            }
        }
    }

    public function down(): void
    {
        // The normalization preserves rendered content and is intentionally irreversible.
    }
};
