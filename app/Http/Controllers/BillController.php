<?php

namespace App\Http\Controllers;


use App\Models\UserModel;
use App\Models\BillDetailModel;
use App\Models\BillModel;
use App\Models\ProductModel;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class BillController extends Controller
{
    private $billModel;
    private $billDetailModel;
    private $productModel;
    private $userModel;
    private $limit = 6;
    public function __construct()
    {

        $this->userModel = new UserModel();

        $this->billDetailModel = new BillDetailModel();

        $this->billModel = new BillModel();

        $this->productModel = new ProductModel();

        $this->limit = 10;
    }
    public function store()
    {
        $total = 0;
        $Date = date("Y/m/d");
        $dataNew = session('data');

        foreach ($dataNew['cart'] as $key => $val) {
            $total += $dataNew['cart'][$key]['SoLuong'] * $dataNew['cart'][$key]['khuyenmai'];
        }

        $data = [
            "NgayTao" => $Date,
            "TinhTrang" => 0,
            "TongTien"  => $total,
            "MaKH"  => $dataNew['userInfo']['MaKH']
        ];

        $ID = $this->billModel->store($data);

        if ($ID) {
            foreach ($dataNew['cart'] as $key => $val) {
                if ($dataNew['cart'][$key]['SoLuong'] == 0) {
                    continue;
                }

                $product = $this->productModel->findById($key);
                $product = json_decode(json_encode($product), True);

                if ($product['SoLuong'] == 0) {
                    continue;
                }
                $Mount = $product['SoLuong'] - $dataNew['cart'][$key]['SoLuong'];

                $data = [
                    "SoLuong"   => $Mount,
                ];
                $this->productModel->updateData($key, $data);


                $data = [
                    "MaHD" => $ID,
                    "MaSP" => $key,
                    "DonGia"  => $dataNew['cart'][$key]['khuyenmai'],
                    "SoLuong"  => $dataNew['cart'][$key]['SoLuong']
                ];
                $this->billDetailModel->store($data);
            }
            unset($dataNew['cart']);
            session()->put('data.cart', []);

            echo "Đặt hàng thành công";
        } else {
            echo "Đặt hàng thất bại";
        }
    }
    public function showDetail()
    {
        $id = $_POST['id'][0];

        $bill = $this->billModel->findById($id);

        $user = $this->userModel->findById($bill->MaKH);

        $productTemp = $this->billDetailModel->getByBillID($id);
        $productTemp = json_decode(json_encode($productTemp), True);

        foreach ($productTemp as $key => $value) {
            //Lấy sản phẩm
            $product = $this->productModel->findById($productTemp[$key]['MaSP']);
            $productTemp[$key] += ['TenSp' => $product->TenSP];
            $productTemp[$key] += ['img' => $product->img];
            $productTemp[$key] += ['MaTl' => $product->MaTL];
            $productTemp[$key] += ['TinhTrang' => $bill->TinhTrang];

            $productTemp[$key] += ['MaHD' => $bill->MaHD];
        }
        $dataNew = session('data');
        $dataNew['bill'] = $bill;
        $dataNew['productTemp'] = $productTemp;

        //show detail user
        if (isset($_POST['option'])) {
            return view('frontend.info.bill-detail', ['data' => $dataNew]);
        }
        //show detail admin
        $dataNew = json_decode(json_encode($dataNew), True);
        return view('admin.bill.showDetail', ['data' => $dataNew]);
    }

    public function updateDetailBillForUser()
    {

        $product = $this->productModel->findById($_POST['MaSP']);
        $billDetail = $this->billDetailModel->getByIDPB($_POST['MaHD'], $_POST['MaSP']);

        $product = json_decode(json_encode($product), True);
        $billDetail = json_decode(json_encode($billDetail), True);

        if ($_POST['option'] == "des") {
            if ($billDetail[0]['SoLuong'] > 0) {

                $Mount = $product['SoLuong'] + 1;
                $data = ['SoLuong'   => $billDetail[0]['SoLuong'] - 1];
            } else {
                $Mount = $product['SoLuong'];
                $data = ['SoLuong'   => $billDetail[0]['SoLuong']];
            }
        } else {
            $Mount = $product['SoLuong'];
            if ($product['SoLuong'] > 0) {
                $Mount = $product['SoLuong'] - 1;
                $data = [
                    'SoLuong'   => $billDetail[0]['SoLuong'] + 1
                ];
            }
        }
        $this->billDetailModel->updateData($_POST['MaHD'], $_POST['MaSP'], $data);
        // load total and details bill for bill after update
        [$productTemp, $total] = $this->loadDetailForBillAfterUpdate($Mount);

        $data = [
            'TongTien' => $total
        ];
        $this->billModel->updateData($_POST['MaHD'], $data);

        $bill = $this->billModel->findById($_POST['MaHD']);
        $bill = json_decode(json_encode($bill), True);

        $dataNew = session('data');
        $dataNew['bill'] = $bill;
        $dataNew['productTemp'] = $productTemp;
        return view('frontend.info.bill-detail', [
            'data' => $dataNew,
        ]);
    }
    public function loadDetailForBillAfterUpdate($Mount)
    {
        $total = 0;
        $data = [
            "SoLuong"   => $Mount,
        ];
        $this->productModel->updateData($_POST['MaSP'], $data);

        $bill = $this->billModel->findById($_POST['MaHD']);
        $bill = json_decode(json_encode($bill), True);


        $productTemp = $this->billDetailModel->getByBillID($_POST['MaHD']);
        $productTemp = json_decode(json_encode($productTemp), True);

        foreach ($productTemp as $key => $value) {
            $product = $this->productModel->findById($productTemp[$key]['MaSP']);
            $product = json_decode(json_encode($product), True);
            $productTemp[$key] += ['TenSp' => $product['TenSP']];
            $total += $value['DonGia'] * $value['SoLuong'];
            $productTemp[$key] += ['img' => $product['img']];
            $productTemp[$key] += ['MaTl' => $product['MaTL']];
            $productTemp[$key] += ['TinhTrang' => $bill['TinhTrang']];
        }
        if ($total == 0) {
            $this->billModel->deleteData($_POST['MaHD']);
        }
        return [$productTemp, $total];
    }

    public function deleteDetailBillForUser()
    {
        $idSP = $_POST['MaSP'];
        $idHD = $_POST['MaHD'];
        $Mount = $_POST['mount'];

        $product = $this->productModel->findById($idSP);
        $product = json_decode(json_encode($product), True);

        if ($_POST['option'] == "delete") {

            $Mount = $product['SoLuong'] + $Mount;
        }

        $this->billDetailModel->deleteData($idHD, $idSP);

        [$productTemp, $total] = $this->loadDetailForBillAfterUpdate($Mount);

        $data = [
            'TongTien' => $total
        ];

        $this->billModel->updateData($_POST['MaHD'], $data);

        $bill = $this->billModel->findById($_POST['MaHD']);
        $bill = json_decode(json_encode($bill), True);

        $dataNew = session('data');
        $dataNew['bill'] = isset($bill) > 0 ? $bill : [];
        $dataNew['productTemp'] = $productTemp;

        return view('frontend.info.bill-detail', [
            'data' => $dataNew,
        ]);
    }

    public function update(Request $request)
    {
        $arrInput = $request->all();
        unset($arrInput['_token']);

        $arrInput['TinhTrang'] = $request->has('TinhTrang') ?   $arrInput['TinhTrang'] : 0;
        $this->billModel->updateData(session('id'), $arrInput);

        $bill = $this->billModel->findById(session('id'));
        $productTemp = $this->billDetailModel->getByImportID(session('id'));
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
        $data['bill'] = $bill;
        $user = $this->userModel->findById($bill->MaKH);
        $data['user'] = $user;
        $data = json_decode(json_encode($data), True);

        return view('admin.bill.show', ['data' => $data]);
    }

    public function show($id)
    {
        session(['id' => $id]);
        $bill = $this->billModel->findById($id);
        $bill = json_decode(json_encode($bill), True);

        $user = $this->userModel->findById($bill['MaKH']);
        $user = json_decode(json_encode($user), True);
        $productTemp = $this->billDetailModel->getByBillID($id);
        $productTemp = json_decode(json_encode($productTemp), True);
        foreach ($productTemp as $key => $value) {
            $product = $this->productModel->findById($productTemp[$key]['MaSP']);
            $product = json_decode(json_encode($product), True);

            $productTemp[$key] += ['TenSp' => $product['TenSP']];
        }
        $data['productTemp'] = $productTemp;
        $data['user'] = $user;
        $data['bill'] = $bill;
        $data = json_decode(json_encode($data), True);
        return view('admin.bill.show', ['data' => $data]);
    }

    public function showFormBillDetail()
    {
        $bill = $this->billModel->findById($_POST['MaHD']);

        $billDetail = $this->billDetailModel->getByIDPB($_POST['MaHD'],  $_POST['MaSP'][0]);
        $data['productTemp'] = $billDetail[0];
        $data['bill'] = $bill;
        $data =  json_decode(json_encode($data), True);
        return $this->view('admin.bill.formEditDetailBill', ['data' => $data]);
    }

    public function index(Request $request)
    {

        return Pagination($this->limit, $this->billModel, 'home', 'bill', $request);
    }
    public function pagination(Request $request)
    {

        return Pagination($this->limit, $this->billModel, 'loadTable', 'bill', $request);
    }
}
