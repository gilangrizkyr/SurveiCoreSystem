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
        Schema::create('ai_anomaly_detection', function (Blueprint $table) {
            $table->id();
            $table->foreignId('response_id')->constrained('survey_responses')->cascadeOnDelete();
            $table->enum('anomaly_type', ['speed', 'pattern', 'duplicate']);
            $table->enum('severity', ['low', 'medium', 'high', 'critical'])->default('low');
            $table->text('description')->nullable();
            $table->decimal('confidence_score', 5, 4)->nullable();
            $table->boolean('auto_flagged')->default(false);
            $table->timestamps();

            $table->index('response_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_anomaly_detection');
    }
};