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
            $table->integer('dealer_id')->nullable();
            $table->string('order_status')->nullable();
            $table->string('name',50)->nullable();
            $table->string('email')->nullable();
            $table->string('phone',50)->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode',50)->nullable();
            $table->string('dealer_code')->nullable();
            $table->string('dealer_discount_type',50)->nullable();
            $table->string('dealer_discount_value',50)->nullable();
            $table->string('dealer_commission_type',50)->nullable();
            $table->string('dealer_commission_value',50)->nullable();
            $table->string('dealer_commission',50)->nullable();
            $table->tinyInteger('commission_status')->nullable();
            $table->dateTime('bill_date')->nullable();
            $table->string('bill_number')->nullable();
            $table->dateTime('commission_date')->nullable();
            $table->dateTime('commission_payment_date')->nullable();
            $table->json('product_ids')->nullable();
            $table->double('charges')->default(0.00);
            $table->double('gst_amount')->default(0.00);
            $table->double('sub_total')->default(0.00);
            $table->double('total')->default(0.00);
            $table->tinyInteger('payment_status')->default(0);
            $table->string('merchant_transaction_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->text('payment_instrument')->nullable();
            $table->string('payment_method')->nullable();            
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
