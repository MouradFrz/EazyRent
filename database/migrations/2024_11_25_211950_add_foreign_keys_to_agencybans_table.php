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
        Schema::table('agencybans', function (Blueprint $table) {
            $table->foreign(['bannedClient'], 'agencybans_ibfk_1')->references(['username'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['bannedBy'], 'agencybans_ibfk_2')->references(['username'])->on('secretaries')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agencybans', function (Blueprint $table) {
            $table->dropForeign('agencybans_ibfk_1');
            $table->dropForeign('agencybans_ibfk_2');
        });
    }
};
