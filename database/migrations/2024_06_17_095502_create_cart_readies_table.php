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
            $table->integer('design_id')->nullable();
            $table->string('tag_no')->nullable();
            $table->string('group_name')->nullable();
            $table->string('name')->nullable();
            $table->string('quantity')->nullable();
            $table->string('price')->nullable();
            $table->string('size')->nullable();
            $table->string('gross_weight')->nullable();
            $table->string('net_weight')->nullable();
            $table->string('gold_price')->nullable();
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
