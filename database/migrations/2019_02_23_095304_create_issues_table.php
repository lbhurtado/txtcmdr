<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateIssuesTable.
 */
class CreateIssuesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('issues', function(Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name')->unique();
            $table->schemalessAttributes('extra_attributes');
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
		Schema::drop('issues');
	}
}
