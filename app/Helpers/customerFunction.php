<?php
    use Illuminate\Support\Facades\DB;
    
    function Pagination($limit, $model, $pageMain, $title, $request) {
        $data[$title] = $model->getAll();
        $data['totalPage'] = ceil((count($data[$title]))/$limit);
        $data['pageCurrent'] = $request->has('page') ? $request->all()['page'] : 1;
        $ofset = $data['pageCurrent'] - 1;
        $data['byOrder'] = $request->byOrder == 'desc' ? 'asc' :'desc';
        if(!empty($request->column)) {
            $data[$title] = $model->getAll($limit, $ofset*$limit,$data['byOrder'], $request->column);
        } else {
            $data[$title] = $model->getAll($limit, $ofset*$limit,$data['byOrder']);
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
?>