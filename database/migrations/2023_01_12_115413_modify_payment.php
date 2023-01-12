<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ModifyPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::statement("ALTER TABLE payment MODIFY COLUMN transaction_date DATE AFTER payment_id");
        DB::statement("ALTER TABLE payment MODIFY COLUMN transaction_number VARCHAR(191) AFTER memo_type");
        DB::statement("ALTER TABLE payment MODIFY COLUMN reference_no VARCHAR(191) AFTER reference_id");
        DB::statement("ALTER TABLE payment MODIFY COLUMN amount_applied DOUBLE(10,2) AFTER amortization_id");
        DB::statement("ALTER TABLE payment MODIFY COLUMN advance_principal DOUBLE(10,2) AFTER principal");
        DB::statement("ALTER TABLE payment MODIFY COLUMN short_principal DOUBLE(10,2) AFTER advance_principal");
        DB::statement("ALTER TABLE payment MODIFY COLUMN advance_interest DOUBLE(10,2) AFTER interest");
        DB::statement("ALTER TABLE payment MODIFY COLUMN short_interest DOUBLE(10,2) AFTER advance_interest");
        DB::statement("ALTER TABLE payment MODIFY COLUMN pdi_approval_no VARCHAR(191) AFTER short_interest");
        DB::statement("ALTER TABLE payment MODIFY COLUMN pdi DOUBLE(10,2) AFTER pdi_approval_no");
        DB::statement("ALTER TABLE payment MODIFY COLUMN short_pdi DOUBLE(10,2) AFTER pdi");
        DB::statement("ALTER TABLE payment MODIFY COLUMN penalty_approval_no VARCHAR(191) AFTER short_pdi");
        DB::statement("ALTER TABLE payment MODIFY COLUMN penalty DOUBLE(10,2) AFTER penalty_approval_no");
        DB::statement("ALTER TABLE payment MODIFY COLUMN short_penalty DOUBLE(10,2) AFTER penalty");
        DB::statement("ALTER TABLE payment MODIFY COLUMN rebates_approval_no VARCHAR(191) AFTER short_penalty");
        DB::statement("ALTER TABLE payment MODIFY COLUMN rebates DOUBLE(10,2) AFTER rebates_approval_no");
        DB::statement("ALTER TABLE payment MODIFY COLUMN over_payment DOUBLE(10,2) AFTER rebates");
        DB::statement("ALTER TABLE payment MODIFY COLUMN total_payable DOUBLE(10,2) AFTER over_payment");
        DB::statement("ALTER TABLE payment MODIFY COLUMN vat DOUBLE(10,2) AFTER total_payable");
        Schema::table('payment', function (Blueprint $table) {
            $table->unsignedInteger('cancelled_by')->nullable()->after('status');
            $table->date('cancelled_date')->nullable()->after('cancelled_by');
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
