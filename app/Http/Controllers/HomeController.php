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

    public function loadProductForCategory(&$arrCategory, $count = 0)
    {
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
                if ($item['SoLuong'] <= $count) {
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
            if (count($arrProductNew) > 0)
                $arr[$key] = $arrProductNew;
            else
                unset($arrCategory[$key]);
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

        $save = round($arrProduct['DonGia'] * (($salePercent) / 100), -3);
        $save = currency_format($save);
        $cart = $request->session()->has('data.cart') ? session('data.cart') : [];
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
        //get old data
        $dataNew += session('data');

        return view('frontend.products.detail', ['data' => $dataNew]);
    }


    public function index(Request $request)
    {
        $arrMenu =  $this->loadMenu();
        $arrAuthor = $this->loadForMenu('tacgia');
        $arrCategoryForMenu = $this->loadForMenu('theloai');
        $arrPublisher = $this->loadForMenu('nxb');
        $arrCategory = json_decode(json_encode($this->categoryModel->getAll()), True);
        //referent
        $arrProduct = $this->loadProductForCategory($arrCategory);

        $arrCategoryForProductCellings = json_decode(json_encode($this->categoryModel->getAll(100, 0, 'desc')), True);
        $arrProductselling = $this->loadProductForCategory($arrCategoryForProductCellings, 40);
        // $mainPage = 'frontend.masterLayout';, 
        $contentPage = 'home/index';
        // $dataNew += ['pageNew' => 'form/login.php'];

        $dataNew = [
            "menus"        => $arrMenu,
            "categorys"    => $arrCategoryForMenu,
            "categorysForProductsSellig" => $arrCategoryForProductCellings,
            "categoryMain" => $arrCategory,
            "authors"      => $arrAuthor,
            "publlisher"   => $arrPublisher,
            "products"     => $arrProduct,
            "page"         => $contentPage,
            "productsSelling" => $arrProductselling
        ];
        $dataNew['userInfo'] = !is_null(session('data.userInfo')) ? session('data.userInfo') : null;
        $dataNew['cart'] = !is_null(session('data.cart')) ? session('data.cart') : [];
        if (!is_null(session('isAdmin'))) {
            $dataNew['result'] = "Xin lỗi bạn không có quyền truy cập admin";
            $dataNew['typeMessage'] = "error";
            $request->session()->forget('isAdmin');
        }

        session()->put('data', $dataNew);

        return view('frontend.home.master', ['data' => $dataNew]);
    }
    private function loadDeatailForProductSearch($booksArray)
    {
        $books = [];
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
            ];

            array_push($books, $bookSearchArr);
        }
        return $books;
    }
    public function searchByPrice(Request $request)
    {
        if ($request->session()->has('data.booksNew')) {
            $books = session('data.booksNew');
        } else {
            $books = $request->session()->has('data.books') ? session('data.books') : [];
        }
        $books = array_reverse($books);
        $dataNew = session('data');
        unset($dataNew['books']);
        $dataNew['books'] = $books;
        session()->put('data.books', $books);
        return view('frontend.products.listProductForSearch', ['books' => $books]);
    }
    public function searchByMenu(Request $request)
    {
        $condition = $request->all();
        $booksArray = $this->productModel->getByItemChildMenu($condition);
        $books = $this->loadDeatailForProductSearch($booksArray);
        $dataNew = session('data');
        $dataNew['books'] = $books;
        $dataNew['pageNew'] = 'frontend.products.search';
        $dataNew['userInfo'] = !is_null(session('data.userInfo')) ? session('data.userInfo') : null;
        $dataNew['cart'] = !is_null(session('data.cart')) ? session('data.cart') : [];
        unset($dataNew['result']);
        unset($dataNew['typeMessage']);
        session()->put('data.books', $books);
        return view('frontend.home.master', ['data' => $dataNew]);
    }
    public function search(Request $request)
    {
        session()->forget('data.books');
        session()->forget('data.booksNew');
        $search = $request->input('search');
        $dataNew = session('data');
        if (empty($search)) {
            $dataNew = [
                'books' => [],
                'pageNew' => 'frontend.products.search'
            ];
            $dataNew['userInfo'] = !is_null(session('data.userInfo')) ? session('data.userInfo') : null;
            $dataNew['cart'] = !is_null(session('data.cart')) ? session('data.cart') : [];
            return view('frontend.home.master', ['data' => $dataNew]);
        }
        $booksArray = $this->productModel->search($search);

        $books = $this->loadDeatailForProductSearch($booksArray);
        $dataNew = [
            'books' => $books,
            'pageNew' => 'frontend.products.search'
        ];
        $dataNew['userInfo'] = !is_null(session('data.userInfo')) ? session('data.userInfo') : null;
        $dataNew['cart'] = !is_null(session('data.cart')) ? session('data.cart') : [];
        session()->put('data.books', $books);

        if (count($booksArray) <= 0) {
            $booksNew = $this->productModel->getAll();
            $booksNew = $this->loadDeatailForProductSearch($booksNew);
            $dataNew['booksNew'] = $booksNew;
            session()->put('data.booksNew', $booksNew);
        }
        $dataNew += session('data');
        return view('frontend.home.master', ['data' => $dataNew]);
    }
}
