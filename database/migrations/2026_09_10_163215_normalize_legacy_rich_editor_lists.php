<?php

use App\Support\RichContentNormalizer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $this->normalizeTable('services', ['content']);
        $this->normalizeTable('posts', ['content']);
        $this->normalizeTable('projects', ['content']);
        $this->normalizeTable('pages', ['content']);
        $this->normalizeTable('job_postings', ['content', 'requirements', 'benefits']);
    }

    public function down(): void
    {
        // Normalized HTML remains semantically equivalent and should not be reverted.
    }

    /**
     * @param  array<int, string>  $columns
     */
    private function normalizeTable(string $table, array $columns): void
    {
        DB::table($table)
            ->select(['id', ...$columns])
            ->orderBy('id')
            ->chunkById(100, function ($records) use ($table, $columns): void {
                foreach ($records as $record) {
                    $updates = [];

                    foreach ($columns as $column) {
                        $normalized = RichContentNormalizer::normalize($record->{$column});

                        if ($normalized !== $record->{$column}) {
                            $updates[$column] = $normalized;
                        }
                    }

                    if ($updates !== []) {
                        DB::table($table)->where('id', $record->id)->update($updates);
                    }
                }
            });
    }
};
