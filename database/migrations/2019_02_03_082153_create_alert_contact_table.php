<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alert_contact', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('alert_id')->unsigned()->index();
            $table->integer('contact_id')->unsigned()->index();
            $table->timestamps();
            $table->foreign('alert_id')->references('id')->on('alerts')->onDelete('cascade');
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alert_contact');
    }
}
