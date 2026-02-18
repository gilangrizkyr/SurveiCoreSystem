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
        Schema::create('ai_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name');
            $table->text('value')->nullable();
            $table->string('category')->default('persona');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Seed initial data
        DB::table('ai_settings')->insert([
            [
                'key' => 'system_prompt',
                'name' => 'System Instruction (Persona)',
                'value' => 'Anda adalah BumbuAI, asisten profesional DPMPTSP Tanah Bumbu...',
                'category' => 'persona',
                'description' => 'Instruksi utama yang menentukan gaya bahasa dan identitas AI.',
            ],
            [
                'key' => 'security_rules',
                'name' => 'Data Protection Rules',
                'value' => 'JANGAN PERNAH memberikan PII (Nama, Email, HP) responden.',
                'category' => 'security',
                'description' => 'Aturan ketat untuk melindungi privasi data.',
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_settings');
    }
};