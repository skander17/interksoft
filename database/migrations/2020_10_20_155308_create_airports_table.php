<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAirportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airports', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->index();;
            $table->string('iso_region')->nullable()->index();
            $table->string('iso_country')->nullable()->index();
            $table->string('iata_code')->nullable()->index();
            $table->string('latitude')->nullable()->index();
            $table->string('longitude')->nullable()->index();
            $table->foreignId('country_id')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('country_id')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('airports');
    }
}
