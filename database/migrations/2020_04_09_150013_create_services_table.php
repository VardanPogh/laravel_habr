<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('category_id')->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->integer('price')->nullable();
            $table->integer('agent_price')->nullable();
            $table->integer('agent_percent')->nullable();
            $table->integer('admin_percent')->nullable();
            $table->integer('status')->nullable();
            $table->integer('options')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('services');
    }
}
