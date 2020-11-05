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
            $table->string('phone');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postcode')->nullable();
            $table->string('country')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('customer_id')->nullable();
            $table->string('receipt_url')->nullable();
            $table->string('payment_status')->nullable();
            $table->decimal('sub_total', 9, 2)->default(0);
            $table->decimal('delivery_cost', 9, 2)->default(0);
            $table->decimal('tax', 9, 2)->default(0);
            $table->decimal('total', 9, 2)->default(0);
            $table->dateTime('shipped_at')->nullable();
            $table->string('shipping_code')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::create('store_order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->nullable()->unsigned();
            $table->string('sku');
            $table->string('title');
            $table->string('product_id');
            $table->string('option_id');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 9, 2)->default(0);
            $table->decimal('total', 9, 2)->default(0);
            $table->json('options')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('order_id')->references('id')->on('store_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store_order_items', function ($table) {
            $table->dropForeign('store_order_items_order_id_foreign');
        });

        Schema::dropIfExists('store_order_items');
        Schema::dropIfExists('store_orders');
    }
}
