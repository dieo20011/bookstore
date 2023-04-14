<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
class UserController extends Controller
{
    private $userModel;
    private $billModel;
    private $func;
    private $limit;
    private $MAIN_PAGE = 'frontend.home.master';
    private $REGISTER_FORM ='frontend.form.register';
    private $LOGIN_FORM ='frontend.form.login';
    private $TYPE_MESSAGE_SUCESS = "success";
    private $TYPE_MESSAGE_ERROR = "error";

    public function __construct()
    {
        $this->userModel = new UserModel();
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

    public function checkLogin(Request $request) {
        $check  = false;
        $arrInput = $request->all();

        $request->session()->forget('login');
        $dataNew = session()->get('data');
        if($request->has('email') && $request->has('password')) {
            $userInfo = $this->userModel->getUserByAcount( $arrInput['email'], $arrInput['password']);
            if(!empty($userInfo)) {
                $dataNew['userInfo'] = $userInfo;
                if($userInfo->Quyen == 1) {
                    dd("admin");    
                    header("location:./index.php?controller=admin&action=index");
                }
            }
            $errString = "Mật khẩu hoặc tài khoản không đúng";
            $successString =  "Đăng nhập thành công";
            $dataNew['result'] = empty($userInfo)? $errString : $successString;
            $dataNew['typeMessage'] = empty($userInfo)? $this->TYPE_MESSAGE_ERROR : $this->TYPE_MESSAGE_SUCESS;
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
        $dataNew['cart'] = $request->session()->has('cart') ? session('cart'): [];

        return view($this->MAIN_PAGE, ['data' => $dataNew]);
    }


    public function checkRegister(Request $request) {

        $reult = false; 
        $errString = "Lỗi đăng ký";

        if($request->has('name') && $request->has('email')  && $request->has('date') 
         && $request->has('password')  && $request->has('gender')) {
            $arrInput = $request->all();
            $check= is_null($this->userModel->getUserByUserName($arrInput['email'])) ? true : false;
            if($check) {
                $data = [
                    'TenKH' => $arrInput['name'],
                    'GioiTinh'  => $arrInput['gender'],
                    'MatKhau'   =>  md5($arrInput['password']),
                    'Email'     => $arrInput['email'],
                    'Quyen'     => 0,
                    'NgaySinh' =>  $arrInput['date']
                ];
                $reult = $this->userModel->store($data);

            }
            else {
                $errString = "Lỗi tên đăng nhập đã tồn tại";
                $dataNew = session()->get('data');
                $dataNew['result'] = $errString;
                $dataNew['typeMessage'] =  $this->TYPE_MESSAGE_ERROR;
                $dataNew['pageNew'] = $this->REGISTER_FORM;

                return view($this->MAIN_PAGE, ['data' =>$dataNew]);
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
            
            return view($this->MAIN_PAGE, ['data' =>$dataNew]);
            
            
        } else {
            $errString = "Lỗi để trống dữ liệu";
            $dataNew = session()->get('data');
            $dataNew += ['page' => 'home.index'];
            $dataNew['result'] = $errString;
            $dataNew['typeMessage'] = "error";
        
            return view($this->MAIN_PAGE, ['data' =>$dataNew]);
        }
    }
}