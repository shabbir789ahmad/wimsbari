<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWhereAdminIdAndWhereHouseIdInProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
              $table->bigInteger('admin_id')->nullable()->unsigned();
              $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade')->onUpdate('cascade');
              $table->bigInteger('where_house_id')->nullable()->unsigned();
              $table->foreign('where_house_id')->references('id')->on('where_houses')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
             $table->dropForeign(['admin_id']);
             $table->dropColumn('admin_id');
             $table->dropForeign(['where_house_id']);
             $table->dropColumn('where_house_id');
        });
    }
}
