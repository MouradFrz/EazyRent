<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicules', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('type')->nullable();
            $table->string('color')->nullable();
            $table->string('year')->nullable();
            $table->string('fuel')->nullable();
            $table->string('gearType')->nullable();
            $table->integer('doorsNb')->nullable();
            $table->tinyInteger('airCooling')->nullable();
            $table->string('physicalState')->nullable();
            $table->smallInteger('rating')->nullable();
            $table->string('category')->nullable();
            $table->string('pricePerHour')->nullable();
            $table->string('pricePerDay')->nullable();
            $table->integer('garageID')->nullable()->index('garageID');
            $table->string('imagePath')->nullable();
            $table->string('addedBy')->nullable()->index('addedBy');
            $table->string('plateNb')->nullable()->unique('plateNb');
            $table->integer('horsePower');
            $table->tinyInteger('availability');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicules');
    }
};
