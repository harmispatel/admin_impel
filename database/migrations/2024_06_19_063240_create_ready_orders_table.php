<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReadyOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ready_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('order_status')->nullable();
            $table->string('name',50)->nullable();
            $table->string('email')->nullable();
            $table->string('phone',50)->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode',50)->nullable();
            $table->dateTime('bill_date')->nullable();
            $table->string('bill_number')->nullable();
            $table->json('product_ids')->nullable();
            $table->json('gold_price')->nullable();
            $table->double('sub_total')->default(0.00);
            $table->double('total')->default(0.00);
            $table->tinyInteger('payment_status')->default(0);
            $table->string('merchant_transaction_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->double('gst_amount')->default(0.00);
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
        Schema::dropIfExists('ready_orders');
    }
}
