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
        Schema::create('owners', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('email');
            $table->string('username')->unique('username');
            $table->string('password');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('address');
            $table->string('idCard');
            $table->date('birthDate');
            $table->string('idCardPath');
            $table->string('phoneNumber')->nullable();
            $table->integer('agencyID')->nullable()->index('agencyID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('owners');
    }
};
