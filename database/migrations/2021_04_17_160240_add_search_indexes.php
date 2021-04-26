<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddSearchIndexes extends Migration
{
    private $tables = [
        'pg_services',
        'pg_specialities',
        'pg_diseases',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $table) {
            DB::statement("ALTER TABLE {$table} ADD FULLTEXT fulltext_index(`title`)");
        }

        DB::statement("ALTER TABLE pg_addresses ADD FULLTEXT fulltext_index(`street`, `city`)");

        DB::statement("ALTER TABLE pg_users ADD FULLTEXT fulltext_index(`first_name`, `last_name`)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tables as $table) {
            DB::statement("DROP INDEX `fulltext_index` ON {$table}");
        }

        DB::statement("DROP INDEX `fulltext_index` ON pg_addresses");

        DB::statement("DROP INDEX `fulltext_index` ON pg_users");
    }
}
