<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductModel extends Model
{
    use HasFactory;
    protected $table = 'sach';
    protected $ID = 'MaSP';
    public function getAll($limit = 100, $start = 0, $orderBy ="asc", $column = 'MaSP') {
        $products = DB::table($this->table)->orderBy($column, $orderBy)->offset($start)->limit($limit)->get();
        return $products;
    }
    public function findById($id) {
        $product = DB::table($this->table)->where($this->ID, $id)->first();
        return $product;
    }
    public function updateData($id, $data) {
        $product = DB::table($this->table)->where($this->ID, $id)->update($data);
        return $product;
    }

    public function deleteData($id) {
        $product = DB::table($this->table)->where($this->ID, $id)->delete();
        return $product;
    }

    public function store($data) {
        $product = DB::table($this->table)->insertGetId($data);
        return $product;
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

    public function getByCategoryId($id, $limit = 6) {
        return DB::select("SELECT * FROM ".$this->table." where MaTl = $id limit $limit");
    }
}
