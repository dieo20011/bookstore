<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ImportDetailModel extends Model
{
    use HasFactory;
    protected $table = 'chitietphieunhap';
    protected $ID = 'MaPN';
    public function getAll($limit = 10, $start = 0, $orderBy ="asc", $column = 'MaPN') {
        $importDetails = DB::table($this->table)->orderBy($column, $orderBy)->offset($start)->limit($limit)->get();
        return $importDetails;
    }
    public function findById($id) {
        $importDetail = DB::table($this->table)->where($this->ID, $id)->first();
        return $importDetail;
    }
    public function updateData($id, $idpr, $data) {
        $importDetail = DB::table($this->table)->where(
            [
                [$this->ID, '=', $id],
                ['MaSP', '=', $idpr],
            ]
            )->update($data);
        return $importDetail;
    }

    public function deleteData($id) {
        $importDetail = DB::table($this->table)->where($this->ID, $id)->delete();
        return $importDetail;
    }

    public function store($data) {
        $importDetail = DB::table($this->table)->insertGetId($data);
        return $importDetail;
    }

    public function getByImportID($importId) {
        return DB::select("SELECT * FROM ".$this->table." where MaPN= :id", ['id' => $importId]);
    }

    public function getByIDPI($importId, $productID) {

        return DB::select("SELECT * FROM ".$this->table." where MaPN = $importId and MaSP = $productID");
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
