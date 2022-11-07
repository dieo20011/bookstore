<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Ctkm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ctkm', function (Blueprint $table) {
            $table->increments('MaKM');
            $table->string('TenCTKM');
            $table->date('NgayBatDau');
            $table->date('NgayKetThuc');
            $table->integer('TinhTrang');
            $table->float('PhanTram');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ctkm');
    }
}
