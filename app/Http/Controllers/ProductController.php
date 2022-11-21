<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;

class ProductController extends Controller
{
    private $product;
    private $limit = 3;
    public function __construct() {
        $this->product = new ProductModel();
    }
    
    public function index(Request $request) {

        return Pagination($this->limit, $this->product, 'home', 'product', $request);
    }
      
    public function pagination(Request $request) {
  
        return Pagination($this->limit, $this->product, 'loadTable', 'product', $request);
    }

    public function show($id) {
        session(['id' => $id]);
        $product = $this->product->findById($id);
        // dd($product);
        $data['menu'] = getGroup('danhmuc');
        $data['category'] = getByCondition('theloai', 'MaTL' , $product->MaTL);
        $data['author'] = getByCondition('tacgia', 'MaTG' , $product->MaTG);
        $data['publisher'] = getByCondition('nxb', 'MaNXB' , $product->MaNXB);
        $data['promotion'] = getByCondition('ctkm', 'MaKM' , $product->MaKM);
        $data['product'] = $product;
        $data = json_decode(json_encode($data), True);
        return view('admin.product.show', ['data' => $data]);
    }

    public function update(Request $request) {
        $arrInput = $request->all();
        $generateImg = '';
        $statusPromotion = $request->has('statusPromotion') ? $request->statusPromotion : 0;
        $status = $request->has('status') ? $request->status: 0;
        if(is_null($request->img)) {
            $product = $this->product->findById(session('id'));
            $generateImg = $product->img;
        } else {
            $generateImg = 'image'.time().'-img'.'.'
            .$request->img->extension();
    
            $request->img->move(public_path('img/product'), $generateImg);
            unset($arrInput['img']);
        }
        unset($arrInput['statusPromotion']);
        unset($arrInput['status']);
        $arrInput[] = $statusPromotion;
        $arrInput[] = $status;
        $arrInput[] = $generateImg;
        unset($arrInput['_token']);
        unset($arrInput['MaDM']);
        
        $arrKeys = array_values($this->product->getColumnName());
        $arrValues = array_values($arrInput);
        // dd($arrKeys, $arrValues, $arrInput);
        $this->product->updateData(session('id'),array_combine($arrKeys, $arrValues) );

        $product = $this->product->findById(session('id'));
        // get ALL Group
        $data['menu'] = getGroup('danhmuc');
        $data['category'] = getByCondition('theloai', 'MaTL' , $product->Matl);
        $data['author'] = getByCondition('tacgia', 'MaTG' , $product->Matg);
        $data['publisher'] = getByCondition('nxb', 'MaNXB' , $product->MaNXB);
        $data['promotion'] = getByCondition('ctkm', 'MaKM' , $product->MaKM);
        $data['product'] = $product;

        $data = json_decode(json_encode($data), True);
       
        return view('admin.product.show', ['data' => $data]);
    }
    public function add(Request $request) {
        $data['menu'] = getGroup('danhmuc');
        $data['category'] = getByCondition('theloai', 'MaDM' , $data['menu']->first()->MaDM);
        $data['author'] = getByCondition('tacgia', 'MaDM' , $data['menu']->first()->MaDM);
        $data['publisher'] = getByCondition('nxb', 'MaDM' , $data['menu']->first()->MaDM);
        $data['promotion'] = getGroup('ctkm');
        $data = json_decode(json_encode($data), True);
        return view('admin.product.formAddProduct', ['data' => $data]);
    }
    public function selectForMenu() {   
        $data['menu'] = getGroup('danhmuc');

        $idMenu = isset($_POST['idSelect']) ? $_POST['idSelect'] : $data['menu']->first()->MaDM ;
        $data['category'] = getByCondition('theloai', 'MaDM' ,  $idMenu);
        $data['author'] = getByCondition('tacgia', 'MaDM' ,  $idMenu);
        $data['publisher'] = getByCondition('nxb', 'MaDM' ,  $idMenu);

        $data = json_decode(json_encode($data), True);

        return view('admin.product.select',['data' => $data]);
    }
    public function store(Request $request) {
        $generateImg = 'image'.time().'-img'.'.'
                            .$request->img->extension();
        $request->img->move(public_path('img/product'), $generateImg);
        $arrInput = $request->all();    
        unset($arrInput['_token']);
        unset($arrInput['img']);
        unset($arrInput['MaDM']);
        if(!$request->has('statusPromotion')) {
            $arrInput[] =  0;
        }
        if(!$request->has('status')) {
            $arrInput[] =  0;
        }

        $arrInput[] = $generateImg;
        
        $arrKeys = array_values($this->product->getColumnName());
        $arrValues = array_values($arrInput);
        // dd($arrInput, $arrKeys);
        $this->product->store(array_combine($arrKeys, $arrValues));        
        return redirect(route('product.add'));
    }

    public function delete(Request $request) {
        $this->product->deleteData($request->id);
        return redirect(route('product.index'));
    }

}
