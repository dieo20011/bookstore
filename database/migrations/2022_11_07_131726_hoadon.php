<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class Hoadon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoadon', function (Blueprint $table) {
            $table->integer('MaHD');
            $table->integer('MaKH');
            $table->double('TongTien');
            $table->date('Ngaytao');
            $table->integer('TinhTrang');
            $table->primary(['MaHD','MaKH']);
           
        });
        DB::statement('ALTER TABLE `hoadon` MODIFY COLUMN `MaHD` INT AUTO_INCREMENT;');
        // Schema::table('hoadon', function (Blueprint $table){
        //     $table->dropPrimary('hoadon_MaHD_fk_primary');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hoadon');
       
    }
}
