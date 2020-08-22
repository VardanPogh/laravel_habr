<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesReloadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('services_reloads');
        Schema::create('services_reloads', function (Blueprint $table) {
            $table->increments('id');

            $table->string('image');
            $table->string('title');
            $table->integer('amount');
            $table->string('course');

            $table->unsignedBigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories');

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
        Schema::dropIfExists('services_reloads');
    }
}
