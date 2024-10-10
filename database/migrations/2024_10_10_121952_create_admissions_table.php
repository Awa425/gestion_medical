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
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dossierMedical_id')->constrained('dossier_medicals')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');  
             $table->string('motif_admission');
            $table->date('date_admission');
            $table->enum('etat_admission', ['en cours', 'termine'])->default('en cours');
            $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
