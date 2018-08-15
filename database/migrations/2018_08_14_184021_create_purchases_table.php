<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');

            $table->unsignedInteger('units');
            $table->float('purchase_price')->comment('per unit');
            $table->float('sale_price')->comment('per unit');
            $table->unsignedInteger('in_stock')->comment('remaining from last purchase of product');
            $table->unsignedInteger('purchased_by');
            $table->unsignedInteger('payment_status_id');

            $table->timestamp('purchased_at');

            $table->foreign('purchased_by')->references('id')->on('users');
            $table->foreign('payment_status_id')->references('id')->on('payment_statuses');
            $table->foreign('product_id')->references('id')->on('products');

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
        Schema::dropIfExists('purchases');
    }
}
