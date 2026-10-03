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
        Schema::create('environment_surveys', function (Blueprint $table) {
            $table->id();
            $table->ulid('reference')->unique();
            $table->string('token', 64)->unique();
            $table->string('company_name')->nullable()->index();
            $table->string('contact_email')->nullable();
            $table->string('status', 24)->default('draft')->index();
            $table->unsignedTinyInteger('current_step')->default(1);
            $table->json('data')->nullable();
            $table->json('history')->nullable();
            $table->timestamp('submitted_at')->nullable()->index();
            $table->timestamps();
        });
        Schema::create('survey_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_survey_id')->constrained()->cascadeOnDelete();
            $table->string('category', 64)->index();
            $table->string('original_name');
            $table->string('stored_name');
            $table->string('path');
            $table->string('mime_type');
            $table->unsignedBigInteger('size');
            $table->timestamp('uploaded_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_files');
        Schema::dropIfExists('environment_surveys');
    }
};
