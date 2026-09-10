<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = ['services', 'posts', 'projects', 'job_postings'];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    if (! Schema::hasColumn($tableName, 'view_count')) {
                        $table->unsignedBigInteger('view_count')->default(0)->after('status');
                    }
                    if (! Schema::hasColumn($tableName, 'tags')) {
                        $table->json('tags')->nullable()->after('view_count');
                    }
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['services', 'posts', 'projects', 'job_postings'];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    $columns = [];
                    if (Schema::hasColumn($tableName, 'tags')) {
                        $columns[] = 'tags';
                    }
                    if (Schema::hasColumn($tableName, 'view_count')) {
                        $columns[] = 'view_count';
                    }
                    if (! empty($columns)) {
                        $table->dropColumn($columns);
                    }
                });
            }
        }
    }
};
