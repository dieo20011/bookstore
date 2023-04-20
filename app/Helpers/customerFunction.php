<?php

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;

function getTitlePage($titleRoute)
{
    switch ($titleRoute) {
        case 'menu':
            return "danh mục";
        case 'category':
            return "thể loại";
        case 'author':
            return "tác giả";
        case 'supplier':
            return "nhà cung cấp";
        case 'publisher':
            return "nhà xuất bản";
        case 'promotion':
            return "chương trình khuyến mãi";
        case 'product':
            return "sách";
        case 'import':
            return "phiếu nhập";
        case 'user':
            return "Khách hàng";
        case 'bill':
            return "Hóa đơn";
    }
}
function Pagination($limit, $model, $pageMain, $title, $request)
{
    $data[$title] = $model->getAll();
    $data['totalPage'] = ceil((count($data[$title])) / $limit);
    $data['pageCurrent'] = $request->has('page') ? $request->all()['page'] : 1;
    $ofset = $data['pageCurrent'] - 1;
    $data['byOrder'] = $request->byOrder == 'desc' ? 'asc' : 'desc';
    $data['title'] = $title;
    $data['titlePage'] = getTitlePage($title);
    if (empty($request->column) || $request->column == 'ID') {
        $data[$title] = $model->getAll($limit, $ofset * $limit, $data['byOrder']);
    } else {
        $data[$title] = $model->getAll($limit, $ofset * $limit, $data['byOrder'], $request->column);
    }
    $data = json_decode(json_encode($data), True);
    return view('admin.' . $title . '.' . $pageMain, ['data' => $data]);
}

function getGroup($model)
{
    // $modelGroup = DB::select('select * from '.$model);
    $modelGroup = DB::table($model)->get();
    return $modelGroup;
}
function getByCondition($model, $column, $value)
{
    $modelGroup = DB::table($model)->where($column, $value)->get();
    return $modelGroup;
}
function getGroupSecond($model)
{
    return $model->getAll();
}

function uploadFile($request, $path)
{
    $generateImg = 'image' . time() . '-img' . '.'
        . $request->img->extension();

    $request->img->move(public_path('img/' . $path), $generateImg);
    return $generateImg;
}

function getByMenuId($ID, $table)
{

    $modelGroup = DB::select("SELECT * FROM $table where MaDM = $ID");
    return $modelGroup;
}

function currency_format($number, $suffix = 'đ')
{
    if (!empty($number)) {
        return number_format($number, 0, ',', '.');
    }
}

function compareByDonGia($a, $b)
{
    return $a['DonGia'] - $b['DonGia'];
}

// select * form $table = "a, b, c" where a.id = b.id or b.id = c.id
// [danhmuc, tacgia, nxb, theloai] 'column' value
function checkForeignKey($table, $id, $column)
{
    $checkFK = true;
    for ($i = 0; $i < count($table); $i++) {

        $sql = "SELECT * FROM $table[$i] WHERE $table[$i].$column = $id";
        $query = [];
        $query = _query($sql);
        if (count($query) > 0) {
            $checkFK =  false;
        }
    }
    return $checkFK;
}
function _query($sql)
{
    return DB::select($sql);
}
