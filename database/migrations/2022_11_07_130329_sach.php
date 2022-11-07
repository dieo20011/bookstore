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
            $table->string('TenSp');
            $table->integer('Matg');
            $table->integer('Matl');
            $table->string('img');
            $table->float('Dongia');
            $table->integer('SoLuong');
            $table->integer('MaNXB');
            $table->integer('TTKM');
            $table->integer('TTSach');
            $table->integer('MaKM');
            $table->string('MoTa');
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
