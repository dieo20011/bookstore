<?php

namespace App\Http\Controllers;

use App\Models\MenuModel;
use Illuminate\Http\Request;
class MenuController extends Controller
{
    private $menu;
    private $limit = 3;
    public function __construct() {
        $this->menu = new MenuModel();
    }
    
    public function index(Request $request) {

        return Pagination($this->limit, $this->menu, 'home', 'menu', $request);
    }
      
    public function pagination(Request $request) {
  
        return Pagination($this->limit, $this->menu, 'loadTable', 'menu', $request);
    }

    public function show($id) {
        session(['id' => $id]);
        $menu = $this->menu->findById($id);
        $data['menu'] = json_decode(json_encode($menu), True);
        return view('admin.menu.show', ['data' => $data]);
    }

    public function update(Request $request) {
        
        if(is_null($request->img)) {

            $menu = $this->menu->findById(session('id'));
            $generateImg = $menu->img;

            $arrInput = $request->all();
            $arrInput[] = $generateImg;
        } else {
            $generateImg = 'image'.time().'-img'.'.'
            .$request->img->extension();
    
            $request->img->move(public_path('img/menu'), $generateImg);
            
            $arrInput = $request->all();
            unset($arrInput['img']);
            $arrInput[] = $generateImg;
        }
        unset($arrInput['_token']);
        $arrKeys = array_values($this->menu->getColumnName());
        $arrValues = array_values($arrInput);
        
        $this->menu->updateData(session('id'),array_combine($arrKeys, $arrValues) );


        $menu = $this->menu->findById(session('id'));
        
        $data['menu'] = json_decode(json_encode($menu), True);
       
        return view('admin.menu.show', ['data' => $data]);
    }
    public function add(Request $request) {
        return view('admin.menu.formAddMenu');
    }
    public function store(Request $request) {
        $generateImg = 'image'.time().'-img'.'.'
                            .$request->img->extension();
        $request->img->move(public_path('img/menu'), $generateImg);

        $arrInput = $request->all();    
        unset($arrInput['_token']);
        unset($arrInput['img']);
        $arrInput[] = $generateImg;
        $arrKeys = array_values($this->menu->getColumnName());
        $arrValues = array_values($arrInput);
        $this->menu->store(array_combine($arrKeys, $arrValues));        
        return redirect(route('menu.add'));
    }

    public function delete(Request $request) {
        $this->menu->deleteData($request->id);
        return redirect(route('menu.index'));
    }

}
