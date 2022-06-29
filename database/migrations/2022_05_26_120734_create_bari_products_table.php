<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBariProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bari_products', function (Blueprint $table) {
            $table->id();
            $table->string('bri_image');
            $table->string('bri_product_name');
            $table->string('size');
            $table->string('rate');
            $table->bigInteger('bri_brand_id')->unsigned();
            $table->foreign('bri_brand_id')->references('id')->on('brands')->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('bri_category_id')->unsigned();
            $table->foreign('bri_category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('bari_products');
    }
}
