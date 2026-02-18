<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix any existing questions with incorrect type values
        DB::table('questions')->where('type', 'text')->update(['type' => 'short_text']);
        DB::table('questions')->where('type', 'textarea')->update(['type' => 'long_text']);
        DB::table('questions')->where('type', 'select')->update(['type' => 'dropdown']);
        DB::table('questions')->where('type', 'checkbox')->update(['type' => 'checkboxes']);
        DB::table('questions')->where('type', 'radio')->update(['type' => 'multiple_choice']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    //
    }
};