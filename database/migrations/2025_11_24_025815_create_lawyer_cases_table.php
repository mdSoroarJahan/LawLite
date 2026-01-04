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
        Schema::create('lawyer_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lawyer_id')->constrained('lawyers')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('client_name');
            $table->string('client_email')->nullable();
            $table->string('client_phone')->nullable();
            $table->date('hearing_date')->nullable();
            $table->time('hearing_time')->nullable();
            $table->string('court_location')->nullable();
            $table->string('case_number')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'closed'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lawyer_cases');
    }
};
