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
    public function getAll($limit = 100, $start = 0, $orderBy = "asc", $column = 'MaSP')
    {
        $products = DB::table($this->table)->orderBy($column, $orderBy)->offset($start)->limit($limit)->get();
        return $products;
    }
    public function findById($id)
    {
        $product = DB::table($this->table)->where($this->ID, $id)->first();
        return $product;
    }
    public function updateData($id, $data)
    {
        $product = DB::table($this->table)->where($this->ID, $id)->update($data);
        return $product;
    }

    public function deleteData($id)
    {
        $product = DB::table($this->table)->where($this->ID, $id)->delete();
        return $product;
    }

    public function store($data)
    {
        $product = DB::table($this->table)->insertGetId($data);
        return $product;
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

    public function getByCategoryId($id, $limit = 15, $start = 0, $orderBy = "DESC", $column = 'SoLuong')
    {
        $products = DB::table($this->table)->where("MaTL", $id)->orderBy($column, $orderBy)->offset($start)->limit($limit)->get();
        return $products;
    }
    public function getByItemChildMenu($condition, $limit = 15, $start = 0, $orderBy = "DESC", $column = 'DonGia')
    {
        $products = DB::table($this->table)->where($condition)->orderBy($column, $orderBy)->offset($start)->limit($limit)->get();
        return $products;
    }

    public function search($search, $limit = 15, $start = 0, $orderBy = "DESC", $column = 'DonGia')
    {
        $products = DB::table('sach as s')
            ->join('tacgia as tg', 's.MaTG', '=', 'tg.MaTG')
            ->join('theloai as tl', 's.MaTL', '=', 'tl.MaTL')
            ->select('s.*', 'tg.TenTG', 'tl.TenTheLoai')
            ->where('s.TenSP', 'like', '%' . $search . '%')
            ->orWhere('tg.TenTG', 'like', '%' . $search . '%')
            ->orWhere('tl.TenTheLoai', 'like', '%' . $search . '%')
            ->orderBy($column, $orderBy)
            ->offset($start)
            ->limit($limit)
            ->get();
        return $products;
    }
}
