<?php

namespace App\Http\Controllers;

use App\Models\AuthorModel;
use App\Models\CategoryModel;
use App\Models\MenuModel;
use App\Models\ProductModel;
use App\Models\PromotionModel;
use App\Models\PublisherModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  
    private $menuModel;
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

        $this->menuModel = new MenuModel();

        $this->categoryModel = new CategoryModel();

        $this->productModel = new ProductModel();

        $this->promotionModel = new PromotionModel();

        $this->authorModel = new AuthorModel();

        $this->publisherModel = new PublisherModel();
    }

    public function loadMenu()
    {
        return json_decode(json_encode($this->menuModel->getAll()), True);
    }

    public function loadForMenu($table)
    {
        $arrMenu = $this->loadMenu();
        $arr = [];
        foreach ($arrMenu as $key => $val) {
            array_push($arr, json_decode(json_encode(getByMenuId($val['MaDM'], $table)), True));
        }
        return $arr;
    }

    public function loadProductForCategory()
    {
        $arrCategory = json_decode(json_encode($this->categoryModel->getAll()), True);

        $arr = [];
        foreach ($arrCategory as $key => $val) {
            //Lấy sản phẩm theo thể loại
            $arrProduct = json_decode(json_encode($this->productModel->getByCategoryId($val['MaTL'])), True);
            $arrProductNew = [];
            //Lấy chi tiết sản phẩm 

            foreach ($arrProduct as $k => $item) {
                if ($item['TTSach'] == 0) {
                    continue;
                }
                $author = json_decode(json_encode($this->authorModel->findById($item['MaTG'])), True);

                $sale = json_decode(json_encode($this->promotionModel->findById($item['MaKM'])), True);
                $discount = 0;
                $today = date("Y-m-d");
                if (strtotime($today) >= strtotime($sale['NgayBatDau']) && strtotime($today) <= strtotime($sale['NgayKetThuc'])) {
                    $discount = round($item['DonGia'] * ((100 - $sale['PhanTram']) / 100), -3);
                    $discount = currency_format($discount);
                }

                $authorName = $author['TenTG'];
                $salePercent = $sale['PhanTram'];

                if ($sale['PhanTram'] == 0 || $sale['TinhTrang'] == 0 || $item['TTKM'] == 0) {
                    $discount = 0;
                    $salePercent = 0;
                }
                // $discount = $this->dicountModel->findById($item['MaKM']);
                $arrProductDetail = [
                    'MaSP'      => $item['MaSP'],
                    'TenSP'     => $item['TenSP'],
                    'DonGia'    => $item['DonGia'],
                    'SoLuong'   => $item['SoLuong'],
                    'TenTG'     => $authorName,
                    'img'       => $item['img'],
                    'MoTa'      => $item['MoTa'],
                    'KhuyenMai' => $salePercent,
                    'discount'  => $discount
                    //customer
                ];

                array_push($arrProductNew, $arrProductDetail);
            }
            array_push($arr, $arrProductNew);
            // array_push($arr, $this->productModel->getByCategoryId($val['MaTL']));
        }
        return $arr;
    }
    public function loadDetailProduct($id, Request $request)
    {
        session(['id' => $id]);

        $arrProduct =  json_decode(json_encode($this->productModel->findById($id)), True);
        $category =  json_decode(json_encode($this->categoryModel->findById($arrProduct['MaTL'])), True);
        $author =  json_decode(json_encode($this->authorModel->findById($arrProduct['MaTG'])), True);
        $publisher =  json_decode(json_encode($this->publisherModel->findById($arrProduct['MaNXB'])), True);
        $sale =  json_decode(json_encode($this->promotionModel->findById($arrProduct['MaKM'])), True);

        $salePercent = $sale['PhanTram'];
        $discount = 0;
        $today = date("Y-m-d");
        if (strtotime($today) >= strtotime($sale['NgayBatDau']) && strtotime($today) <= strtotime($sale['NgayKetThuc'])) {
            $discount = round($arrProduct['DonGia'] * ((100 - $sale['PhanTram']) / 100), -3);
            $discount = currency_format($discount);
        }
        if ($sale['PhanTram'] == 0 || $sale['TinhTrang'] == 0 || $arrProduct['TTKM'] == 0) {
            $discount = $arrProduct['DonGia'];
            $salePercent = 0;
        }
        // $discount = round($arrProduct['DonGia'] * ((100 - $salePercent)/100), -3);
        // $discount = currency_format($discount);

        $save = round($arrProduct['DonGia'] * (($salePercent) / 100), -3);
        $save = currency_format($save);
        $cart = $request->session()->has('cart') ? session('cart'): [];
        $contentPage = 'products/detail.php';
        $dataNew = [
            "cart"        => $cart,
            "products"     => $arrProduct,
            "page"         => $contentPage,
            "category"  => $category,
            "author"    => $author,
            "publisher" => $publisher,
            "khuyenmai" => $discount,
            "save"  => $save,
            "salePercent" => $salePercent,
        ];

        $dataNew['userInfo'] = !is_null(session('data.userInfo')) ? session('data.userInfo') : null;
        session()->put('data.cart', $cart);
        return view('frontend.products.detail', ['data' => $dataNew]);
    }


    public function index(Request $request)
    {
        $arrMenu =  $this->loadMenu();
        $arrAuthor = $this->loadForMenu('tacgia');
        $arrCategoryForMenu = $this->loadForMenu('theloai');
        $arrPublisher = $this->loadForMenu('nxb');
        $arrProduct = $this->loadProductForCategory();
        $arrCategory = json_decode(json_encode($this->categoryModel->getAll(4)), True);
        // $arrProductselling = ?; Danh sách bán chạy
        // $mainPage = 'frontend.masterLayout';
        $contentPage = 'home/index';
        // $dataNew += ['pageNew' => 'form/login.php'];

        $dataNew = [
            "menus"        => $arrMenu,
            "categorys"    => $arrCategoryForMenu,
            "categoryMain" => $arrCategory,
            "authors"      => $arrAuthor,
            "publlisher"   => $arrPublisher,
            "products"     => $arrProduct,
            "page"         => $contentPage,
        ];
        $dataNew['userInfo'] = !is_null(session('data.userInfo')) ? session('data.userInfo') : null;
        $dataNew['cart'] = !is_null(session('data.cart')) ? session('data.cart') : [];
        session()->put('data', $dataNew);
 
        return view('frontend.home.master', ['data' => $dataNew]);
    }
    public function search(Request $request){
        $search = $request->input('search');
        if(empty($search)){
             return view('frontend.home.search', ['books' => []]);
        }
        $booksArray =$this->productModel->search($search);
        $books=[];
        foreach ($booksArray as $k => $book) {
            $author = json_decode(json_encode($this->authorModel->findById($book->MaTG)), True);

            $sale = json_decode(json_encode($this->promotionModel->findById($book->MaKM)), True);
            $discount = 0;
            $today = date("Y-m-d");
            if (strtotime($today) >= strtotime($sale['NgayBatDau']) && strtotime($today) <= strtotime($sale['NgayKetThuc'])) {
                $discount = round($book->DonGia * ((100 - $sale['PhanTram']) / 100), -3);
                $discount = currency_format($discount);
            }
            $authorName = $author['TenTG'];
            $salePercent = $sale['PhanTram'];

            if ($sale['PhanTram'] == 0 || $sale['TinhTrang'] == 0 || $book->TTKM == 0) {
                $discount = 0;
                $salePercent = 0;
            }
            // $discount = $this->dicountModel->findById($item['MaKM']);
            $bookSearchArr = [
                'MaSP'      => $book->MaSP,
                'TenSP'     => $book->TenSP,
                'DonGia'    => $book->DonGia,
                'SoLuong'   => $book->SoLuong,
                'TenTG'     => $authorName,
                'img'       => $book->img,
                'MoTa'      => $book->MoTa,
                'KhuyenMai' => $salePercent,
                'discount'  => $discount
                //customer
            ];

            array_push($books, $bookSearchArr);
        }
        return view('frontend.home.search', ['books' => $books]);
    }
}