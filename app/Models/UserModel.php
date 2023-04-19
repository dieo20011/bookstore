<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserModel extends Model
{
    use HasFactory;
    protected $table = 'khachhang';
    protected $ID = 'MaKH';
    public function getAll($limit = 100, $start = 0, $orderBy = "asc", $column = 'MaKH')
    {
        $users = DB::table($this->table)->orderBy($column, $orderBy)->offset($start)->limit($limit)->get();
        return $users;
    }
    public function findById($id)
    {
        $user = DB::table($this->table)->where($this->ID, $id)->first();
        return $user;
    }
    public function updateData($id, $data)
    {
        $user = DB::table($this->table)->where($this->ID, $id)->update($data);
        return $user;
    }
    public function getUserByAcount($name, $pass)
    {
        $pass = md5($pass);
        $user = DB::table($this->table)->where([
            ['Email', '=', $name],
            ['MatKhau', '=', $pass],
        ])->first();
        return $user;
    }
    public function getUserByUserName($name)
    {
        $user = DB::table($this->table)->where([
            ['Email', '=', $name],
        ])->first();
        return $user;
    }
    public function deleteData($id)
    {
        $user = DB::table($this->table)->where($this->ID, $id)->delete();
        return $user;
    }

    public function store($data)
    {
        $user = DB::table($this->table)->insertGetId($data);
        return $user;
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
