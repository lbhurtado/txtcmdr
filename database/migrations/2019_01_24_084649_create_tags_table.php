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
            $table->string('code')->unique();
            $table->morphs('tagger');
            $table->schemalessAttributes('extra_attributes');
            $table->unique(['tagger_id', 'tagger_type']);
            $table->timestamps();
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
