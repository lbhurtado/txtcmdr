<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTagsTable.
 */
class CreateTagsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tags', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('contact_id')->unsigned()->unique()->default(1);
            $table->string('code')->unique();
            $table->schemalessAttributes('extra_attributes');
            $table->timestamps();
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
		});

        Schema::create('taggables', function (Blueprint $table) {
            $table->integer('tag_id')->unsigned()->index();
            $table->morphs('taggable');
            $table->timestamps();
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('taggables');
		Schema::drop('tags');
	}
}
