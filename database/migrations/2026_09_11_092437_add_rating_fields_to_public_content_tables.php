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
        foreach (['services', 'posts', 'projects', 'job_postings'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table): void {
                $table->decimal('rating_average', 2, 1)->nullable()->after('tags');
                $table->unsignedInteger('rating_count')->default(0)->after('rating_average');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach (['services', 'posts', 'projects', 'job_postings'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table): void {
                $table->dropColumn(['rating_average', 'rating_count']);
            });
        }
    }
};
