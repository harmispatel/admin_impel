<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->tinyInteger('user_type')->default('1');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->text('shipping_address')->nullable();
            $table->text('city')->nullable();
            $table->text('shipping_city')->nullable();
            $table->text('state')->nullable();
            $table->text('shipping_state')->nullable();
            $table->string('ref_name')->nullable();
            $table->string('profile')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('comapany_name')->nullable();
            $table->tinyInteger('status')->default('1');
            $table->tinyInteger('verification')->default('1');
            $table->tinyInteger('address_same_as_company')->default('0');
            $table->string('gst_no')->nullable();
            $table->string('pan_no')->nullable();
            $table->string('whatsapp_no')->nullable();
            $table->string('pincode')->nullable();
            $table->string('shipping_pincode')->nullable();
            $table->string('dealer_code')->nullable();
            $table->string('discount_type')->nullable();
            $table->string('discount_value')->nullable();
            $table->string('commission_type')->nullable();
            $table->string('commission_value')->nullable();
            $table->string('commission_days',25)->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
