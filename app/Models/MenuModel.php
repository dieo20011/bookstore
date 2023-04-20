<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class MenuModel extends Model
{
    protected $table = 'danhmuc';
    protected $ID = 'MaDM';
    public function getAll($limit = 100, $start = 0, $orderBy ="asc", $column = 'MaDM') {
        $menus = DB::table($this->table)->orderBy($column, $orderBy)->offset($start)->limit($limit)->get();
        return $menus;
    }
    public function findById($id) {
        $menu = DB::table($this->table)->where($this->ID, $id)->first();
        return $menu;
    }
    public function updateData($id, $data) {
        $menu = DB::table($this->table)->where($this->ID, $id)->update($data);
        return $menu;
    }

    public function deleteData($id) {
        $menu = DB::table($this->table)->where($this->ID, $id)->delete();
        return $menu;
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
