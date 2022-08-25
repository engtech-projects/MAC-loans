<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBorrowerLoginDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('borrower_info', function (Blueprint $table) {
            $table->string('username')->unique();
            $table->string('password');
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('borrower_info', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('password');
            //
        });
    }
}
