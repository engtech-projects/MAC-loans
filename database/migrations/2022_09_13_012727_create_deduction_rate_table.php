<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeductionRateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deduction_rate', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('rate')->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->integer('term_start')->nullable();
            $table->integer('term_end')->nullable();
            $table->integer('age_start')->nullable();
            $table->integer('age_end')->nullable();
            $table->tinyInteger('deleted')->default(0);
            $table->string('status')->default('active');
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
        Schema::dropIfExists('deduction_rate');
    }
}
