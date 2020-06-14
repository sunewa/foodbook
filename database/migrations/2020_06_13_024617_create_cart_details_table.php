<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_details', function (Blueprint $table) {
            $table->id();
            $table->integer('cart_id')->unsigned();
            $table->integer('seller_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->string('product_name');
            $table->longtext('price');
            $table->boolean('quantity');
            
            $table->foreign('cart_id')->references('id')->on('carts');
            $table->foreign('seller_id')->references('id')->on('users');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_details');
    }
}
