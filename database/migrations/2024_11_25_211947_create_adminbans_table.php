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
        Schema::create('adminbans', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('bannedUsername')->index('bannedUsername');
            $table->string('bannedBy')->nullable()->index('bannedBy');
            $table->text('reason')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adminbans');
    }
};
