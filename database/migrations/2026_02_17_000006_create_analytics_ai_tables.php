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
        // 1. Survey Statistics (Aggregated)
        Schema::create('survey_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained()->cascadeOnDelete();

            $table->integer('total_views')->default(0);
            $table->integer('total_started')->default(0);
            $table->integer('total_completed')->default(0);
            $table->decimal('completion_rate', 5, 2)->default(0); // %
            $table->decimal('avg_completion_time', 10, 2)->default(0); // seconds

            $table->json('drop_off_points')->nullable();
            $table->json('device_breakdown')->nullable();
            $table->json('location_breakdown')->nullable();

            $table->timestamp('last_calculated_at')->nullable();
            $table->timestamps();

            $table->index('survey_id');
        });

        // 2. Analytics Events (Raw Event Log)
        Schema::create('analytics_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained()->cascadeOnDelete();
            $table->foreignId('response_id')->nullable()->constrained('survey_responses')->nullOnDelete();

            $table->enum('event_type', ['view', 'start', 'answer', 'submit', 'dropoff']);
            $table->foreignId('question_id')->nullable()->constrained('questions')->nullOnDelete();
            $table->json('metadata')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('survey_id');
            $table->index('event_type');
            $table->index('created_at');
        });

        // 3. Analytics Dashboard configuration
        Schema::create('analytics_dashboard', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('survey_id')->nullable()->constrained()->nullOnDelete();
            $table->string('dashboard_type');
            $table->json('data')->nullable(); // Cached dashboard config/data
            $table->timestamp('generated_at')->nullable();
            $table->timestamp('expires_at')->nullable();
        });

        // 4. AI Sentiment Analysis (Detailed)
        Schema::create('ai_sentiment_analysis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('response_id')->constrained('survey_responses')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            $table->foreignId('answer_id')->constrained('response_answers')->cascadeOnDelete();

            $table->text('text_content');
            $table->enum('sentiment', ['positive', 'neutral', 'negative']);
            $table->decimal('confidence_score', 5, 4); // 0-1
            $table->enum('emotion', ['joy', 'sadness', 'anger', 'fear', 'surprise', 'neutral'])->nullable();

            $table->timestamp('processed_at')->useCurrent();
            $table->timestamps();

            $table->index('response_id');
            $table->index('sentiment');
        });

        // 5. AI Keyword Extraction
        Schema::create('ai_keyword_extraction', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained()->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            $table->string('keyword');
            $table->integer('frequency')->default(1);
            $table->decimal('relevance_score', 5, 4)->nullable();
            $table->string('category')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('survey_id');
            $table->index('keyword');
        });

        // 6. AI Insights
        Schema::create('ai_insights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained()->cascadeOnDelete();
            $table->enum('insight_type', ['summary', 'recommendation', 'trend']);
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('data')->nullable(); // Supporting data points
            $table->decimal('confidence_score', 5, 4)->nullable();
            $table->timestamp('generated_at')->useCurrent();
            $table->timestamps();
        });

        // 7. AI Chat Conversations
        Schema::create('ai_chat_conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('session_id')->index();
            $table->text('message'); // User message
            $table->text('response'); // AI response
            $table->json('context')->nullable();
            $table->string('intent')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_chat_conversations');
        Schema::dropIfExists('ai_insights');
        Schema::dropIfExists('ai_keyword_extraction');
        Schema::dropIfExists('ai_sentiment_analysis');
        Schema::dropIfExists('analytics_dashboard');
        Schema::dropIfExists('analytics_events');
        Schema::dropIfExists('survey_statistics');
    }
};