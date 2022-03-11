<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutstandingObligationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outstanding_obligations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('borrower_id');
            $table->string('creditor');
            $table->string('amount');
            $table->string('balance');
            $table->string('term');
            $table->date('due_date');
            $table->string('amortization');
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
        Schema::dropIfExists('outstanding_obligations');
    }
}
