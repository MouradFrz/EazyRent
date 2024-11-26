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
        Schema::table('complaints', function (Blueprint $table) {
            $table->foreign(['recepient'], 'complaints_ibfk_1')->references(['username'])->on('owners')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['sender'], 'complaints_ibfk_2')->references(['username'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropForeign('complaints_ibfk_1');
            $table->dropForeign('complaints_ibfk_2');
        });
    }
};
