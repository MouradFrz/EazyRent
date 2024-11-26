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
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreign(['clientUsername'], 'bookings_ibfk_3')->references(['username'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['vehiculePlateNb'], 'bookings_ibfk_4')->references(['plateNb'])->on('vehicules')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['secretaryUsername'], 'bookings_ibfk_5')->references(['username'])->on('secretaries')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['pickUpLocation'], 'bookings_ibfk_6')->references(['id'])->on('pickuplocations')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['dropOffLocation'], 'bookings_ibfk_7')->references(['id'])->on('pickuplocations')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign('bookings_ibfk_3');
            $table->dropForeign('bookings_ibfk_4');
            $table->dropForeign('bookings_ibfk_5');
            $table->dropForeign('bookings_ibfk_6');
            $table->dropForeign('bookings_ibfk_7');
        });
    }
};
