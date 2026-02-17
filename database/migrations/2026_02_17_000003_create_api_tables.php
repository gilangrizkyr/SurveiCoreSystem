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
        // 1. API Clients - For external applications using OAuth2 or similar
        Schema::create('api_clients', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('client_id', 100)->unique();
            $table->string('client_secret'); // Hashed
            $table->json('redirect_uris')->nullable();
            $table->enum('tier', ['free', 'basic', 'premium', 'enterprise'])->default('free');
            $table->enum('status', ['active', 'suspended', 'revoked'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->index('client_id');
            $table->index('tenant_id');
            $table->index('status');
        });

        // 2. API Keys - For direct API access
        Schema::create('api_keys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('api_clients')->cascadeOnDelete();
            $table->string('key', 100)->unique();
            $table->string('secret'); // For HMAC
            $table->string('name');
            $table->json('scopes')->nullable();
            $table->json('ip_whitelist')->nullable();
            $table->integer('rate_limit')->default(1000); // Requests per hour
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('revoked_at')->nullable();
            $table->timestamps();

            $table->index('key');
            $table->index('client_id');
            $table->index('expires_at');
        });

        // 3. API Usage Logs
        Schema::create('api_usage_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('api_clients')->cascadeOnDelete();
            $table->foreignId('api_key_id')->nullable()->constrained('api_keys')->nullOnDelete();
            $table->string('endpoint');
            $table->string('method');
            $table->integer('status_code');
            $table->integer('response_time'); // ms
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('request_signature')->nullable();
            $table->timestamps();

            $table->index(['client_id', 'created_at']);
        });

        // 4. Custom Rate Limits
        Schema::create('rate_limits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('api_clients')->cascadeOnDelete();
            $table->string('endpoint');
            $table->integer('max_requests');
            $table->integer('window_seconds')->default(60);
            $table->timestamps();

            $table->unique(['client_id', 'endpoint']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rate_limits');
        Schema::dropIfExists('api_usage_logs');
        Schema::dropIfExists('api_keys');
        Schema::dropIfExists('api_clients');
    }
};