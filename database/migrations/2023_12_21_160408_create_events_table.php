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
        Schema::create('activiteiten', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('location');
            $table->string('leeftijdsgroep');
            $table->string('hoofdAnimatoren')->nullable();
            $table->integer('maxAnimatoren');
            $table->integer('beschikbarePlaatsen')->nullable();
            $table->integer('typeActiviteit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activiteiten');
    }
};
