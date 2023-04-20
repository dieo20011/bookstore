<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BillModel extends Model
{
    use HasFactory;
    protected $table = 'hoadon';
    protected $ID = 'MaHD';
    public function getAll($limit = 10, $start = 0, $orderBy = "asc", $column = 'MaHD')
    {
        $bills = DB::table($this->table)->orderBy($column, $orderBy)->offset($start)->limit($limit)->get();
        return $bills;
    }
    public function findById($id)
    {
        $bills = DB::table($this->table)->where($this->ID, $id)->first();
        return $bills;
    }
    public function updateData($id, $data)
    {
        $bills = DB::table($this->table)->where($this->ID, $id)->update($data);
        return $bills;
    }

    public function deleteData($id)
    {
        $bills = DB::table($this->table)->where($this->ID, $id)->delete();
        return $bills;
    }

    public function store($data)
    {
        $bills = DB::table($this->table)->insertGetId($data);
        return $bills;
    }
    public function getByIDUser($id)
    {
        $bills = DB::table($this->table)->where("MaKH",  $id)->get();
        return $bills;
    }
    public function searchForTimes($IDPerson, $FromDate, $ToDate)
    {
        $billDetail = DB::table($this->table)
            ->where("MaKH", '=', $IDPerson)
            ->whereBetween('NgayTao', [$FromDate, $ToDate])
            ->get();
        return $billDetail;
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
