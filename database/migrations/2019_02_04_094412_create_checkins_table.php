<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCheckinsTable.
 */
class CreateCheckinsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('checkins', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('contact_id')->unsigned();
            $table->double('longitude');
            $table->double('latitude');
            $table->text('remarks')->nullable();
            $table->schemalessAttributes('extra_attributes');
            $table->timestamps();
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
		Schema::drop('checkins');
	}
}
