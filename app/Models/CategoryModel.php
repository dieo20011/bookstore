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
    public function getAll($limit = 100, $start = 0, $orderBy = "asc", $column = 'MaTL')
    {
        $categories = DB::table($this->table)->orderBy($column, $orderBy)->offset($start)->limit($limit)->get();
        return $categories;
    }
    public function findById($id)
    {
        $category = DB::table($this->table)->where($this->ID, $id)->first();
        return $category;
    }
    public function updateData($id, $data)
    {
        $category = DB::table($this->table)->where($this->ID, $id)->update($data);
        return $category;
    }

    public function deleteData($id)
    {
        $category = DB::table($this->table)->where($this->ID, $id)->delete();
        return $category;
    }

    public function store($data)
    {
        $category = DB::table($this->table)->insertGetId($data);
        return $category;
    }

    public function getColumnName()
    {
        $arrName = DB::getSchemaBuilder()->getColumnListing($this->table);
        for ($i = 0; $i < count($arrName); $i++) {
            if ($arrName[$i] == $this->ID) {
                unset($arrName[$i]);
            }
        }
        return $arrName;
    }
}
