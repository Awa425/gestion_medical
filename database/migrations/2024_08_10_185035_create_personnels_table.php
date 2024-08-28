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
        Schema::create('personnels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('prenom');
            $table->string('adresse')->nullable();
            $table->string('telephone')->nullable();
            $table->string('matricule')->nullable();
            $table->string('CNI')->nullable();
            $table->string('datte_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->date('date_embauche')->nullable();
            $table->boolean('isActive')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnels');
    }
};
