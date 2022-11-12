<?php

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;

    function getTitlePage($titleRoute) {
        switch($titleRoute) {
            case 'menu' :
                return "danh mục";
            case 'category' :
                return "thể loại";
            case 'author' :
                return "Tác giả";
        }
    }
    function Pagination($limit, $model, $pageMain, $title, $request) {
        $data[$title] = $model->getAll();
        $data['totalPage'] = ceil((count($data[$title]))/$limit);
        $data['pageCurrent'] = $request->has('page') ? $request->all()['page'] : 1;
        $ofset = $data['pageCurrent'] - 1;
        $data['byOrder'] = $request->byOrder == 'desc' ? 'asc' :'desc';
        $data['title'] = $title;
        $data['titlePage'] = getTitlePage($title);
        if(empty($request->column) || $request->column == 'ID') {
            $data[$title] = $model->getAll($limit, $ofset*$limit, $data['byOrder']);
        } else {
            $data[$title] = $model->getAll($limit, $ofset*$limit, $data['byOrder'], $request->column);
        }
        $data = json_decode(json_encode($data), True);
        return view('admin.'.$title.'.'.$pageMain, ['data' => $data]);
    }

    function getGroup($model) {
        $modelGroup = DB::select('select * from '.$model);
        return $modelGroup;
    }

    function getGroupSecond($model) {
        return $model->getAll();
    }

    function uploadFile($request, $path) {
        $generateImg = 'image'.time().'-img'.'.'
        .$request->img->extension();

        $request->img->move(public_path('img/'.$path), $generateImg); 
        return $generateImg;
    }
?>