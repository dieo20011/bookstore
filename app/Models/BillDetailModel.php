<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BillDetailModel extends Model
{
    use HasFactory;
    protected $table = 'chitiethoadon';
    protected $ID = 'MaHD';
    public function getAll($limit = 10, $start = 0, $orderBy = "asc", $column = 'MaHD')
    {
        $billDetails = DB::table($this->table)->orderBy($column, $orderBy)->offset($start)->limit($limit)->get();
        return $billDetails;
    }
    public function findById($id)
    {
        $billDetail = DB::table($this->table)->where($this->ID, $id)->first();
        return $billDetail;
    }
    public function updateData($id, $idpr, $data)
    {
        $billDetail = DB::table($this->table)->where(
            [
                [$this->ID, '=', $id],
                ['MaSP', '=', $idpr],
            ]
        )->update($data);
        return $billDetail;
    }

    public function getByIDPB($billId, $productID)
    {

        $billDetail = DB::table($this->table)->where(
            [
                [$this->ID, '=', $billId],
                ['MaSP', '=', $productID],
            ]
        )->get();
        return $billDetail;
    }
    public function deleteData($id, $idSP)
    {
        $billDetail = DB::table($this->table)->where([
            [$this->ID, '=', $id],
            ['MaSP', '=', $idSP],
        ])->delete();
        return $billDetail;
    }

    public function store($data)
    {
        $billDetail = DB::table($this->table)->insertGetId($data);
        return $billDetail;
    }

    public function getByImportID($bill)
    {
        return DB::select("SELECT * FROM " . $this->table . " where MaHD = :id", ['id' => $bill]);
    }

    public function getByBillID($billId)
    {

        $billsDetail = DB::table($this->table)->where("MaHD",  $billId)->get();
        return $billsDetail;
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
