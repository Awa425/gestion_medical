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
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('specialite_id');
                $table->foreign('specialite_id')
                      ->references('id')
                      ->on('specialites')
                      ->onDelete('cascade')
                      ->nullable();
            });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('specialite_id');
        });
    }
};
