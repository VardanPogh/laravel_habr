<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfirmReloadsTable extends Migration
{
    /**
     * Run the migrations.
     *`
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('confirm_reloads');
        Schema::create('confirm_reloads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reloaded_number');
            $table->integer('confirm_reloaded_number');

            $table->unsignedBigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('services');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('confirm_reloads');
    }
}
