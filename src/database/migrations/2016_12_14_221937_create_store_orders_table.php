<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('order_num')->unique();
            $table->string('name');
            $table->string('email');
            $table->string('order_details');
            $table->text('shipping_address')->nullable();
            $table->text('shipping_notes')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('customer_id')->nullable();
            $table->string('receipt_url')->nullable();
            $table->string('payment_status')->nullable();
            $table->integer('amount')->default(0);
            $table->integer('net_amount')->default(0);
            $table->integer('status')->default(1);
            $table->dateTime('shipped_at')->nullable();
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
        Schema::dropIfExists('store_orders');
    }
}
