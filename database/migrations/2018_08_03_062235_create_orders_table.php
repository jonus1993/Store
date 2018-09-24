<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration {

    public function up() {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('cart_id')->unsigned();
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->integer('address_id')->unsigned();
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->integer('total_qty')->unsigned();
            $table->float('total_cost');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('orders');
    }

}
