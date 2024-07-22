<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->unsignedBigInteger('metal_id')->nullable();
            $table->text('tags')->nullable();
            $table->string('code')->nullable();
            $table->text('image')->nullable();
            $table->text('video')->nullable();
            $table->tinyInteger('status')->default('1');
            $table->tinyInteger('highest_selling')->default('0');
            $table->text('description')->nullable();
            $table->double('gemstone_price',8,2)->nullable();
            $table->double('gweight1',8,2)->nullable();
            $table->double('gweight2',8,2)->nullable();
            $table->double('gweight3',8,2)->nullable();
            $table->double('gweight4',8,2)->nullable();
            $table->double('less_gems_stone',8,2)->nullable();
            $table->double('less_cz_stone',8,2)->nullable();
            $table->double('nweight1',8,2)->nullable();
            $table->double('nweight2',8,2)->nullable();
            $table->double('nweight3',8,2)->nullable();
            $table->double('nweight4',8,2)->nullable();
            $table->double('gold_price_14k',8,2)->nullable();
            $table->double('gold_price_18k',8,2)->nullable();
            $table->double('gold_price_20k',8,2)->nullable();
            $table->double('gold_price_22k',8,2)->nullable();
            $table->double('gold_price_24k',8,2)->nullable();
            $table->double('price_14k',8,2)->nullable();
            $table->double('price_18k',8,2)->nullable();
            $table->double('price_20k',8,2)->nullable();
            $table->double('price_22k',8,2)->nullable();
            $table->double('cz_stone_price',8,2)->nullable();
            $table->double('making_charge',8,2)->nullable();
            $table->double('total_price_14k',8,2)->nullable();
            $table->double('total_price_18k',8,2)->nullable();
            $table->double('total_price_20k',8,2)->nullable();
            $table->double('total_price_22k',8,2)->nullable();
            $table->string('percentage')->nullable();
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
        Schema::dropIfExists('designs');
    }
}
