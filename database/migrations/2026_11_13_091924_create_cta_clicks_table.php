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
        Schema::create('cta_clicks', function (Blueprint $table): void {
            $table->id();
            $table->string('type', 50)->index();
            $table->string('label')->nullable();
            $table->string('target_url', 500)->nullable();
            $table->string('page_url', 500)->nullable()->index();
            $table->string('position', 100)->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cta_clicks');
    }
};
