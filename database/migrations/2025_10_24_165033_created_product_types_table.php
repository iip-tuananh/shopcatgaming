<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatedProductTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id');
            $table->string('title');
            $table->decimal('base_price', 15,2)->nullable();
            $table->decimal('price', 15,2);

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
        //
    }
}
