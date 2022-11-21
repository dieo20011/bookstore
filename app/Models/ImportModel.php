<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class ImportModel extends Model
{
    use HasFactory;
    protected $table = 'phieunhap';
    protected $ID = 'MaPN';
    public function getAll($limit = 10, $start = 0, $orderBy ="asc", $column = 'MaPN') {
        $imports = DB::table($this->table)->orderBy($column, $orderBy)->offset($start)->limit($limit)->get();
        return $imports;
    }
    public function findById($id) {
        $import = DB::table($this->table)->where($this->ID, $id)->first();
        return $import;
    }
    public function updateData($id, $data) {
        $import = DB::table($this->table)->where($this->ID, $id)->update($data);
        return $import;
    }

    public function deleteData($id) {
        $import = DB::table($this->table)->where($this->ID, $id)->delete();
        return $import;
    }

    public function store($data) {
        $import = DB::table($this->table)->insertGetId($data);
        return $import;
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
