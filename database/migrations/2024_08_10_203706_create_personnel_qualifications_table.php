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
        Schema::create('personnel_qualifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personnel_id')->constrained('personnels')->onDelete('cascade');
            $table->foreignId('qualification_id')->constrained('qualifications')->onDelete('cascade');
            $table->date('date_obtention')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnel_qualifications');
    }
};
