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
            $table->string('amount')->nullable();
            $table->string('balance')->nullable();
            $table->string('term')->nullable();
            $table->date('due_date')->nullable();
            $table->string('amortization')->nullable();
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
