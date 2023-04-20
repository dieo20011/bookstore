<?php

namespace App\Http\Controllers;

use App\Models\MenuModel;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    private $menu;
    private $limit = 3;
    public function __construct()
    {
        $this->menu = new MenuModel();
    }

    public function index(Request $request)
    {

        return Pagination($this->limit, $this->menu, 'home', 'menu', $request);
    }

    public function pagination(Request $request)
    {

        return Pagination($this->limit, $this->menu, 'loadTable', 'menu', $request);
    }

    public function show($id)
    {
        session(['id' => $id]);
        $menu = $this->menu->findById($id);
        $data['menu'] = json_decode(json_encode($menu), True);
        return view('admin.menu.show', ['data' => $data]);
    }

    public function update(Request $request)
    {
        $arrInput = $request->all();
        if (is_null($request->img)) {

            $menu = $this->menu->findById(session('id'));
            $generateImg = $menu->img;
            $arrInput['img'] = $generateImg;
        } else {
            $generateImg = 'image' . time() . '-img' . '.'
                . $request->img->extension();

            $request->img->move(public_path('img/menu'), $generateImg);

            $arrInput['img'] = $generateImg;
        }
        unset($arrInput['_token']);

        $this->menu->updateData(session('id'), $arrInput);


        $menu = $this->menu->findById(session('id'));

        $data['menu'] = json_decode(json_encode($menu), True);

        return view('admin.menu.show', ['data' => $data]);
    }
    public function add(Request $request)
    {
        return view('admin.menu.formAddMenu');
    }
    public function store(Request $request)
    {
        $generateImg = 'image' . time() . '-img' . '.'
            . $request->img->extension();
        $request->img->move(public_path('img/menu'), $generateImg);

        $arrInput = $request->all();
        unset($arrInput['_token']);
        $arrInput['img'] = $generateImg;
        $this->menu->store($arrInput);
        return redirect(route('menu.add'));
    }

    public function delete(Request $request)
    {
        // $isCheckForeigKey = checkForeignKey(['tacgia'], $request->id, "MaDM");
        // if (!$isCheckForeigKey) {
        //     $message = "Danh mục đang tồn tại ở bảng khác không thể xóa được vui lòng không xóa";
        // } else {
        //     $message = "Xóa thành công";
        // }
        // $data['message'] = $message;
        // $data['request'] = $isCheckForeigKey;
        $this->menu->deleteData($request->id);
        return redirect(route('menu.index'));
    }
}
