<?php

namespace App\Http\Controllers;

use App\Models\AuthorModel;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\PromotionModel;
use App\Models\PublisherModel;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private $categoryModel;
    private $productModel;
    private $authorModel;
    private $promotionModel;
    private $publisherModel;
    public function __construct()
    {
        $this->loadAllModel();
    }

    public function loadAllModel()
    {
        $this->categoryModel = new CategoryModel();

        $this->productModel = new ProductModel();

        $this->promotionModel = new PromotionModel();

        $this->authorModel = new AuthorModel();

        $this->publisherModel = new PublisherModel();
    }

    public function loadDetailProduct($id, Request $request)
    {
        $product = json_decode(json_encode($this->productModel->findById($id)), True);

        if (!$request->session()->has('cart')) {
            $listProduct = [];
            if ($product['SoLuong'] <= 0) {
                $product['SoLuong'] = 0;
            } else {
                $product['SoLuong'] = 1;
            }
            $listProduct[$id] = $product;
            session()->put('cart', $listProduct);
        } else {
            $products = session()->get('cart');
            $products = json_decode(json_encode($products), true);
            if ($product['SoLuong'] <= 0) {
                $product['SoLuong'] = 0;
            } else {

                $product['SoLuong'] = 1;
            }
            if (isset($products[$id])) {
                $products[$id]['SoLuong'] += $product['SoLuong'];
            } else {
                $product['SoLuong'] = $product['SoLuong'];
                $products[$id] = $product;
            }
            session()->put('cart', $products);
        }
        $products = session('cart');
        $total_products = 0;
        $total_prices = 0;
        foreach ($products as $key => $val) {
            $total_products += $products[$key]['SoLuong'];

            $sale =  json_decode(json_encode($this->promotionModel->findById($products[$key]['MaKM'])), True);

            $salePercent = $sale['PhanTram'];
            $discount = round($products[$key]['DonGia'] * ((100 - $salePercent) / 100), -3) *  $products[$key]['SoLuong'];
            $products[$key]['khuyenmai'] =  round($products[$key]['DonGia'] * ((100 - $salePercent) / 100), -3);
            $total_prices += $discount;
        }
        session()->put('cart', $products);
        // unset($products);
        $category = json_decode(json_encode(($this->categoryModel->findById($product['MaTL']))), True);

        $author = json_decode(json_encode(($this->authorModel->findById($product['MaTG']))), True);

        $publisher = json_decode(json_encode(($this->publisherModel->findById($product['MaNXB']))), True);

        $sale = json_decode(json_encode(($this->promotionModel->findById($product['MaKM']))), True);

        $salePercent = $sale['PhanTram'];
        $discount = round($product['DonGia'] * ((100 - $salePercent) / 100), -3);
        $discount = currency_format($discount);

        $save = round($product['DonGia'] * (($salePercent) / 100), -3);
        $save = currency_format($save);
        $mainPage = 'frontend.masterLayout';
        $contentPage = 'cart.cartNotification';
        $dataNew = [

            "products"     => $product,
            "page"         => $contentPage,
            "category"  => $category,
            "author"    => $author,
            "publisher" => $publisher,
            "khuyenmai" => $discount,
            "save"  => $save,
            "salePercent" => $salePercent,
            "notification"  => 1,
            "soluongsp" => $total_products,
            "tongtien"  => $total_prices,
            "cart"      => json_decode(json_encode(session('cart')), true)
            // "userInfo" => $_SESSION['data']['userInfo']
        ];
        return view('frontend.products.detail', ['data' => $dataNew]);
    }

    public function index()
    {
        $dataNew = $_SESSION['data'];


        $dataNew['page'] = 'carts/index.php';

        $mainPage = 'frontend.masterLayout';
        return $this->view($mainPage, $dataNew);
    }

    public function update()
    {
        $message = "";
        if (isset($_POST['option'])) {
            if ($_POST['option'] == "des") {
                if ($_SESSION[$_POST['MaSP']]['SoLuong'] > 0) {
                    $_SESSION[$_POST['MaSP']]['SoLuong'] -= 1;
                }
            } else {
                $condition = [
                    'column'    => 'MaSP',
                    'value'     => $_POST['MaSP']
                ];

                $arrProduct = $this->productModel->findById($condition);
                if ($_SESSION[$_POST['MaSP']]['SoLuong'] >= $arrProduct['SoLuong']) {
                    $message = "Sản phẩm không đủ";
                } else {

                    $_SESSION[$_POST['MaSP']]['SoLuong'] += 1;
                }
            }
        }

        $mainPage = 'frontend.carts.cart-form';


        // result 
        return $this->view($mainPage, [
            "message" => $message
        ]);
    }

    public function delete()
    {
        if (!isset($_POST['option'])) {

            if (isset($_POST['MaSP'])) {
                unset($products[$_POST['MaSP']]);
                $mainPage = 'frontend.blocks.cart-block';
                return $this->view($mainPage, []);
            }
        } else {
            if (isset($_POST['MaSP'])) {
                unset($products[$_POST['MaSP']]);
                $mainPage = 'frontend.carts.cart-form';
                return $this->view($mainPage, []);
            }
        }
    }
}
