<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversionTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversion_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->date('document_date');
            $table->string('type_of_document');
            $table->string('document_number');
            $table->date('issue_date');
            $table->date('expiry_date');
            $table->string('place_of_issue');
            $table->string('issuing_body');
            $table->string('emission_province');
            $table->text('document_front');
            $table->text('document_retro');
            $table->string('plant_location_address');

            $table->string('alternative_telephone_number');
            $table->string('fixed_tim_number');

            $table->unsignedBigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('clients');

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
        Schema::dropIfExists('conversion_transactions');
    }
}
