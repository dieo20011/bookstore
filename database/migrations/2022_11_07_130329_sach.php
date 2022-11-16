<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Sach extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sach', function (Blueprint $table) {
            $table->increments('MaSP');
            $table->string('TenSP');
            $table->integer('SoLuong');
            $table->float('DonGia');
            $table->string('MoTa');
            $table->integer('MaTL');
            $table->integer('MaTG');
            $table->integer('MaNXB');
            $table->integer('MaKM');
            $table->integer('TTKM');
            $table->integer('TTSach');
            $table->string('img');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sach');
    }
}
