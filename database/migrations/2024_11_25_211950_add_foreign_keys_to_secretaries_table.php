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
        Schema::table('secretaries', function (Blueprint $table) {
            $table->foreign(['brancheID'], 'secretaries_ibfk_1')->references(['brancheID'])->on('branches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('secretaries', function (Blueprint $table) {
            $table->dropForeign('secretaries_ibfk_1');
        });
    }
};
