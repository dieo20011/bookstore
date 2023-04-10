<?php

namespace App\Http\Controllers;

use App\Models\AuthorModel;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    private $author;
    private $limit = 3;
    // private $menu;

    public function __construct()
    {
        $this->author = new AuthorModel();
        // $this->menu = new MenuModel();
    }
    public function index(Request $request)
    {

        return Pagination($this->limit, $this->author, 'home', 'author', $request);
    }

    public function pagination(Request $request)
    {

        return Pagination($this->limit, $this->author, 'loadTable', 'author', $request);
    }

    // $data['menu'] = getGroupSecond($this->menu);
    public function show($id)
    {

        session(['id' => $id]);
        $author = $this->author->findById($id);
        $data['menu'] = getGroup('danhmuc');

        $data['author'] = $author;
        $data = json_decode(json_encode($data), True);
        return view('admin.author.show', ['data' => $data]);
    }
    public function update(Request $request)
    {
        $arrInput = $request->all();
        if (is_null($request->img)) {
            // old img
            $author = $this->author->findById(session('id'));
            $generateImg = $author->img;
            $arrInput['img'] = $generateImg;
        } else {
            // new img
            $generateImg = uploadFile($request, 'author');
            unset($arrInput['img']);
            $arrInput['img'] = $generateImg;
        }

        unset($arrInput['_token']);
        $this->author->updateData(session('id'), $arrInput);

        //get after update
        $author = $this->author->findById(session('id'));

        $data['author'] = $author;

        $data['menu'] = getGroup('danhmuc');

        $data = json_decode(json_encode($data), True);

        return view('admin.author.show', ['data' => $data]);
    }
    public function add(Request $request)
    {
        $data['menu'] = getGroup('danhmuc');
        $data = json_decode(json_encode($data), True);
        return view('admin.author.formAddAuthor', ['data' => $data]);
    }
    public function store(Request $request)
    {

        $generateImg = uploadFile($request, 'author');

        $arrInput = $request->all();
        unset($arrInput['_token']);
        $arrInput['img'] = $generateImg;

        $this->author->store($arrInput);
        return redirect(route('author.add'));
    }

    public function delete(Request $request)
    {
        $this->author->deleteData($request->id);
        return redirect(route('author.index'));
    }
}
