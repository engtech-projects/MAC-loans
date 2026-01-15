<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmortizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amortization', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('loan_account_id');
            $table->date('amortization_date');
            $table->double('principal', 10, 2);
            $table->double('interest', 10, 2);
            $table->double('total', 10, 2);
            $table->double('principal_balance', 10, 2);
            $table->double('interest_balance', 10, 2);
            $table->string('status')->default('open');
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
        Schema::dropIfExists('amortization');
    }
}
