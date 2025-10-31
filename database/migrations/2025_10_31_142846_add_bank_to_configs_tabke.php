<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBankToConfigsTabke extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configs', function (Blueprint $table) {
            $table->string('nganhang')->nullable();
            $table->string('chutaikhoan')->nullable();
            $table->string('sotaikhoan')->nullable();
            $table->string('chinhanh')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configs_tabke', function (Blueprint $table) {
            //
        });
    }
}
