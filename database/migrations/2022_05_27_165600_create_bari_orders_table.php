<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBariOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bari_orders', function (Blueprint $table) {
            $table->id();
            $table->longText('description')->nullable();
            $table->bigInteger('shelf_quentity')->nullable();
            $table->string('price')->nullable();
            $table->string('size')->nullable();
            $table->string('component')->nullable();
            
            $table->json('properties')->nullable();
            $table->json('product_id')->nullable();
           
            $table->bigInteger('payment_id')->nullable()->unsigned();
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade')->onUpdate('cascade');

            
            
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
        Schema::dropIfExists('bari_orders');
    }
}
