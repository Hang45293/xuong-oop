<?php

namespace Pc\XuongOop\Controllers\Admin;

use Pc\XuongOop\Commons\Controller;
use Pc\XuongOop\Commons\Helper;
use Pc\XuongOop\Models\Product;


class DashboardController extends Controller
{
    // private Product $product;

    public function dashboard () {
        $this->renderViewAdmin((__FUNCTION__));
    }

    public function __construct()
    {
        $this->product = new Product();
    }

    }

    //1

// class DashboardController extends Controller
// {
//     public function dashboard () {
//         $this->renderViewAdmin((__FUNCTION__));
//     }
// }
//hết1

// class DashboardController extends Controller
// {
//     private Product $product;

//     public function __construct()
//     {
//         $this->product = new Product();
//     }

//     public function dashboard() {    
//         $products = $this->product->all();

//         $analysisProduct = array_map(function ($item) {
//             return [
//                 $item['name'],
//                 $item['views']
//             ];
//         }, $products);

//         array_unshift($analysisProduct, ['Tên sản phẩm', 'Lượt views']);

//         $this->renderViewAdmin(__FUNCTION__, [
//             'analysisProduct' => $analysisProduct
//         ]);
//     }
// }