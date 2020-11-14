<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->index();
            $table->string('ticket')->unique()->index();
            $table->dateTime('date_start')->index();
            $table->dateTime('date_arrival')->index();
            $table->string('aircraft_id')->nullable();
            $table->foreignId('airport_origin_id')->index()->unsigned();
            $table->foreignId('airport_arrival_id')->index()->unsigned();
            $table->foreignId('client_id')->index()->unsigned();
            $table->foreignId('airline_id')->index()->unsigned();
            $table->foreignId('user_id')->index()->unsigned();
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('airport_origin_id')->references('id')->on('airports');
            $table->foreign('airport_arrival_id')->references('id')->on('airports');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('airline_id')->references('id')->on('airlines');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
