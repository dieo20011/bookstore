<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierModel extends Model
{
    use HasFactory;
    protected $table = 'ncc';
    protected $ID = 'MaNCC';
    public function getAll($limit = 10, $start = 0, $orderBy ="asc", $column = 'MaNCC') {
        $suppliers = DB::table($this->table)->orderBy($column, $orderBy)->offset($start)->limit($limit)->get();
        return $suppliers;
    }
    public function findById($id) {
        $supplier= DB::table($this->table)->where($this->ID, $id)->first();
        return $supplier;
    }
    public function updateData($id, $data) {
        $supplier = DB::table($this->table)->where($this->ID, $id)->update($data);
        return $supplier;
    }

    public function deleteData($id) {
        $supplier= DB::table($this->table)->where($this->ID, $id)->delete();
        return $supplier;
    }

    public function store($data) {
        $supplier = DB::table($this->table)->insertGetId($data);
        return $supplier;
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
