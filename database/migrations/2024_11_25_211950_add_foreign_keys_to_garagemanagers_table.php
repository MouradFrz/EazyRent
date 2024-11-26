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
        Schema::table('garagemanagers', function (Blueprint $table) {
            $table->foreign(['brancheID'], 'garagemanagers_ibfk_1')->references(['brancheID'])->on('branches')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('garagemanagers', function (Blueprint $table) {
            $table->dropForeign('garagemanagers_ibfk_1');
        });
    }
};
