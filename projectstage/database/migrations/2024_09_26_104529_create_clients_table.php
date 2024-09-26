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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->enum('status' , ["PP" , "PM"]);
            $table->string('adresse');
            $table->integer('IF');
            $table->integer('TP');
            $table->bigInteger('ICE');
            $table->integer('CNSS');
            $table->integer('RC');
            $table->date('debut_activite');
            $table->text('activite');
            $table->foreignId('users_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
