<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReadyOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ready_order_items', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('dealer_id')->nullable();
            $table->integer('order_id');
            $table->string('design_name')->nullable();
            $table->string('quantity',50)->nullable();
            $table->string('barcode')->nullable();
            $table->string('gross_weight',50)->nullable();
            $table->string('net_weight',50)->nullable();
            $table->string('metal_value')->nullable();
            $table->string('making_charge')->nullable();
            $table->string('making_charge_discount')->nullable();
            $table->double('item_sub_total')->default(0.00);
            $table->double('item_total')->default(0.00);
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
        Schema::dropIfExists('ready_order_items');
    }
}
