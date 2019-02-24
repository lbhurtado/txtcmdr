<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactIssueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_issue', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contact_id')->unsigned()->index();
            $table->integer('issue_id')->unsigned()->index();
            $table->integer('qty')->unsigned()->default(0);
            $table->timestamps();
            $table->foreign('issue_id')->references('id')->on('issues')->onDelete('cascade');
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->unique(['contact_id', 'issue_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_issue');
    }
}
