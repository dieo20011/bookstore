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
        } else {
            $generateImg = 'image'.time().'-img'.'.'
            .$request->img->extension();
    
            $request->img->move(public_path('img/menu'), $generateImg);
    
        }
        
        $name = $request->has('name') ? $request->name : "null"; //validate
        
        $this->menu->updateData(session('id'), ['TenDM' => $name, 'img' => $generateImg]);

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
        $name = $request->has('name') ? $request->name : "null";

        $id = $this->menu->store( ['TenDM' => $name, 'img' => $generateImg]);
        
        $menu = $this->menu->findById($id);
        $data['menu'] = json_decode(json_encode($menu), True);
        return view('admin.menu.formAddMenu', ['data' => $data]);
    }

    public function delete(Request $request) {
        $this->menu->deleteData($request->id);
        return redirect(route('menu.index'));
    }

}
