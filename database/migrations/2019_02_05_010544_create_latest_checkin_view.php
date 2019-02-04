<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLatestCheckinView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement($this->dropView());

        DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement($this->dropView());
    }

    private function dropView(): string
    {
        return <<<SQL
DROP VIEW IF EXISTS latest_checkins;
SQL;
    }

    private function createView(): string
    {
        return <<<SQL
CREATE VIEW latest_checkins AS 
    select * from checkins where (contact_id, created_at) in (
        select contact_id, max(created_at) from checkins group by contact_id
    )
SQL;
    }
}
