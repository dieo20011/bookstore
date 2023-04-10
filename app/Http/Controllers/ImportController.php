<?php

namespace App\Http\Controllers;

use App\Models\ImportDetailModel;
use App\Models\ImportModel;
use App\Models\ProductModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    //
    private $import;
    private $limit = 3;
    private $productModel;
    private $supplisherModel;
    private $importDetail;
    // private $menu;

    public function __construct()
    {
        $this->import = new ImportModel();
        $this->productModel = new ProductModel();
        $this->importDetail = new ImportDetailModel();
        $this->supplisherModel = new SupplierModel();
        // $this->menu = new MenuModel();
    }
    public function index(Request $request)
    {

        return Pagination($this->limit, $this->import, 'home', 'import', $request);
    }

    public function pagination(Request $request)
    {

        return Pagination($this->limit, $this->import, 'loadTable', 'import', $request);
    }

    // $data['menu'] = getGroupSecond($this->menu);
    public function show($id)
    {

        session(['id' => $id]);
        $import = $this->import->findById($id);
        $data['product'] = getGroup('sach');
        $data['supplisher'] = getGroup('ncc');
        $data['import'] = $import;
        $productTemp = $this->importDetail->getByImportID($id);
        $productTemp = json_decode(json_encode($productTemp), True);
        foreach ($productTemp as $key => $value) {
            //Lấy sản phẩm
            $product = $this->productModel->findById($value['MaSP']);
            $productTemp[$key] += ['TenSp' => $product->TenSP];
        }
        $data['productTemp'] = $productTemp;
        $data = json_decode(json_encode($data), True);
        return view('admin.import.show', ['data' => $data]);
    }
    public function update(Request $request)
    {
        $arrInput = $request->all();
        unset($arrInput['_token']);

        $arrInput['TinhTrang'] = $request->has('TinhTrang') ?   $arrInput['TinhTrang'] : 0;
        $this->import->updateData(session('id'), $arrInput);

        $import = $this->import->findById(session('id'));
        $productTemp = $this->importDetail->getByImportID(session('id'));
        // lẤy các sp nèm trong phiếu nhập
        $productTemp = json_decode(json_encode($productTemp), True);
        foreach ($productTemp as $key => $value) {
            //Lấy sản phẩm
            $product = $this->productModel->findById($productTemp[$key]['MaSP']);
            $product = json_decode(json_encode($product), True);
            if ($request->has('TinhTrang')) {
                $dataUpdate = [
                    'SoLuong'   => $value['SoLuong'] + $product['SoLuong']
                ];
                $this->productModel->updateData($productTemp[$key]['MaSP'], $dataUpdate);
            }

            $productTemp[$key] += ['TenSp' => $product['TenSP']];
        }
        $data['productTemp'] = $productTemp;
        $data['import'] = $import;
        $data['supplisher'] = getGroup('ncc');

        $data = json_decode(json_encode($data), True);

        return view('admin.import.show', ['data' => $data]);
    }
    public function showFormImportDetail(Request $request)
    {

        // lấy phiếu nhập chi tiết
        $import = $this->importDetail->findById(session('id'));

        $importDetail = $this->importDetail->getByIDPI($request->MaPN,  $_POST['MaSP'][0]);
        $data['productTemp'] = $importDetail[0];
        $data['import'] = $import;
        $data =  json_decode(json_encode($data), True);
        return view('admin.import.formEditDetailImport', ['data' => $data]);
    }
    public function updateDetailImport()
    {

        // update chi tiêt
        $data = [
            'DonGia' => $_POST['DonGia'],
            'SoLuong'   => $_POST['SoLuong'],
        ];
        $this->importDetail->updateData($_POST['MaPN'], $_POST['MaSP'], $data);

        // update tổng tiền
        $import = $this->import->findById($_POST['MaPN']);
        $total = 0;
        $productTemp = $this->importDetail->getByImportID($_POST['MaPN']);
        // lẤy các sp nèm trong phiếu nhập
        $productTemp = json_decode(json_encode($productTemp), True);
        foreach ($productTemp as $key => $value) {
            //Lấy sản phẩm
            $product = $this->productModel->findById($productTemp[$key]['MaSP']);
            $product = json_decode(json_encode($product), True);

            $productTemp[$key] += ['TenSp' => $product['TenSP']];
            $total += $value['DonGia'] * $value['SoLuong'];
        }
        $data = [
            'TongTien' => $total
        ];
        $this->import->updateData($_POST['MaPN'], $data);
        $import = $this->import->findById($_POST['MaPN']);
        $data['supplisher'] = getGroup('ncc');
        $data['import'] = $import;
        $data['productTemp'] = $productTemp;
        $data = json_decode(json_encode($data), True);
        return view('admin.import.show', ['data' => $data]);
    }

    public function add(Request $request)
    {
        // $data['menu'] = getGroup('danhmuc');
        $data['product'] = getGroup('sach');
        $data['supplisher'] = getGroup('ncc');

        $data = json_decode(json_encode($data), True);
        return view('admin.import.formAddImport', ['data' => $data]);
    }
    //Show detail not edit
    public function showDetail()
    {

        $import = $this->import->findById($_POST['id'][0]);
        $supplisher = $this->supplisherModel->findById($import->MaNCC);

        $productTemp = $this->importDetail->getByImportID($_POST['id'][0]);
        $productTemp = json_decode(json_encode($productTemp), True);
        foreach ($productTemp as $key => $value) {
            //Lấy sản phẩm
            $product = $this->productModel->findById($productTemp[$key]['MaSP']);
            $productTemp[$key] += ['TenSp' => $product->TenSP];
        }
        $data['import'] = $import;
        $data['productTemp'] = $productTemp;
        $data['supplisher'] = $supplisher;
        $data = json_decode(json_encode($data), True);
        return view('admin.import.showDetail', ['data' => $data]);
    }


    public function store(Request $request)
    {

        $products = $request->session()->get('productTemp');
        $products = json_decode(json_encode($products), True);
        //count($products) == 0 --> return        
        $totalImport = 0;
        foreach ($products as $key => $val) {
            $totalImport += $val['SoLuong'] * $val['DonGia'];
        }

        $arrInput = $request->all();
        unset($arrInput['_token']);
        unset($arrInput['SoLuong']);
        unset($arrInput['DonGia']);
        unset($arrInput['MaSP']);

        if (!$request->has('TinhTrang')) {
            $arrInput['TinhTrang'] =  0;
        }
        $arrInput["TongTien"] = $totalImport;
        $newIDImport = $this->import->store($arrInput);


        $arrKeysImportDetail = array_values($this->importDetail->getColumnName());

        foreach ($products as $key => $val) {
            $data = [$newIDImport, $val['MaSP'], $val['DonGia'], $val['SoLuong']];
            $arrKeys = array_merge(['MaPN'], array_values($arrKeysImportDetail));
            $this->importDetail->store(array_combine($arrKeys, $data));
            if ($request->has('TinhTrang')) {
                $productItem = $this->productModel->findById($val['MaSP']);
                $newCount = $productItem->SoLuong + $val['SoLuong'];
                $this->productModel->updateData($val['MaSP'], ['SoLuong' => $newCount]);
            }
            $arrKeys = [];
        }

        $request->session()->forget('productTemp');
        return redirect(route('import.add'));
    }
    public function addImportTemp(Request $request)
    {

        $check = true;
        if (!$request->session()->has('productTemp')) {
            $listImportDetail = [];
            session()->put('productTemp', $listImportDetail);
        }

        if ($request->session()->has('productTemp')) {
            $products = session()->get('productTemp');
            $products = json_decode(json_encode($products), true);
            foreach ($products as $key => $val) {
                if ($key == $request->MaSP) {
                    $products[$key]['SoLuong'] += $request->Mount;
                    $products[$key]['DonGia'] = $request->Price;
                    $check = false;
                    break;
                }
            }
            session()->put('productTemp', $products);
        }


        if ($check == true) {
            $products = session()->get('productTemp');
            $listImportDetail = json_decode(json_encode($products), true);

            $product = $this->productModel->findById($request->MaSP);

            $data = [
                "MaSP"  => $request->MaSP,

                "TenSP" => $product->TenSP,

                "DonGia"    => $request->Price,

                "SoLuong"  => $request->Mount
            ];
            $listImportDetail[$request->MaSP] = $data;

            session()->put('productTemp', $listImportDetail);
        }
        var_dump(session()->get('productTemp'));
        return view('admin.import.addTempImportDetail', [
            'data'   => ['productTemp' => session()->get('productTemp')]
        ]);
    }

    public function delete(Request $request)
    {
        $this->import->deleteData($request->id);
        return redirect(route('import.index'));
    }
}
