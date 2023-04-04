<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexInAmortizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('amortization', function (Blueprint $table) {
            $table->index('loan_account_id');
            $table->index('amortization_date');
            $table->index('status');
            $table->index('transaction_number');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('amortization', function (Blueprint $table) {
            //
        });
    }
}
