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
        Schema::create('personnel_formations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personnel_id')->constrained('personnels');
            $table->foreignId('formation_id')->constrained('formations');
            $table->date('date_inscription')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnel_formations');
    }
};
