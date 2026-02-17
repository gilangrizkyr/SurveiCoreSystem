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
        // 1. Tenants Table
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('domain')->unique()->nullable();
            $table->string('database')->nullable();
            $table->json('settings')->nullable();
            $table->enum('status', ['active', 'suspended'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->index('uuid');
            $table->index('slug');
            $table->index('domain');
            $table->index('status');
        });

        // 2. Tenant User Pivot (Assuming users can belong to multiple tenants)
        Schema::create('tenant_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->json('roles')->nullable(); // Tenant specific roles
            $table->timestamps();

            $table->unique(['tenant_id', 'user_id']);
            $table->index('tenant_id');
            $table->index('user_id');
        });

        // 3. Tenant Settings
        Schema::create('tenant_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->string('key');
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, boolean, integer, json
            $table->timestamps();

            $table->unique(['tenant_id', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_settings');
        Schema::dropIfExists('tenant_user');
        Schema::dropIfExists('tenants');
    }
};