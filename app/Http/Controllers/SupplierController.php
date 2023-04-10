<?php

namespace App\Http\Controllers;

use App\Models\SupplierModel;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    private $supplier;
    private $limit = 3;
    // private $menu;

    public function __construct()
    {
        $this->supplier = new SupplierModel();
        // $this->menu = new MenuModel();
    }
    public function index(Request $request)
    {

        return Pagination($this->limit, $this->supplier, 'home', 'supplier', $request);
    }

    public function pagination(Request $request)
    {

        return Pagination($this->limit, $this->supplier, 'loadTable', 'supplier', $request);
    }

    // $data['menu'] = getGroupSecond($this->menu);
    public function show($id)
    {

        session(['id' => $id]);
        $supplier = $this->supplier->findById($id);
        $data['menu'] = getGroup('danhmuc');

        $data['supplier'] = $supplier;
        $data = json_decode(json_encode($data), True);
        return view('admin.supplier.show', ['data' => $data]);
    }
    public function update(Request $request)
    {
        $arrInput = $request->all();
        unset($arrInput['_token']);

        $this->supplier->updateData(session('id'), $arrInput);

        $supplier = $this->supplier->findById(session('id'));

        $data['supplier'] = $supplier;

        $data['menu'] = getGroup('danhmuc');

        $data = json_decode(json_encode($data), True);

        return view('admin.supplier.show', ['data' => $data]);
    }
    public function add(Request $request)
    {
        $data['menu'] = getGroup('danhmuc');
        $data = json_decode(json_encode($data), True);
        return view('admin.supplier.formAddsupplier', ['data' => $data]);
    }
    public function store(Request $request)
    {

        $arrInput = $request->all();
        unset($arrInput['_token']);
        $this->supplier->store($arrInput);
        return redirect(route('supplier.add'));
    }

    public function delete(Request $request)
    {
        $this->supplier->deleteData($request->id);
        return redirect(route('supplier.index'));
    }
}
