<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultValueToProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE product MODIFY interest_rate DOUBLE(3,2) DEFAULT 0");
        DB::statement("ALTER TABLE product MODIFY status VARCHAR(255) DEFAULT 'active'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE product MODIFY interest_rate DOUBLE(3,2) DEFAULT NULL");
        DB::statement("ALTER TABLE product MODIFY status VARCHAR(255) DEFAULT NULL");
    }
}
