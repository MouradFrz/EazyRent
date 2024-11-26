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
        Schema::create('agencybans', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('bannedClient')->nullable()->index('agencybans_ibfk_1');
            $table->string('bannedBy')->nullable()->index('bannedBy');
            $table->date('startDate')->nullable();
            $table->date('endDate')->nullable();
            $table->text('reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agencybans');
    }
};
