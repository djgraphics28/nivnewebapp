<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTruckItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('truck_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tracking_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('tracking_date_id');
            $table->string('type');
            $table->integer('load_quantity');
            $table->integer('return_quantity')->nullable();
            $table->string('return_unit')->nullable();
            $table->integer('return_pcs')->nullable();

            $table->foreign('tracking_id')->references('id')->on('truck_inventories');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('tracking_date_id')->references('id')->on('tracking_dates');
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
        Schema::dropIfExists('truck_items');
    }
}
