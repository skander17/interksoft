<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('logs_module', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('module',255)->nullable();
            $table->string('action',255)->nullable();
            $table->string('path',255)->nullable();
            $table->string('ip', 45)->nullable();
            $table->text('request')->nullable();
            $table->text('headers')->nullable();
            $table->string('username',255)->nullable();
            $table->string('useremail',255)->nullable();
            $table->string('role',255)->nullable();
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
        //
        Schema::dropIfExists('logs_module');
    }
}
