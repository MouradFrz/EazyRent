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
        Schema::create('bookings', function (Blueprint $table) {
            $table->integer('bookingID')->primary();
            $table->string('state')->nullable();
            $table->tinyInteger('isPaid')->nullable();
            $table->string('payementMethod')->nullable();
            $table->integer('pickUpLocation')->nullable()->index('pickUpLocation');
            $table->integer('dropOffLocation')->nullable()->index('dropOffLocation');
            $table->date('pickUpDate')->nullable();
            $table->date('dropOffDate')->nullable();
            $table->string('clientUsername')->nullable()->index('bookings_ibfk_3');
            $table->string('vehiculePlateNb')->nullable()->index('bookings_ibfk_4');
            $table->string('bookingPrice')->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->integer('vehiculeRating');
            $table->integer('vehiculeComment');
            $table->date('commentDate');
            $table->tinyInteger('failedSeen');
            $table->string('secretaryUsername')->nullable()->index('secretaryUsername');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
