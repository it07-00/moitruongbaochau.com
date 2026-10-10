<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table): void {
            $table->uuid('sheets_sync_key')->nullable()->unique();
            $table->json('sheets_payload')->nullable();
            $table->timestamp('sheets_synced_at')->nullable()->index();
            $table->timestamp('sheets_last_attempt_at')->nullable();
            $table->string('sheets_sync_error', 32)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table): void {
            $table->dropUnique(['sheets_sync_key']);
            $table->dropIndex(['sheets_synced_at']);
            $table->dropColumn(['sheets_sync_key', 'sheets_payload', 'sheets_synced_at', 'sheets_last_attempt_at', 'sheets_sync_error']);
        });
    }
};
