<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// MaNXB	TenNXB	MaDM	
class PublisherModel extends Model
{
    use HasFactory;
    protected $table = 'nxb';
    protected $ID = 'MaNXB';
    public function getAll($limit = 10, $start = 0, $orderBy ="asc", $column = 'MaNXB') {
        $publisher = DB::table($this->table)->orderBy($column, $orderBy)->offset($start)->limit($limit)->get();
        return $publisher;
    }
    public function findById($id) {
        $publisher = DB::table($this->table)->where($this->ID, $id)->first();
        return $publisher ;
    }
    public function updateData($id, $data) {
        $publisher  = DB::table($this->table)->where($this->ID, $id)->update($data);
        return $publisher ;
    }

    public function deleteData($id) {
        $publisher = DB::table($this->table)->where($this->ID, $id)->delete();
        return $publisher ;
    }

    public function store($data) {
        $publisher  = DB::table($this->table)->insertGetId($data);
        return $publisher ;
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
