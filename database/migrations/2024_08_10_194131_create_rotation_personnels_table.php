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
        Schema::create('rotation_personnels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personnel_id')->constrained('personnels');
            $table->foreignId('horaire_travail_id')->constrained('horaire_travails');
            $table->date('date_affectation');
            $table->text('commentaires')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rotation_personnels');
    }
};
