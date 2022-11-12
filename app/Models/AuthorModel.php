<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AuthorModel extends Model
{
    use HasFactory;
    protected $table = 'tacgia';
    protected $ID = 'MaTG';
    public function getAll($limit = 10, $start = 0, $orderBy ="asc", $column = 'MaTG') {
        $categories = DB::table($this->table)->orderBy($column, $orderBy)->offset($start)->limit($limit)->get();
        return $categories;
    }
    public function findById($id) {
        $category = DB::table($this->table)->where($this->ID, $id)->first();
        return $category;
    }
    public function updateData($id, $data) {
        $catrgory = DB::table($this->table)->where($this->ID, $id)->update($data);
        return $catrgory;
    }

    public function deleteData($id) {
        $category = DB::table($this->table)->where($this->ID, $id)->delete();
        return $category;
    }

    public function store($data) {
        $menu = DB::table($this->table)->insertGetId($data);
        return $menu;
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
