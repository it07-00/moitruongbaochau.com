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
        Schema::create('ghg_declarations', function (Blueprint $table) {
            $table->id();
            $table->ulid('reference')->unique();
            $table->string('company_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('status', 24)->default('draft')->index();
            $table->unsignedTinyInteger('current_step')->default(1);
            $table->json('data')->nullable();
            $table->json('evidence')->nullable();
            $table->timestamp('submitted_at')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ghg_declarations');
    }
};
