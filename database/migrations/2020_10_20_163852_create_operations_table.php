<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pay_method')->index()->unsigned();
            $table->foreignId('ticket_id')->index()->unsigned();
            $table->foreignId('state_id')->index()->unsigned();
            $table->float('total_amount')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pay_method')->references('id')->on('pay_methods');
            $table->foreign('ticket_id')->references('id')->on('tickets');
            $table->foreign('state_id')->references('id')->on('states');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operations');
    }
}
