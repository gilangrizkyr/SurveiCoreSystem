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
        // 1. Webhooks
        Schema::create('webhooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('survey_id')->nullable()->constrained()->cascadeOnDelete();

            $table->string('url');
            $table->json('events'); // ['response.completed', 'survey.published']
            $table->string('secret')->nullable(); // HMAC secret

            $table->boolean('is_active')->default(true);
            $table->integer('retry_limit')->default(3);
            $table->integer('timeout_seconds')->default(5);

            $table->timestamps();
            $table->softDeletes();

            $table->index('tenant_id');
        });

        // 2. Webhook Logs
        Schema::create('webhook_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('webhook_id')->constrained()->cascadeOnDelete();
            $table->string('event');
            $table->json('payload')->nullable();

            $table->integer('status_code')->nullable();
            $table->text('response_body')->nullable();
            $table->integer('attempt_number')->default(1);

            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamps();

            $table->index('webhook_id');
            $table->index('event');
        });

        // 3. Third-party Integrations
        Schema::create('integrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['slack', 'zapier', 'sheets', 'email', 'sms']);
            $table->text('credentials')->nullable(); // Encrypted
            $table->json('settings')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('tenant_id');
            $table->index('type');
        });

        // 4. Audit Logs
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->string('action'); // create, update, delete
            $table->string('model_type'); // App\Models\User
            $table->unsignedBigInteger('model_id')->nullable();

            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();

            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();

            $table->timestamp('created_at')->useCurrent();

            $table->index(['model_type', 'model_id']);
            $table->index('user_id');
            $table->index('created_at');
        });

        // 5. Data Retention Policies
        Schema::create('data_retention_policies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->string('data_type'); // responses, logs
            $table->integer('retention_days');
            $table->boolean('auto_delete')->default(false);
            $table->timestamp('last_cleanup_at')->nullable();
            $table->timestamps();
        });

        // 6. Consent Records (GDPR)
        Schema::create('consent_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained()->cascadeOnDelete();
            $table->foreignId('response_id')->nullable()->constrained('survey_responses')->nullOnDelete();

            $table->string('consent_type'); // terms, marketing
            $table->boolean('given')->default(false);
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consent_records');
        Schema::dropIfExists('data_retention_policies');
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('integrations');
        Schema::dropIfExists('webhook_logs');
        Schema::dropIfExists('webhooks');
    }
};