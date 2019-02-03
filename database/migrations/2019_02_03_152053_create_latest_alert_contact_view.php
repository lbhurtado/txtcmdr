<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLatestAlertContactView extends Migration
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
DROP VIEW IF EXISTS latest_alert_contact;
SQL;
    }

    private function createView(): string
    {
        return <<<SQL
CREATE VIEW latest_alert_contact AS 
    select * from alert_contact where (contact_id, created_at) in (
        select contact_id, max(created_at) from alert_contact group by contact_id
    )
SQL;
    }
}
