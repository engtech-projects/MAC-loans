<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AmortizationModifyAddTrno extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        // DB::statement("ALTER TABLE payment MODIFY COLUMN transaction_date DATE AFTER payment_id"); // sample move position
        Schema::table('amortization', function (Blueprint $table) {
            $table->string('transaction_number')->nullable()->after('interest_balance');
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
