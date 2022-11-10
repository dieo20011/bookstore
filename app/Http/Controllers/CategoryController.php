<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\MenuModel;
use Illuminate\Http\Request;
use DB;
class CategoryController extends Controller
{
    private $category;
    private $limit = 3;
    // private $menu;
    
    public function __construct() {
        $this->category = new CategoryModel();
        // $this->menu = new MenuModel();
    }
    public function index(Request $request) {

        return Pagination($this->limit, $this->category, 'home', 'category', $request);
    }

    public function pagination(Request $request) {
  
        return Pagination($this->limit, $this->category, 'loadTable', 'category', $request);
    }

    public function show($id) {
        $category = $this->category->findById($id);
        $data['menu'] = getGroup('danhmuc');
        // $data['menu'] = getGroupSecond($this->menu);

        $data['category'] = $category;
        $data = json_decode(json_encode($data), True);
        return view('admin.category.show', ['data' => $data]);
    }
    public function update(Request $request)
    {

        dd($request);
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
