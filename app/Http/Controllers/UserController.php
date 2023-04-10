<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userModel;
    private $billModel;
    private $func;
    private $limit;

    public function __construct()
    {

        $this->userModel = new UserModel();
    }
    public function login(Request $request)
    {

        // $dataNew = session('data');

        $dataNew = ['login' => 'form.login'];

        if (isset($dataNew['userInfo'])) {

            unset($dataNew['login']);
        }
        if (!$request->session()->has('data')) {
            $data = [];
            session()->put('data', $data);
        }

        if ($request->session()->has('data')) {
            $products = session()->get('data');
            $products = json_decode(json_encode($products), true);
            $dataNew += $products;
        } else {
            dd("not exit data");
        }
        $mainPage = 'frontend.home.master';
        return view($mainPage, ['data' => $dataNew]);
    }
    public function register(Request $request)
    {

        $dataNew = ['pageNew' => 'form.register'];
        $cart = [];
        if ($request->session()->has('cart')) {
            $cart = session('cart');
        }
        $dataNew += ['cart' => $cart];
        $mainPage = 'frontend.home.master';

        return view($mainPage, ['data' => $dataNew]);
    }
}
