<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateAlertsTable.
 */
class CreateAlertsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('alerts', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->schemalessAttributes('extra_attributes');
            $table->timestamps();
		});

        Schema::create('model_has_alerts', function (Blueprint $table) {
            $table->unsignedInteger('alert_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->timestamps();
            $table->primary(['alert_id', 'model_type', 'model_id']);
            $table->index(['model_id', 'model_type']);
            $table->foreign('alert_id')->references('id')->on('alerts')->onDelete('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('alerts');
	}
}
