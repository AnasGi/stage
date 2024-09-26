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
        Schema::create('tvam', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clients_id')->constrained('clients');
            $table->string('mois');
            $table->date('date_depot');
            $table->integer('num_depot');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tvam');
    }
};
