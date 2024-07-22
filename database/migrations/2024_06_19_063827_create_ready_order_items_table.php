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
            $table->integer('order_id');
            $table->integer('design_id')->nullable();
            $table->string('design_name')->nullable();
            $table->string('quantity',50)->nullable();
            $table->string('gold_type')->nullable();
            $table->string('gross_weight',50)->nullable();
            $table->string('net_weight',50)->nullable();
            $table->string('percentage',50)->nullable();
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
