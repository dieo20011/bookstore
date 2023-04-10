<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PublisherModel;

class PublisherController extends Controller
{
    private $publisher;
    private $limit = 3;
    // private $menu;

    public function __construct()
    {
        $this->publisher = new PublisherModel();
        // $this->menu = new MenuModel();
    }
    public function index(Request $request)
    {

        return Pagination($this->limit, $this->publisher, 'home', 'publisher', $request);
    }

    public function pagination(Request $request)
    {

        return Pagination($this->limit, $this->publisher, 'loadTable', 'publisher', $request);
    }

    // $data['menu'] = getGroupSecond($this->menu);
    public function show($id)
    {

        session(['id' => $id]);
        $publisher = $this->publisher->findById($id);
        $data['menu'] = getGroup('danhmuc');

        $data['publisher'] = $publisher;
        $data = json_decode(json_encode($data), True);
        return view('admin.publisher.show', ['data' => $data]);
    }
    public function update(Request $request)
    {
        $arrInput = $request->all();
        unset($arrInput['_token']);

        $this->publisher->updateData(session('id'), $arrInput);

        $publisher = $this->publisher->findById(session('id'));

        $data['publisher'] = $publisher;

        $data['menu'] = getGroup('danhmuc');

        $data = json_decode(json_encode($data), True);

        return view('admin.publisher.show', ['data' => $data]);
    }
    public function add(Request $request)
    {
        $data['menu'] = getGroup('danhmuc');
        $data = json_decode(json_encode($data), True);
        return view('admin.publisher.formAddpublisher', ['data' => $data]);
    }
    public function store(Request $request)
    {

        $arrInput = $request->all();
        unset($arrInput['_token']);
        $this->publisher->store($arrInput);
        return redirect(route('publisher.add'));
    }

    public function delete(Request $request)
    {
        $this->publisher->deleteData($request->id);
        return redirect(route('publisher.index'));
    }
}
