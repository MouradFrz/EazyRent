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
        Schema::create('secretaries', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('email');
            $table->string('username')->unique('username');
            $table->string('password');
            $table->string('firstName');
            $table->string('lastName');
            $table->timestamp('birthDate');
            $table->integer('brancheID')->index('brancheID');
            $table->string('address');
            $table->string('created_at');
            $table->string('updated_at');
            $table->string('profilePath');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('secretaries');
    }
};
