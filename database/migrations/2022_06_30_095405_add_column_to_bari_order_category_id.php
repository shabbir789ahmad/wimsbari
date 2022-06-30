<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToBariOrderCategoryId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bari_orders', function (Blueprint $table) {
            $table->bigInteger('category_id')->nullable()->unsigned();
              $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bari_orders', function (Blueprint $table) {
             $table->dropForeign(['category_id']);
             $table->dropColumn('category_id');
        });
    }
}
