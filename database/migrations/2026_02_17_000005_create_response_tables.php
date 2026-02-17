<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Survey Responses (Session/Submission)
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('survey_id')->constrained()->cascadeOnDelete();
            $table->foreignId('respondent_id')->nullable()->constrained('users')->nullOnDelete(); // If known user
            $table->foreignId('link_id')->nullable()->constrained('survey_links')->nullOnDelete();

            $table->enum('status', ['draft', 'completed', 'validated', 'flagged'])->default('draft');

            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('submitted_at')->nullable();
            $table->integer('completion_time_seconds')->nullable();

            // Tracking
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->enum('device_type', ['desktop', 'mobile', 'tablet', 'unknown'])->nullable();
            $table->json('geo_location')->nullable();

            // Quality Control
            $table->decimal('quality_score', 5, 2)->nullable(); // 0-100
            $table->boolean('is_flagged')->default(false);
            $table->string('flag_reason', 500)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('survey_id');
            $table->index('status');
            $table->index('submitted_at');
            $table->index('respondent_id');
        });

        // 2. Response Answers (Individual Data Points)
        Schema::create('response_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('response_id')->constrained('survey_responses')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            $table->foreignId('option_id')->nullable()->constrained('question_options')->nullOnDelete();

            $table->text('answer_text')->nullable();
            $table->decimal('answer_numeric', 15, 4)->nullable();
            $table->date('answer_date')->nullable();
            $table->foreignId('answer_file_id')->nullable(); // Reference to response_files

            $table->json('metadata')->nullable();

            $table->timestamps();

            $table->index(['response_id', 'question_id']);
        });

        // 3. Response Files (Uploads)
        Schema::create('response_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('response_id')->constrained('survey_responses')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();

            $table->string('filename');
            $table->string('file_path');
            $table->integer('file_size'); // bytes
            $table->string('mime_type');
            $table->boolean('is_scanned')->default(false);
            $table->string('scan_result')->nullable();

            $table->timestamps();

            $table->index('response_id');
        });

        // 4. Response Analytics (Calculated Metrics per Response)
        Schema::create('response_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('response_id')->constrained('survey_responses')->cascadeOnDelete();

            $table->decimal('sentiment_score', 5, 4)->nullable(); // -1 to 1 or 0-1
            $table->json('keywords')->nullable();
            $table->decimal('anomaly_score', 5, 4)->nullable();
            $table->decimal('fraud_probability', 5, 4)->nullable();
            $table->json('quality_metrics')->nullable();

            $table->timestamps();

            $table->index('response_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('response_analytics');
        Schema::dropIfExists('response_files');
        Schema::dropIfExists('response_answers');
        Schema::dropIfExists('survey_responses');
    }
};