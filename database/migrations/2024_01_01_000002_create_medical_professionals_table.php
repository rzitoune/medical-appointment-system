<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_professionals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('specialization');
            $table->string('rpps_number')->unique();
            $table->text('qualifications');
            $table->string('work_address');
            $table->integer('consultation_duration')->default(30); // in minutes
            $table->decimal('consultation_price', 8, 2);
            $table->boolean('is_teleconsultation_available')->default(false);
            $table->json('spoken_languages')->nullable();
            $table->json('accepted_insurance')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_professionals');
    }
};