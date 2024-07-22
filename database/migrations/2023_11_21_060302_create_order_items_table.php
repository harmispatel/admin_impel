<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('order_id');
            $table->integer('dealer_id')->nullable();
            $table->integer('design_id');
            $table->string('design_name')->nullable();
            $table->string('quantity',50)->nullable();
            $table->string('gold_type')->nullable();
            $table->string('gold_color')->nullable();
            $table->string('gross_weight',50)->nullable();
            $table->string('less_gems_stone',50)->nullable();
            $table->string('less_cz_stone',50)->nullable();
            $table->string('net_weight',50)->nullable();
            $table->string('percentage',50)->nullable();
            $table->double('less_gems_stone_price')->default(0.00);
            $table->double('less_cz_stone_price')->default(0.00);
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
        Schema::dropIfExists('order_items');
    }
}
