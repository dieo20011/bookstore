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

        if (!$request->session()->has('data.cart')) {
            $listProduct = [];
            if ($product['SoLuong'] <= 0) {
                $product['SoLuong'] = 0;
            } else {
                $product['SoLuong'] = 1;
            }
            $listProduct[$id] = $product;
            session()->put('data.cart', $listProduct);
        } else {
            $products = session()->get('data.cart');
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
            session()->put('data.cart', $products);
        }
        $products = session('data.cart');
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
        session()->put('data.cart', $products);
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
            "cart"      => json_decode(json_encode(session('data.cart')), true),
            "userInfo" => !is_null(session('data.userInfo')) ? session('data.userInfo') : null,
        ];
        return view('frontend.products.detail', ['data' => $dataNew]);
    }

    public function index()
    {
        $dataNew = session('data');

        $dataNew['pageNew'] = 'frontend.carts.index';
        $MAIN_PAGE = 'frontend.home.master';
        return view($MAIN_PAGE, ['data' => $dataNew]);
    }

    public function update()
    {
        $dataNew = session()->get('data.cart');
        $message = "";
        if (isset($_POST['option'])) {
            if ($_POST['option'] == "des") {
                if ($dataNew[$_POST['MaSP']]['SoLuong'] > 1) {
                    $dataNew[$_POST['MaSP']]['SoLuong'] -= 1;
                }
            } else {
                $arrProduct = $this->productModel->findById($_POST['MaSP']);
                if ($dataNew[$_POST['MaSP']]['SoLuong'] >= $arrProduct->SoLuong) {
                    $message = "Sản phẩm không đủ";
                } else {
                    $dataNew[$_POST['MaSP']]['SoLuong'] += 1;
                }
            }
        }
        session()->put('data.cart', $dataNew);
        $mainPage = 'frontend.carts.cart-form';
        // result 
        return view($mainPage,['data' => [
            'cart' => $dataNew,
            "message" => $message
            ]
        ] );
    }

    public function delete()
    {
        $dataNew = session()->get('data.cart');
        $mainPage = '';
        if (!isset($_POST['option'])) {
            $mainPage = 'frontend.blocks.cart-block';
        } else {
            $mainPage = 'frontend.carts.cart-form';
        }
        
        unset($dataNew[$_POST['MaSP']]);
        session()->put('data.cart', $dataNew);
        return view($mainPage, ['data' => ['cart' => $dataNew]]);
    }
}
