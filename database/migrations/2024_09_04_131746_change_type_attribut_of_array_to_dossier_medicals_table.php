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
        Schema::table('dossier_medicals', function (Blueprint $table) {
            $table->json('traitements')->nullable()->change();
            $table->json('diagnostics')->nullable()->change();
            $table->json('antecedents')->nullable()->change();
            $table->json('prescriptions')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dossier_medicals', function (Blueprint $table) {
            //
        });
    }
};
