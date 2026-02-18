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
        Schema::table('survey_responses', function (Blueprint $table) {
            // Respondent Identity (for anonymous/public surveys)
            $table->string('respondent_name')->nullable()->after('link_id');
            $table->string('respondent_email')->nullable()->after('respondent_name');
            $table->string('respondent_phone')->nullable()->after('respondent_email');
            $table->string('respondent_nik')->nullable()->after('respondent_phone');

            // Additional metadata
            $table->json('metadata')->nullable()->after('flag_reason');

            // Session tracking for duplicate prevention
            $table->string('session_token', 64)->nullable()->after('metadata');
            $table->string('fingerprint', 64)->nullable()->after('session_token');

            // Indexes for duplicate checking
            $table->index('respondent_email');
            $table->index('session_token');
            $table->index(['survey_id', 'respondent_email']);
        });

        // Add settings to surveys table for duplicate prevention
        Schema::table('surveys', function (Blueprint $table) {
            if (!Schema::hasColumn('surveys', 'allow_multiple_submissions')) {
                $table->boolean('allow_multiple_submissions')->default(true)->after('settings');
            }
            if (!Schema::hasColumn('surveys', 'require_respondent_identity')) {
                $table->boolean('require_respondent_identity')->default(false)->after('allow_multiple_submissions');
            }
            if (!Schema::hasColumn('surveys', 'duplicate_prevention_method')) {
                $table->enum('duplicate_prevention_method', ['none', 'cookie', 'email', 'login'])->default('cookie')->after('require_respondent_identity');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survey_responses', function (Blueprint $table) {
            $table->dropIndex(['respondent_email']);
            $table->dropIndex(['session_token']);
            $table->dropIndex(['survey_id', 'respondent_email']);

            $table->dropColumn([
                'respondent_name',
                'respondent_email',
                'respondent_phone',
                'respondent_nik',
                'metadata',
                'session_token',
                'fingerprint',
            ]);
        });

        Schema::table('surveys', function (Blueprint $table) {
            $table->dropColumn([
                'allow_multiple_submissions',
                'require_respondent_identity',
                'duplicate_prevention_method',
            ]);
        });
    }
};