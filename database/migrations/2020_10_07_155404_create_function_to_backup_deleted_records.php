<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFunctionToBackupDeletedRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            CREATE OR REPLACE FUNCTION backup_records() RETURNS TRIGGER AS $$
            DECLARE	
                _table_name text   = TG_TABLE_NAME::regclass::text;
                _record_id  text = old.id;
                _record_resource hstore = hstore(old);
               BEGIN
                   INSERT INTO backup (table_name,record_id,record_resource,deleted_at,"user") 
                      VALUES (_table_name,_record_id,to_json(_record_resource),NOW(), current_user );
                RETURN NULL;
               END;
            $$ LANGUAGE plpgsql;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP FUNCTION backup_records() ');
    }
}
