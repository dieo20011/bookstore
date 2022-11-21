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
    public function index1() {
        return view('frontend.home.master');
    }
    private $menuModel;
        private $categoryModel;
        private $productModel;
        private $authorModel;
        private $promotionModel;
        
        public function __construct() {
            $this->loadAllModel();
        }

        public function loadAllModel() {

            $this->menuModel = new MenuModel();

            $this->categoryModel = new CategoryModel();

            $this->productModel = new ProductModel();
                        
            $this->promotionModel = new PromotionModel();
            
            $this->authorModel = new AuthorModel();

            $this->publisherModel = new PublisherModel();
        }

        public function loadMenu() {
            return json_decode(json_encode($this->menuModel->getAll()), True);
        }

        public function loadForMenu($table) {
            $arrMenu = $this->loadMenu(); 
            $arr = [];
            foreach($arrMenu as $key => $val) {
                array_push($arr, json_decode(json_encode(getByMenuId($val['MaDM'], $table)), True));
            } 
            return $arr;
        }

        public function loadProductForCategory() {
            $arrCategory = json_decode(json_encode($this->categoryModel->getAll()), True);

            $arr = [];
            foreach($arrCategory as $key => $val) {
                //Lấy sản phẩm theo thể loại
                $arrProduct = json_decode(json_encode($this->productModel->getByCategoryId($val['MaTL'])), True);
                $arrProductNew = [];
                //Lấy chi tiết sản phẩm 

                foreach ($arrProduct as $k => $item) {
                    $author = json_decode(json_encode($this->authorModel->findById($item['MaTG'])), True);
                    
                    $sale = json_decode(json_encode($this->promotionModel->findById($item['MaKM'])), True);

                    $authorName = $author['TenTG'];
                    $salePercent = $sale['PhanTram'];
                    $discount = round($item['DonGia'] * ((100 - $sale['PhanTram'])/100), -3);
                    $discount = currency_format($discount);
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

        public function index() {
            $arrMenu =  $this->loadMenu();
            $arrAuthor = $this->loadForMenu( 'tacgia');
            $arrCategoryForMenu = $this->loadForMenu( 'theloai');
            $arrPublisher = $this->loadForMenu( 'nxb');
            $arrProduct = $this->loadProductForCategory();
            $arrCategory = json_decode(json_encode($this->categoryModel->getAll(4)), True);
            // $arrProductselling = ?; Danh sách bán chạy
            // $mainPage = 'frontend.masterLayout';
            $contentPage = 'home/index.php';

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
            //Nếu có đăng nhập trả về thêm userInfor
            // if(isset($_SESSION['data'])) {
            //     if(isset($_SESSION['data']['userInfo'])) {
                    
            //         $dataNew += ["userInfo"     => $_SESSION['data']['userInfo']];
            //         return $this->view($mainPage, $dataNew);

            //     } else return $this->view($mainPage, $dataNew);
                //Nếu không đăng nhập trả về mới

            // }
            return view('frontend.home.master', ['data' => $dataNew]);
            
        }

}
