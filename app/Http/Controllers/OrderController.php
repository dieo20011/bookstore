<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class OrderController extends Controller
{
    private $userModel;

    public function __construct()
    {

        $this->userModel = new UserModel();
    }

    public function confirmAddrress()
    {
        // dd(session('data'));

        if (is_null(session('data.cart')) || count(session('data.cart')) == 0) {
            $dataNew = session()->get('data');
            $dataNew['result'] = "Giỏ hàng rỗng, bạn hãy tham khảo sách ở đây";
            $dataNew['typeMessage'] = "error";
            return view('frontend.home.master', ['data' => $dataNew]);
        } else {
            $total_products = 0;
            foreach (session('data.cart') as $key => $value) {
                $total_products += session('data.cart')[$key]['SoLuong'];
            }
            if ($total_products == 0) {
                echo "Giỏ hàng rỗng";
            } else {
                if (is_null(session('data.userInfo'))) {
                    $dataNew = session('data');
                    $mainPage = 'frontend.home.master';
                    $contentPage = 'frontend.form.login';
                    $dataNew["login"]  = $contentPage;

                    return view($mainPage, ['data' => $dataNew]);
                } else {
                    $user = $this->userModel->findById(session('data.userInfo.MaKH'));
                    $arrInfor = explode(",", $user->ThongTinGiaoHang);
                    $dataNew = session('data');

                    $dataNew["address-infor"] = $arrInfor;
                    $mainPage = 'frontend.home.master';
                    $contentPage = 'frontend.payment.index';
                    $dataNew["pageNew"]  = $contentPage;
                    $dataNew["nextPage"]  = "voucher";

                    session()->put('data', $dataNew);
                    return view($mainPage, ['data' => $dataNew]);
                }
            }
        }
    }
    public function discountPage()
    {
        $dataNew = session('data');
        $mainPage = 'frontend.payment.pay';
        unset($dataNew["nextPage"]);
        $dataNew["nextPage"]  = "confirm";
        return view($mainPage, ['data' => $dataNew]);
    }
    public function confirmPage()
    {
        $dataNew = session('data');
        $arrInfor = explode(",",  $dataNew['userInfo']['ThongTinGiaoHang']);
        $dataNew["address-infor"] = $arrInfor;
        $mainPage = 'frontend.payment.confirm';
        unset($dataNew["nextPage"]);
        $dataNew["nextPage"]  = "order";
        session()->put('data', $dataNew);
        return view($mainPage, ['data' => $dataNew]);
    }
}
