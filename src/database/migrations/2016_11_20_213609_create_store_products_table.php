<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('price_group_id')->unsigned()->nullable();
            $table->string('title');
            $table->string('slug')->default('')->unique();
            $table->string('code')->unique();
            $table->string('intro')->nullable();
            $table->text('description')->nullable();
            $table->text('images')->nullable();
            $table->string('price_from')->nullable();
            $table->boolean('featured')->default(0);
            $table->integer('total_num')->unsigned()->nullable();
            $table->integer('remaining_num')->unsigned()->nullable();
            $table->enum('status', ['PUBLISHED', 'DRAFT'])->default('PUBLISHED');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_products');
    }
}
