<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('order_num')->unique();
            $table->string('transaction_id')->nullable();
            $table->integer('customer_id')->default('0');
            $table->string('name');
            $table->string('email');
            $table->text('billing_address');
            $table->text('shipping_address')->nullable();
            $table->text('shipping_notes')->nullable();
            $table->dateTime('shipped_at')->nullable();
            $table->string('status')->default('ORDERED');
            $table->integer('tax');
            $table->integer('subtotal');
            $table->integer('total');
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
        Schema::dropIfExists('orders');
    }
}
