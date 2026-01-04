<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lawyers', function (Blueprint $table) {
            $table->json('education')->nullable();
            $table->json('experience')->nullable();
            $table->json('languages')->nullable();
            $table->string('bar_council_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lawyers', function (Blueprint $table) {
            $table->dropColumn(['education', 'experience', 'languages', 'bar_council_id']);
        });
    }
};
