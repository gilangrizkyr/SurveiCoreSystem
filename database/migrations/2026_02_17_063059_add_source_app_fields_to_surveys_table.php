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
        Schema::table('surveys', function (Blueprint $table) {
            $table->string('source_app_name')->nullable()->after('theme_id');
            $table->string('source_app_url')->nullable()->after('source_app_name');
            $table->text('usage_context')->nullable()->after('source_app_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surveys', function (Blueprint $table) {
            $table->dropColumn(['source_app_name', 'source_app_url', 'usage_context']);
        });
    }
};