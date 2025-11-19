<?php
// Require toàn bộ các file khai báo môi trường, thực thi,...(không require view)

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/ProductController.php';
require_once 'controllers/HDVController.php';

// Require toàn bộ file Models
require_once './models/ProductModel.php';
require_once './models/HDVModel.php';

// Route
$act = $_GET['act'] ?? '/';
$id = $_GET['id'] ?? '';


// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {
    // Trang chủ
    '/' => (new ProductController())->Home(),
    // Trang admin
    'admin' => (new ProductController())->adminHome(),
    'category' => (new ProductController())->adminDashboard(),
    'detail' => (new ProductController())->adminDetail($id),

    // Trang hdv
    'hdv-login' => (new HDVController())->login(),
    'hdv-check-login' => (new HDVController())->checkLogin(),
    'hdv-logout' => (new HDVController())->logout(),
    'hdv-dashboard' => (new HDVController())->dashboard(),
    'hdv-tour' => (new HDVController())->tourList(),
    'hdv-tour-detail' => (new HDVController())->tourDetail($id),
};
