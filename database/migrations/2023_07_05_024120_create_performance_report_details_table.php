<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerformanceReportDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performance_report_details', function (Blueprint $table) {
            $table->unsignedInteger('report_id');
            $table->string("product");
            $table->string("portfolio_accounts");
            $table->string("portfolio");
            $table->integer("delinquent_accounts");
            $table->double("delinquent",10,2);
            $table->string("delinquent_rate");
            $table->integer("pastdue_accounts");
            $table->double("pastdue",10,2);
            $table->string("pastdue_rate");
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
        Schema::dropIfExists('performance_report_details');
    }
}
