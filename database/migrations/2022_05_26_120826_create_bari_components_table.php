<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBariComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bari_components', function (Blueprint $table) {
            $table->id();
            $table->string('category_name');
            $table->bigInteger('bri_quentity');
            $table->bigInteger('bri_product_id')->unsigned();
            $table->foreign('bri_product_id')->references('id')->on('bari_products')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('bari_components');
    }
}
