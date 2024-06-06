<?php

// Website có các treang là:
//    Trang chủ
//    Giới thiệu
//    Sản phẩm
//    Chi tiết sản phẩm
//    Liên hệ

// Để định nghĩa được, điều đầu tiên làm là phải tạo Controller trước
// Tiếp theo khai báo function tương ứng
// Bước cuối, định nghĩa đường dẫn

// HTTP Method: get, post(lưu,tạo mới), put(path), delete, option, head
use Pc\XuongOop\Controllers\Client\HomeController;
use Pc\XuongOop\Controllers\Client\AboutController;
use Pc\XuongOop\Controllers\Client\ContactController;
use Pc\XuongOop\Controllers\Client\LoginController;
use Pc\XuongOop\Controllers\Client\ProductController;


$router->get('/',               HomeController::class    . '@index');
$router->get('/about',          AboutController::class   . '@index');

$router->get('/contact',        ContactController::class . '@index');
$router->post('/contact/store', ContactController::class . '@store');

$router->get('/products',       ProductController::class . '@index');
$router->get('/products/{id}',  ProductController::class . '@detail');

$router->get('/login',          LoginController::class . '@showFormLogin');
$router->post('/handle-login',  LoginController::class . '@login');