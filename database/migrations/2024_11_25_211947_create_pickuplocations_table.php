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
        Schema::create('pickuplocations', function (Blueprint $table) {
            $table->integer('brancheID')->nullable()->index('brancheID');
            $table->string('added_by')->nullable();
            $table->string('address_address')->nullable();
            $table->string('address_longitude')->nullable();
            $table->string('address_latitude')->nullable();
            $table->timestamps();
            $table->integer('id', true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pickuplocations');
    }
};
