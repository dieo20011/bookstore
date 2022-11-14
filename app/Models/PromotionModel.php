<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PromotionModel extends Model
{
    use HasFactory;
    protected $table = 'ctkm';
    protected $ID = 'MaKM';
    public function getAll($limit = 10, $start = 0, $orderBy ="asc", $column = 'MaKM') {
        $promotions = DB::table($this->table)->orderBy($column, $orderBy)->offset($start)->limit($limit)->get();
        return $promotions;
    }
    public function findById($id) {
        $protion = DB::table($this->table)->where($this->ID, $id)->first();
        return $protion;
    }
    public function updateData($id, $data) {
        $catrgory = DB::table($this->table)->where($this->ID, $id)->update($data);
        return $catrgory;
    }

    public function deleteData($id) {
        $protion = DB::table($this->table)->where($this->ID, $id)->delete();
        return $protion;
    }

    public function store($data) {
        $promotion = DB::table($this->table)->insertGetId($data);
        return $promotion;
    }

    public function getColumnName() {
        $arrName = DB::getSchemaBuilder()->getColumnListing($this->table);
        for($i = 0; $i < count($arrName); $i++) {
            if($arrName[$i] == $this->ID) {
                unset($arrName[$i]);
            }
        }
        return $arrName;
    }
}
