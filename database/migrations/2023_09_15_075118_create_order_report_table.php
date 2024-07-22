<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_dealer_report', function (Blueprint $table) {
            $table->id();
            $table->date('order_date')->nullable();
            $table->integer('dealer_id')->nullble();
            $table->string('quantity')->nullable();
            $table->string('order_status')->nullable();
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
        Schema::dropIfExists('order_report');
    }
}
