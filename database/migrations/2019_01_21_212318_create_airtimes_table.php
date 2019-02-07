<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateAirtimesTable.
 */
class CreateAirtimesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('airtimes', function(Blueprint $table) {
            $table->increments('id');
            $table->string('key')->unique();
//            $table->integer('credits');
            $table->decimal('credits');
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
		Schema::drop('airtimes');
	}
}
