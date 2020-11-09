<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_ticket', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->index()->unsigned();
            $table->foreignId('ticket_id')->index()->unsigned();
            $table->timestamps();

            $table->foreign('package_id')->references('id')->on('packages');
            $table->foreign('ticket_id')->references('id')->on('tickets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_ticket');
    }
}
