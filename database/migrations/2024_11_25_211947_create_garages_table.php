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
        Schema::create('garages', function (Blueprint $table) {
            $table->integer('garageID', true);
            $table->string('address')->nullable();
            $table->mediumInteger('capacity')->nullable();
            $table->integer('brancheID')->nullable()->index('brancheID');
            $table->string('garageManagerUsername')->nullable();
            $table->integer('vehiculesNb');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('garages');
    }
};
