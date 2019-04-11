<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateLeadsTable.
 */
class CreateLeadsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('leads', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code')->nullable()->index();
            $table->schemalessAttributes('extra_attributes');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('leads');
	}
}
