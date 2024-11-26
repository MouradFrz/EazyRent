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
        Schema::create('agencies', function (Blueprint $table) {
            $table->integer('AgencyId', true);
            $table->string('name')->nullable();
            $table->string('registeryNb')->nullable();
            $table->date('registrationDate')->nullable();
            $table->string('creationYear')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at');
            $table->string('logo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agencies');
    }
};
