<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Khachhang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('khachhang', function (Blueprint $table) {
            $table->increments('MaKH');
            $table->string('TenKH');
            $table->date('NgaySinh');
            $table->boolean('GioiTinh');
            $table->string('Matkhau');
            $table->string('Email');
            $table->integer('Quyen');
            $table->string('ThongTinGiaoHang')->nullable();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('khachhang');
    }
}
