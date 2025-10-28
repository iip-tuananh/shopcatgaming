<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCateIdToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_cate_id_foreign');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('cate_id')->nullable()->change();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('cate_id')
                ->references('id')->on('categories')
                ->nullOnDelete()
                ->cascadeOnUpdate();
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
            //
        });
    }
}
