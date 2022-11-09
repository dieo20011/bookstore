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
    public function getAll($limit = 10) {
        $categories = DB::table($this->table)->orderBy($this->ID)->limit($limit)->get();
        return $categories;
    }
    public function findById($id) {
        $category = DB::table($this->table)->where($this->ID, $id)->first();
        return $category;
    }
}
