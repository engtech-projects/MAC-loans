<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexInLoanAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loan_accounts', function (Blueprint $table) {
            $table->index('loan_account_id');
            $table->index('account_num');
            $table->index('transaction_date');
            $table->index('day_schedule');
            $table->index('product_id');
            $table->index('borrower_num');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loan_accounts', function (Blueprint $table) {
            //
        });
    }
}
