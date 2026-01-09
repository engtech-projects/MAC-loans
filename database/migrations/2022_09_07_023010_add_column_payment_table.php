<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment', function (Blueprint $table) {
            $table->double('short_penalty', 10, 2)->nullable();
            $table->double('short_pdi', 10, 2)->nullable();
            $table->double('over_payment', 10, 2)->nullable();
            $table->double('vat', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
