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
        // 1. Survey Templates
        Schema::create('survey_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained()->cascadeOnDelete(); // Nullable for system templates
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->json('structure')->nullable();
            $table->boolean('is_public')->default(false);
            $table->timestamps();

            $table->index('category');
        });

        // 2. Survey Themes
        Schema::create('survey_themes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('primary_color')->default('#000000');
            $table->string('secondary_color')->default('#ffffff');
            $table->string('font_family')->default('sans-serif');
            $table->string('logo_url')->nullable();
            $table->string('background_image')->nullable();
            $table->text('custom_css')->nullable();
            $table->timestamps();
        });

        // 3. Surveys
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('creator_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('template_id')->nullable()->constrained('survey_templates')->nullOnDelete();
            $table->foreignId('theme_id')->nullable()->constrained('survey_themes')->nullOnDelete();

            $table->string('title', 500);
            $table->text('description')->nullable();
            $table->text('welcome_message')->nullable();
            $table->text('thank_you_message')->nullable();

            $table->enum('status', ['draft', 'active', 'paused', 'closed', 'archived'])->default('draft');
            $table->enum('type', ['public', 'private', 'embedded', 'api_only'])->default('public');

            $table->json('settings')->nullable(); // {allow_multiple_submissions, show_progress_bar...}
            $table->json('metadata')->nullable(); // {category, tags...}

            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('tenant_id');
            $table->index('status');
            $table->fullText(['title', 'description']);
        });

        // 4. Survey Sections
        Schema::create('survey_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained()->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->json('logic')->nullable(); // Section level logic
            $table->timestamps();

            $table->index('survey_id');
            $table->index('order');
        });

        // 5. Questions
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('survey_sections')->cascadeOnDelete();
            $table->enum('type', [
                'short_text', 'long_text', 'multiple_choice', 'checkboxes',
                'dropdown', 'rating', 'star_rating', 'nps', 'matrix',
                'file_upload', 'date', 'time', 'datetime', 'linear_scale',
                'email', 'phone', 'url', 'number', 'hidden', 'calculated'
            ]);

            $table->string('title', 1000); // Question text
            $table->text('description')->nullable();
            $table->string('placeholder')->nullable();
            $table->text('help_text')->nullable();

            $table->boolean('is_required')->default(false);
            $table->integer('order')->default(0);

            $table->json('validation_rules')->nullable();
            $table->json('logic_rules')->nullable();
            $table->json('metadata')->nullable();

            $table->timestamps();

            $table->index('section_id');
            $table->index('type');
            $table->index('order');
        });

        // 6. Question Options (for choice/dropdown)
        Schema::create('question_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->string('label');
            $table->string('value');
            $table->integer('order')->default(0);
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            $table->index('question_id');
        });

        // 7. Question Logic (Branching)
        Schema::create('question_logic', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->string('condition_type'); // show, hide, jump
            $table->foreignId('source_question_id')->nullable()->constrained('questions')->cascadeOnDelete();
            $table->string('operator'); // equals, contains, etc
            $table->text('value')->nullable();
            $table->foreignId('target_question_id')->nullable()->constrained('questions')->cascadeOnDelete();
            $table->timestamps();
        });

        // 8. Survey Distributions
        Schema::create('survey_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained()->cascadeOnDelete();
            $table->enum('channel', ['link', 'embed', 'api', 'email', 'sms']);
            $table->json('settings')->nullable();
            $table->timestamps();

            $table->index('survey_id');
        });

        // 9. Survey Links
        Schema::create('survey_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distribution_id')->constrained('survey_distributions')->cascadeOnDelete();
            $table->string('token')->unique();
            $table->integer('max_responses')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->integer('used_count')->default(0);
            $table->timestamps();

            $table->index('token');
        });

        // 10. Survey Quotas
        Schema::create('survey_quotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained()->cascadeOnDelete();
            $table->integer('max_responses')->default(0);
            $table->integer('current_count')->default(0);
            $table->json('demographic_limits')->nullable();
            $table->timestamps();

            $table->index('survey_id');
        });

        // 11. Survey Schedules
        Schema::create('survey_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained()->cascadeOnDelete();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->string('timezone')->default('UTC');
            $table->json('recurrence')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('survey_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_schedules');
        Schema::dropIfExists('survey_quotas');
        Schema::dropIfExists('survey_links');
        Schema::dropIfExists('survey_distributions');
        Schema::dropIfExists('question_logic');
        Schema::dropIfExists('question_options');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('survey_sections');
        Schema::dropIfExists('surveys');
        Schema::dropIfExists('survey_themes');
        Schema::dropIfExists('survey_templates');
    }
};