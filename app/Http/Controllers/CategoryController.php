<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use Illuminate\Http\Request;
use DB;
class CategoryController extends Controller
{
    private $category;
    
    public function __construct() {
        $this->category = new CategoryModel();
    }
    public function index(Request $request) {
       
        $limit = 8;
        $data['category'] = $this->category->getAll();
        $data['pageCurrent'] = $request->has('page') ? $request->all()['page'] : 1;
        $data = json_decode(json_encode($data), True);
        $data['totalPage'] = ceil(count($data['category'] )/$limit);
        return view('admin.category.home', ['data' => $data]);
    }

    public function show($id) {
        $category = $this->category->findById($id);
        $data['category'] = json_decode(json_encode($category), True);
        return view('admin.category.show', ['data' => $data]);
    }

    public function add(Request $request) {
        return view('admin.category.formAddCategory');
    }
    public function store(Request $request) {
        dd($request->all());
        $name = $request->has('name') ? $request->all()['name'] : "null";
        return view('admin.category.formAddCategory');
    }

}
