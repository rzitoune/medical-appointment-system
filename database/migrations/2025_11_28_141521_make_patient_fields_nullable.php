<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('insurance_number')->nullable()->change();
            $table->string('mutual_fund')->nullable()->change();
            $table->string('emergency_contact')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('insurance_number')->nullable(false)->change();
            $table->string('mutual_fund')->nullable(false)->change();
            $table->string('emergency_contact')->nullable(false)->change();
        });
    }
};
