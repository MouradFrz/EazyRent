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
        Schema::create('agencyrequests', function (Blueprint $table) {
            $table->integer('requestID', true);
            $table->string('name')->nullable();
            $table->string('registeryNb')->nullable();
            $table->date('registrationDate')->nullable();
            $table->string('creationYear')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->string('logo')->nullable();
            $table->string('adminUsername')->nullable()->index('adminUsername');
            $table->string('state')->nullable();
            $table->string('ownerUsername');
            $table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agencyrequests');
    }
};
