<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->string("product_name");
            $table->string("image")->nullable();
            $table->double("selling_price");
            $table->double("buying_price")->nullable();
            $table->string("product_code")->nullable();
            $table->integer("supplier_id")->nullable();
            $table->string("root")->nullable();
            $table->string("buying_date")->nullable();
            $table->string("product_quantity");
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
        Schema::dropIfExists('products');
    }
}
