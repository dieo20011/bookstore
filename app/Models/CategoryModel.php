<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class CategoryModel extends Model
{
    use HasFactory;
    protected $table = 'theloai';
    protected $ID = 'MaTL';
    public function getAll($limit = 10, $start = 0, $orderBy ="asc", $column = 'MaTL') {
        $categories = DB::table($this->table)->orderBy($column, $orderBy)->offset($start)->limit($limit)->get();
        return $categories;
    }
    public function findById($id) {
        $catrgory = DB::table($this->table)->where($this->ID, $id)->first();
        return $catrgory;
    }
    public function updateData($id, $data) {
        $catrgory = DB::table($this->table)->where($this->ID, $id)->update($data);
        return $catrgory;
    }

    public function deleteData($id) {
        $catrgory = DB::table($this->table)->where($this->ID, $id)->delete();
        return $catrgory;
    }

    public function store($data) {
        $menu = DB::table($this->table)->insertGetId($data);
        return $menu;
    }
    
}
