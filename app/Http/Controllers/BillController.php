<?php

namespace App\Http\Controllers;


use App\Models\UserModel;
use App\Models\BillDetailModel;
use App\Models\BillModel;
use App\Models\ProductModel;


use Illuminate\Http\Request;

class BillController extends Controller
{
    private $billModel;
    private $billDetailModel;
    private $productModel;
    private $userModel;
    private $limit;
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
}
