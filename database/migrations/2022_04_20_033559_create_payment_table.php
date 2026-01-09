<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->increments('payment_id');
            $table->unsignedInteger('loan_account_id');
            $table->unsignedInteger('branch_id');
            $table->string('payment_type');
            $table->string('or_no')->nullable();
            $table->string('cheque_no')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('reference_no')->nullable();
            $table->string('memo_type')->nullable();
            $table->unsignedInteger('amortization_id')->nullable(); // references amortization primary key
            $table->double('principal', 10, 2)->nullable();
            $table->double('interest', 10, 2)->nullable();
            $table->double('short_principal', 10, 2)->nullable();
            $table->double('advance_principal', 10, 2)->nullable();
            $table->double('short_interest', 10, 2)->nullable();
            $table->double('advance_interest', 10, 2)->nullable();
            $table->double('pdi', 10, 2)->nullable();
            $table->string('pdi_approval_no')->nullable();
            $table->double('penalty', 10, 2)->nullable();
            $table->string('penalty_approval_no')->nullable();
            $table->double('rebates', 10, 2)->nullable();
            $table->string('rebates_approval_no')->nullable();
            $table->double('total_payable', 10, 2)->nullable();
            $table->double('amount_applied', 10, 2)->nullable();
            $table->string('status')->default('open')->nullable();
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
        Schema::dropIfExists('payment');
    }
}
