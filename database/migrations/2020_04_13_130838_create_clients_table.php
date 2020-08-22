<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->integer('service_id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('tax_code')->nullable();
            $table->string('address')->nullable();
            $table->string('civil')->nullable();
            $table->string('manager')->nullable();
            $table->integer('cap')->nullable();
            $table->date('birthday')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
