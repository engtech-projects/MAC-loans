<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_accounts', function (Blueprint $table) {
            // loan details
            $table->increments('loan_account_id');
            $table->string('account_num');
            $table->date('date_release')->nullable();
            $table->date('transaction_date')->nullable();
            $table->integer('cycle_no');
            $table->unsignedInteger('ao_id'); // reference account_officer
            $table->unsignedInteger('product_id'); // reference product
            $table->unsignedInteger('center_id'); // reference center
            $table->string('type');
            $table->string('payment_mode');
            $table->integer('terms');
            $table->double('loan_amount', 10, 2);
            $table->double('interest_rate', 10, 2);
            $table->double('interest_amount', 10, 2);
            $table->integer('no_of_installment')->nullable();
            $table->date('due_date')->nullable();
            $table->string('day_schedule');
            $table->string('borrower_num');
            $table->unsignedInteger('borrower_id');
            // co_borrower
            $table->string('co_borrower_name');
            $table->string('co_borrower_address');
            $table->string('co_borrower_id_type');
            $table->string('co_borrower_id_number');
            $table->string('co_borrower_id_date_issued');
            // co maker
            $table->string('co_maker_name');
            $table->string('co_maker_address')->nullable();;
            $table->string('co_maker_id_type');
            $table->string('co_maker_id_number');
            $table->string('co_maker_id_date_issued');
            // deductions
            $table->double('document_stamp', 10, 2)->nullable();
            $table->double('filing_fee', 10, 2)->nullable();
            $table->double('insurance', 10, 2)->nullable();
            $table->double('notarial_fee', 10, 2)->nullable();
            $table->double('prepaid_interest', 10, 2)->nullable();
            $table->double('affidavit_fee', 10, 2)->nullable();
            $table->double('memo', 10, 2)->nullable();
            // total
            $table->double('total_deduction', 10, 2)->nullable();
            $table->double('net_proceeds', 10, 2)->nullable();
            // 
            $table->string('release_type');
            $table->string('status');
            // branch
            $table->string('branch_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_accounts');
    }
}
