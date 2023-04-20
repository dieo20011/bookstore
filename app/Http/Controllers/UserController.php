<?php

namespace App\Http\Controllers;


use App\Models\UserModel;
use App\Models\BillModel;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserController extends Controller
{
    private $userModel;
    private $billModel;
    private $func;
    private $MAIN_PAGE = 'frontend.home.master';
    private $REGISTER_FORM = 'frontend.form.register';
    private $LOGIN_FORM = 'frontend.form.login';
    private $TYPE_MESSAGE_SUCESS = "success";
    private $TYPE_MESSAGE_ERROR = "error";
    private $limit = 5;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->billModel = new BillModel();
    }
    public function login(Request $request)
    {
        $dataNew = [];
        if (!$request->session()->has('data')) {
            session()->put('data', $dataNew);
        } else {
            $dataNew = session('data');
            $dataNew['login'] = $this->LOGIN_FORM;
            $dataNew['result'] = "Xin mời đăng nhập";
            $dataNew['typeMessage'] = $this->TYPE_MESSAGE_SUCESS;
            $dataNew = json_decode(json_encode($dataNew), true);
        }
        return view($this->MAIN_PAGE, ['data' => $dataNew]);
    }
    public function checkLogin(Request $request)
    {
        $check  = false;
        $arrInput = $request->all();

        $request->session()->forget('login');
        $dataNew = session()->get('data');
        if ($request->has('email') && $request->has('password')) {
            $userInfo = $this->userModel->getUserByAcount($arrInput['email'], $arrInput['password']);
            if (!empty($userInfo)) {
                $dataNew['userInfo'] = $userInfo;
                if ($userInfo->Quyen == 1) {
                    session()->put('data.userInfo', $userInfo);
                    return redirect(route('admin'));
                }
            }
            $errString = "Mật khẩu hoặc tài khoản không đúng";
            $successString =  "Đăng nhập thành công";
            $dataNew['result'] = empty($userInfo) ? $errString : $successString;
            $dataNew['typeMessage'] = empty($userInfo) ? $this->TYPE_MESSAGE_ERROR : $this->TYPE_MESSAGE_SUCESS;
            $dataNew = json_decode(json_encode($dataNew), True);
        }
        session()->put('data', $dataNew);
        return view($this->MAIN_PAGE, ['data' => $dataNew]);
    }
    public function logout(Request $request)
    {

        $dataNew = session()->get('data');
        $dataNew['result'] = "Đăng nhập để mua nhiều sách hơn";
        $dataNew['typeMessage'] = "error";
        unset($dataNew['userInfo']);
        unset($dataNew['pageNew']);
        session()->put('data', $dataNew);

        return view($this->MAIN_PAGE, ['data' => $dataNew]);
    }

    public function register(Request $request)
    {

        $dataNew['pageNew'] = $this->REGISTER_FORM;
        $dataNew['cart'] = $request->session()->has('data.cart') ? session('data.cart') : [];
        return view($this->MAIN_PAGE, ['data' => $dataNew]);
    }
    public function checkRegister(Request $request)
    {

        $reult = false;
        $errString = "Lỗi đăng ký";

        if (
            $request->has('name') && $request->has('email')  && $request->has('date')
            && $request->has('password')  && $request->has('gender')
        ) {
            $arrInput = $request->all();
            $check = is_null($this->userModel->getUserByUserName($arrInput['email'])) ? true : false;
            if ($check) {
                $data = [
                    'TenKH' => $arrInput['name'],
                    'GioiTinh'  => $arrInput['gender'],
                    'MatKhau'   =>  md5($arrInput['password']),
                    'Email'     => $arrInput['email'],
                    'Quyen'     => 0,
                    'NgaySinh' =>  $arrInput['date']
                ];
                $reult = $this->userModel->store($data);
            } else {
                $errString = "Lỗi tên đăng nhập đã tồn tại";
                $dataNew = session()->get('data');
                $dataNew['result'] = $errString;
                $dataNew['typeMessage'] =  $this->TYPE_MESSAGE_ERROR;
                $dataNew['pageNew'] = $this->REGISTER_FORM;

                return view($this->MAIN_PAGE, ['data' => $dataNew]);
            }

            //login
            $userInfo = $this->userModel->getUserByAcount($arrInput['email'], $arrInput['password']);
            $dataNew = session()->get('data');
            unset($dataNew['pageNew']);
            unset($dataNew['page']);
            $userInfo = json_decode(json_encode($userInfo), True);

            $dataNew['userInfo'] = $userInfo;
            $dataNew['page'] = 'home.index';
            $dataNew['result'] = "Đăng ký thành công";
            $dataNew['typeMessage'] = $this->TYPE_MESSAGE_SUCESS;

            session()->put('data', $dataNew);
            return view($this->MAIN_PAGE, ['data' => $dataNew]);
        } else {
            $errString = "Lỗi để trống dữ liệu";
            $dataNew = session()->get('data');
            $dataNew += ['page' => 'home.index'];
            $dataNew['result'] = $errString;
            $dataNew['typeMessage'] = "error";

            return view($this->MAIN_PAGE, ['data' => $dataNew]);
        }
    }

    public function update()
    {
        if (isset($_POST['option'])) {
            $arrInfo = explode(', ', implode(', ', session('data.address-infor')));
            $arrInfoItem = (explode(' ', $arrInfo[0]));
            unset($arrInfo[0]);
            $arrInfo = array_merge($arrInfoItem, $arrInfo);
            $dataNew = session('data');
            $dataNew["arr-info"] = $arrInfo;
            $mainPage = 'frontend.payment.formAddress';
            return view($mainPage,  ['data' => $dataNew]);
        }

        $arrAddress = [
            $_POST['Wards'], $_POST['district'], $_POST['province'], $_POST['nation'], $_POST['phone'],
            $_POST['hosueNumber'], $_POST['houseName'], $_POST['way']
        ];
        $arrInfo = [$_POST['Wards'], $_POST['district'], $_POST['province'], $_POST['nation'],  $_POST['phone']];

        $arrAddressCheck = array_filter($arrAddress, function ($value) {
            return $value !== '';
        });
        if (count($arrAddressCheck) != count($arrAddress)) {
            return;
        }
        $stringInfor = "{$_POST['hosueNumber']} {$_POST['houseName']} {$_POST['way']}, ";
        $stringInfor .= implode(', ', $arrInfo);

        $this->userModel->updateData($_POST['id'], ["ThongTinGiaoHang" => $stringInfor]);

        $user = $this->userModel->findById($_POST['id']);
        $user = json_decode(json_encode($user), True);

        $arrInfor = explode(",", $user['ThongTinGiaoHang']);

        $dataNew = session('data');
        session()->put('data.userInfo', $user);

        $dataNew['emtyInfoA'] = true;
        if (empty($dataNew['userInfo']['ThongTinGiaoHang'])) {
            $dataNew['emtyInfoA'] = false;
        }
        $mainPage = 'frontend.payment.infoAddress';
        $dataNew["address-infor"] = $arrInfor;
        return view($mainPage, ['data' => $dataNew]);
    }

    public function showInfo()
    {

        $dataNew = session('data');
        $dataNew['pageNew'] = 'frontend.info.infoUser';
        return view($this->MAIN_PAGE, ['data' => $dataNew]);
    }

    public function showBill()
    {
        $dataNew = session('data');
        $bill = $this->billModel->getByIDUser(session('data.userInfo.MaKH'));
        $dataNew['pageNew'] = 'frontend.info.bill';
        $bill = json_decode(json_encode($bill), True);
        $dataNew['bill'] = $bill;
        return view($this->MAIN_PAGE, ['data' => $dataNew]);
    }
    public function searchForTime()
    {
        $dataNew = session('data');

        if (!isset($_POST['FromDate']) || !isset($_POST['ToDate'])) {
            $since = $_POST['since'];

            $ToDate = date('Y-m-d');
            $FromDate = date('Y-m-d', strtotime("-{$since} days", strtotime($ToDate)));

            $bill = $this->billModel->searchForTimes(session('data.userInfo.MaKH'), $FromDate, $ToDate);
        } else {
            $FromDate = $_POST['FromDate'];
            $ToDate = $_POST['ToDate'];
            $bill = $this->billModel->searchForTimes(session('data.userInfo.MaKH'), $FromDate, $ToDate);
            $dataNew['FromDate'] = $FromDate;
            $dataNew['ToDate'] = $ToDate;
        }

        // $dataNew['pageNew'] = 'frontend.info.list-bill-for-user';
        $bill = json_decode(json_encode($bill), True);
        $dataNew['bill'] = $bill;


        return view("frontend.info.list-bill-for-user", ['data' => $dataNew]);
    }

    public function index(Request $request)
    {

        return Pagination($this->limit, $this->userModel, 'home', 'user', $request);
    }
    public function pagination(Request $request)
    {

        return Pagination($this->limit, $this->userModel, 'loadTable', 'user', $request);
    }
}
