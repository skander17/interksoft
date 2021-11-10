<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTriggersToBackupDeletedRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //CLIENTS BACKUP
        DB::statement('
            CREATE TRIGGER "backup_clients" AFTER DELETE ON "clients" FOR EACH ROW 
                EXECUTE PROCEDURE backup_records();
	    ');
        //USERS BACKUP
        DB::statement('
            CREATE TRIGGER "backup_users" AFTER DELETE ON "users" FOR EACH ROW 
                EXECUTE PROCEDURE backup_records();
	    ');
        //TICKETS BACKUP
        DB::statement('
            CREATE TRIGGER "backup_tickets" AFTER DELETE ON "tickets" FOR EACH ROW 
                EXECUTE PROCEDURE backup_records();
	    ');
        //OPERATIONS BACKUP
        DB::statement('
            CREATE TRIGGER "backup_operations" AFTER DELETE ON "operations" FOR EACH ROW 
                EXECUTE PROCEDURE backup_records();
	    ');
        //OPERATION DETAIL BACKUP
        DB::statement('
            CREATE TRIGGER "backup_operation_detail" AFTER DELETE ON "operation_details" FOR EACH ROW 
                EXECUTE PROCEDURE backup_records();
	    ');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP TRIGGER backup_users on users;');
        DB::statement('DROP TRIGGER backup_clients on clients;');
        DB::statement('DROP TRIGGER backup_tickets on tickets;');
        DB::statement('DROP TRIGGER backup_operations on operations;');
        DB::statement('DROP TRIGGER backup_operation_detail on operation_details;');
    }
}
