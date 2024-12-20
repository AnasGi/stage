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
            $table->string('code');
            $table->string('nom');
            $table->string('status')->nullable();
            $table->string('adresse')->nullable();
            $table->string('IF')->nullable();
            $table->string('TP')->nullable();
            $table->string('ICE')->nullable();
            $table->string('CNSS')->nullable();
            $table->string('RC')->nullable();
            $table->date('debut_activite')->nullable();
            $table->text('activite')->nullable();
            $table->string('ville')->nullable();
            $table->foreignId('users_id')->constrained('users');
            $table->string('deletetype')->nullable();
            $table->string('motif')->nullable();
            $table->string('motifdoc')->nullable();
            $table->string('newCltMotif')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
