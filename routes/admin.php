<?php

// CRUD bao gồm: Danh sách, thêm, sửa, xem, xóa
// User:
//    GET    -> USER/INDEX       -> INDEX       -> Danh sách
//    GET    -> USER/CREATE      -> CREATE      -> Hiện thị FORM thêm mới
//    POST   -> USER/STORE       -> STORE       -> Lưu dữ liệu từ FORM thêm mới vào DB
//    GET    -> USER/ID          -> SHOW($id)   -> Xem chi tiết
//    GET    -> USER/CREATE/EDIT -> EDIT($id)   -> Hiển thị FORM cập nhật
//    PUT    -> USER/ID          -> UPDATE($id) -> Lưu dữ liệu từ FORM cập nhật vào DB
//    DELETE -> USER/ID          -> DELETE($id) -> Xóa bản ghi trong DB

use Pc\XuongOop\Controllers\Admin\UserController;
use Pc\XuongOop\Controllers\Admin\DashboardController;

$router->mount('/admin', function () use ($router) {

    $router->get('/', DashboardController::class . '@dashboard' );

    // CRUD USER
    $router->mount('/users', function () use ($router) {
        $router->get('/',             UserController::class . '@index');
        $router->get('/create',       UserController::class . '@create');
        $router->post('/store',       UserController::class . '@store');
        $router->get('/{id}/show',    UserController::class . '@show');
        $router->get('/{id}/edit',    UserController::class . '@edit');
        $router->post('/{id}/update', UserController::class . '@update');
        $router->get('/{id}/delete', UserController::class . '@delete');
    });
    
    
});


// // CRUD USER
// $router->get('/admin/users/',          UserController::class . '@index');
// $router->get('/admin/users/create',    UserController::class . '@create');
// $router->post('/admin/users/store',    UserController::class . '@store');
// $router->get('/admin/users/{id}',      UserController::class . '@show');
// $router->get('/admin/users/{id}/edit', UserController::class . '@edit');
// $router->put('/admin/users/{id}',      UserController::class . '@update');
// $router->delete('/admin/users/{id}',   UserController::class . '@delete');