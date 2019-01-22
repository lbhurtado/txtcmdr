<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirtimeContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airtime_contact', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('airtime_id')->unsigned()->index();
            $table->integer('contact_id')->unsigned()->index();
            $table->timestamps();
            $table->foreign('airtime_id')->references('id')->on('airtimes')->onDelete('cascade');
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
        Schema::dropIfExists('airtime_contact');
    }
}
