<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestsOrdersItemsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('guests_orders__items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('items');
            $table->integer('qty')->unsigned();
            $table->timestamps();
        });
        
         Schema::table('guests_orders__items', function (Blueprint $table) {
            $table->foreign('order_id')
                ->references('id')
                ->on('guests_orders');
        });
    }
    
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('guests_orders__items');
    }

}
