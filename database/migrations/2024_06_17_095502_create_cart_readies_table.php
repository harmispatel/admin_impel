<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartReadiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_readies', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('company_id');
            $table->integer('item_group_id');
            $table->integer('item_id');
            $table->integer('sub_item_id');
            $table->integer('style_id');
            $table->string('barcode')->nullable();
            $table->string('tag_no')->nullable();
            $table->string('group_name')->nullable();
            $table->string('name')->nullable();
            $table->string('quantity');
            $table->string('size')->nullable();
            $table->string('gross_weight')->nullable();
            $table->string('net_weight')->nullable();
            $table->string('metal_value');
            $table->string('making_charge')->nullable();
            $table->string('making_charge_discount')->nullable();
            $table->string('total_amount');
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
        Schema::dropIfExists('cart_readies');
    }
}
