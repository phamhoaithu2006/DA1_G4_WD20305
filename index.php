<?php
// Require toàn bộ các file khai báo môi trường, thực thi,...(không require view)

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/ProductController.php';
require_once './controllers/BookingController.php';
require_once 'controllers/HDVController.php';
require_once 'controllers/EmployeeController.php';
require_once 'controllers/TourAssignmentController.php';
require_once 'controllers/TourCustomerController.php';

// Require toàn bộ file Models
require_once './models/ProductModel.php';
require_once './models/Booking.php';
require_once './models/HDVModel.php';
require_once './models/EmployeeModel.php';
require_once './models/TourAssignmentModel.php';
require_once './models/TourCustomerModel.php';

// Route
$act = $_GET['act'] ?? '/';
$id = $_GET['id'] ?? '';
$db = connectDB();
$tourID = isset($_GET['tourID']) ? intval($_GET['tourID']) : null;

// Để bảo bảo tính chất chỉ gọi 1 hàm controller để xử lý request thì mình sử dụng match

match ($act) {
    // Trang chủ
    '/' => (new ProductController())->Home(),
    // Trang admin
    'admin' => (new ProductController())->adminHome(),
    'category' => (new ProductController())->adminDashboard(),
    'detail' => (new ProductController())->adminDetail($id),

    // Trang booking
    'booking-list' => (new BookingController($db))->index(),
    'booking-detail' => (new BookingController($db))->detail($id),
    'booking-create' => (new BookingController($db))->create(),

    // Điều hành
    'employees' => (new EmployeeController())->index(),
    'createEmployee' => (new EmployeeController())->create(),
    'editEmployee' => (new EmployeeController())->edit($id),
    'deleteEmployee' => (new EmployeeController())->delete($id),
    'assignments' => (new TourAssignmentController())->index($tourID),
    'createAssignment' => (new TourAssignmentController())->create($tourID),
    'deleteAssignment' => (new TourAssignmentController())->delete($_GET['id'], $tourID),
    'tourcustomers' => (new TourCustomerController())->index($tourID),
    'createTourCustomer' => (new TourCustomerController())->create($tourID),

    // Trang hdv
    'hdv-login' => (new HDVController())->login(),
    'hdv-check-login' => (new HDVController())->checkLogin(),
    'hdv-logout' => (new HDVController())->logout(),
    'hdv-dashboard' => (new HDVController())->dashboard(),
    'hdv-tour' => (new HDVController())->tourList(),
    'hdv-tour-detail' => (new HDVController())->tourDetail($id),
    // Nhật ký & cập nhật tour của hdv
    'hdv-diary-form' => (new HDVController())->diaryForm(),
    'hdv-diary-save' => (new HDVController())->diarySave(),
    'hdv-checkin-checkout' => (new HDVController())->checkInOut(),
    'hdv-checkin-save' => (new HDVController())->checkInSave(),
    'hdv-checkout-save' => (new HDVController())->checkOutSave(),
    'hdv-special-requests' => (new HDVController())->specialRequests(),
    'hdv-special-request-save' => (new HDVController())->specialRequestSave(),
};
