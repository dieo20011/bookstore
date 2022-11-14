<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PromotionModel;
class PromotionController extends Controller
{
    private $promotion;
    private $limit = 3;
    // private $menu;
    
    public function __construct() {
        $this->promotion = new PromotionModel();
        // $this->menu = new MenuModel();
    }
    public function index(Request $request) {

        return Pagination($this->limit, $this->promotion, 'home', 'promotion', $request);
    }

    public function pagination(Request $request) {
  
        return Pagination($this->limit, $this->promotion, 'loadTable', 'promotion', $request);
    }

    // $data['menu'] = getGroupSecond($this->menu);
    public function show($id) {

        session(['id' => $id]);
        $promotion = $this->promotion->findById($id);
        $data['menu'] = getGroup('danhmuc');

        $data['promotion'] = $promotion;
        $data = json_decode(json_encode($data), True);
        return view('admin.promotion.show', ['data' => $data]);
    }
    public function update(Request $request)
    {
        $arrInput = $request->all();
        unset($arrInput['_token']);

        $arrKeys = array_values($this->promotion->getColumnName());
        $arrValues = array_values($arrInput);
        if(!$request->has('status')) {
            $arrValues[] =  0;
        }
        // dd($arrKeys, $arrValues);
        $this->promotion->updateData(session('id'),array_combine($arrKeys, $arrValues) );

        $promotion = $this->promotion->findById(session('id'));
        
        $data['promotion'] = $promotion;

        $data['menu'] = getGroup('danhmuc');
        
        $data = json_decode(json_encode($data), True);

        return view('admin.promotion.show', ['data' => $data]);

    }
    public function add(Request $request) {
        $data['menu'] = getGroup('danhmuc');
        $data = json_decode(json_encode($data), True);
        return view('admin.promotion.formAddpromotion', ['data' => $data]);
    }
    public function store(Request $request) {

        $arrInput = $request->all();    
        unset($arrInput['_token']);
        $arrKeys = array_values($this->promotion->getColumnName());
        $arrValues = array_values($arrInput);
        if(!$request->has('status')) {
            $arrValues[] =  0;
        }
        $this->promotion->store(array_combine($arrKeys, $arrValues)); 
        return redirect(route('promotion.add'));
    }

    public function delete(Request $request) {
        $this->promotion->deleteData($request->id);
        return redirect(route('promotion.index'));
    }
}
