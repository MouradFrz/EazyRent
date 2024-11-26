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
        Schema::table('vehicules', function (Blueprint $table) {
            $table->foreign(['addedBy'], 'vehicules_ibfk_2')->references(['username'])->on('secretaries')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['garageID'], 'vehicules_ibfk_3')->references(['garageID'])->on('garages')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicules', function (Blueprint $table) {
            $table->dropForeign('vehicules_ibfk_2');
            $table->dropForeign('vehicules_ibfk_3');
        });
    }
};
