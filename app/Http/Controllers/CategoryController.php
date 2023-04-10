<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
// use App\Models\MenuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    private $category;
    private $limit = 3;
    // private $menu;

    public function __construct()
    {
        $this->category = new CategoryModel();
        // $this->menu = new MenuModel();
    }
    public function index(Request $request)
    {

        return Pagination($this->limit, $this->category, 'home', 'category', $request);
    }

    public function pagination(Request $request)
    {

        return Pagination($this->limit, $this->category, 'loadTable', 'category', $request);
    }

    // $data['menu'] = getGroupSecond($this->menu);
    public function show($id)
    {

        session(['id' => $id]);
        $category = $this->category->findById($id);
        $data['menu'] = getGroup('danhmuc');

        $data['category'] = $category;
        $data = json_decode(json_encode($data), True);
        return view('admin.category.show', ['data' => $data]);
    }
    public function update(Request $request)
    {
        $arrInput = $request->all();
        unset($arrInput['_token']);

        $this->category->updateData(session('id'), $arrInput);

        $category = $this->category->findById(session('id'));

        $data['category'] = $category;

        $data['menu'] = getGroup('danhmuc');

        $data = json_decode(json_encode($data), True);

        return view('admin.category.show', ['data' => $data]);
    }
    public function add(Request $request)
    {
        $data['menu'] = getGroup('danhmuc');
        $data = json_decode(json_encode($data), True);
        return view('admin.category.formAddCategory', ['data' => $data]);
    }
    public function store(Request $request)
    {

        $arrInput = $request->all();
        unset($arrInput['_token']);
        $this->category->store($arrInput);
        return redirect(route('category.add'));
    }

    public function delete(Request $request)
    {
        $this->category->deleteData($request->id);
        return redirect(route('category.index'));
    }
}
