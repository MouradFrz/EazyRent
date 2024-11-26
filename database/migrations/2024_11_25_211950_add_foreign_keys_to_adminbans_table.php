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
        Schema::table('adminbans', function (Blueprint $table) {
            $table->foreign(['bannedBy'], 'adminbans_ibfk_1')->references(['username'])->on('admins')->onUpdate('SET NULL')->onDelete('SET NULL');
            $table->foreign(['bannedUsername'], 'adminbans_ibfk_2')->references(['username'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adminbans', function (Blueprint $table) {
            $table->dropForeign('adminbans_ibfk_1');
            $table->dropForeign('adminbans_ibfk_2');
        });
    }
};
