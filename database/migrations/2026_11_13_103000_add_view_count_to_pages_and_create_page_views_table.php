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
        if (! Schema::hasColumn('pages', 'view_count')) {
            Schema::table('pages', function (Blueprint $table): void {
                $table->unsignedInteger('view_count')->default(0)->after('published_at');
            });
        }

        Schema::create('page_views', function (Blueprint $table): void {
            $table->id();
            $table->nullableMorphs('viewable');
            $table->string('page_key', 150)->index();
            $table->string('page_type', 50)->default('page')->index();
            $table->string('page_title')->nullable();
            $table->string('page_url', 500)->index();
            $table->string('referrer', 500)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('session_id', 100)->nullable()->index();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_views');

        if (Schema::hasColumn('pages', 'view_count')) {
            Schema::table('pages', function (Blueprint $table): void {
                $table->dropColumn('view_count');
            });
        }
    }
};
