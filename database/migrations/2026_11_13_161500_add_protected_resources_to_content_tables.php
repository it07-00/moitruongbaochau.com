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
        foreach (['posts', 'pages', 'services'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table): void {
                $table->string('resource_password', 100)->nullable();
                $table->string('resource_password_hint')->nullable();
                $table->json('shared_resources')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach (['posts', 'pages', 'services'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table): void {
                $table->dropColumn(['resource_password', 'resource_password_hint', 'shared_resources']);
            });
        }
    }
};
