<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowerInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrower_info', function (Blueprint $table) {
            // basic info
            $table->increments('borrower_id');
            $table->string('borrower_num');
            $table->date('date_registered');
            $table->string('firstname');
            $table->string('middlename');
            $table->string('lastname');
            $table->string('suffix')->nullable();
            $table->text('address');
            $table->date('birthdate');
            $table->string('gender');
            $table->string('status');
            $table->string('contact_number');
            // ID details
            $table->string('id_type');
            $table->string('id_no');
            $table->date('id_date_issued');
            // spouse info
            $table->string('spouse_firstname')->nullable();
            $table->string('spouse_middlename')->nullable();
            $table->string('spouse_lastname')->nullable();
            $table->text('spouse_address')->nullable();
            $table->date('spouse_birthdate')->nullable();
            $table->string('spouse_contact_number')->nullable();
             // spouse ID details
            $table->string('spouse_id_type')->nullable();
            $table->string('spouse_id_no')->nullable();
            $table->date('spouse_id_date_issued')->nullable();
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
        Schema::dropIfExists('borrower_info');
    }
}
