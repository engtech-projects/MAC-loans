<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmploymentInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employment_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('borrower_id');
            $table->string('company_name');
            $table->string('company_address')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('years_employed')->nullable();
            $table->string('position')->nullable();
            $table->string('salary')->nullable();
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
        Schema::dropIfExists('employment_info');
    }
}
