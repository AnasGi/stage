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
        Schema::create('cnss', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clients_id')->constrained('clients');
            $table->date('date_depot_1')->nullable();
            $table->date('date_depot_2')->nullable();
            $table->date('date_depot_3')->nullable();
            $table->date('date_depot_4')->nullable();
            $table->date('date_depot_5')->nullable();
            $table->date('date_depot_6')->nullable();
            $table->date('date_depot_7')->nullable();
            $table->date('date_depot_8')->nullable();
            $table->date('date_depot_9')->nullable();
            $table->date('date_depot_10')->nullable();
            $table->date('date_depot_11')->nullable();
            $table->date('date_depot_12')->nullable();
            $table->string('motif_1')->nullable();
            $table->string('motif_2')->nullable();
            $table->string('motif_3')->nullable();
            $table->string('motif_4')->nullable();
            $table->string('motif_5')->nullable();
            $table->string('motif_6')->nullable();
            $table->string('motif_7')->nullable();
            $table->string('motif_8')->nullable();
            $table->string('motif_9')->nullable();
            $table->string('motif_10')->nullable();
            $table->string('motif_11')->nullable();
            $table->string('motif_12')->nullable();
            $table->string('annee');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cnss');
    }
};
