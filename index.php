<?php
// index.php

// 1. REQUIRE CÁC FILE CHUNG (ĐỂ CÓ CÁC HẰNG SỐ CẤU HÌNH CẦN THIẾT)
// =========================================================
require_once './commons/env.php';      // Khai báo biến môi trường (DB_HOST, DB_NAME,...)
require_once './commons/function.php';   // Hàm hỗ trợ (uploadFile, deleteFile,...)

// 2. BỔ SUNG LỆNH REQUIRE CHO LỚP DATABASE
// Lớp Database phải được load ngay sau env.php vì nó sử dụng các hằng số DB
// =========================================================
require_once './commons/Database.php'; 

// 3. KHỞI TẠO KẾT NỐI CSDL BẰNG SINGLETON
// Lớp Database phải được load trước khi bạn gọi phương thức static của nó
// =========================================================
$database_instance = Database::getInstance(); // Lấy đối tượng Database Singleton
$db = $database_instance->getConnection();    // Lấy đối tượng kết nối PDO

if ($db === null) {
    die("Lỗi nghiêm trọng: Không thể thiết lập kết nối cơ sở dữ liệu.");
}
// Bây giờ biến $db đã có kết nối hợp lệ.

// 4. REQUIRE TOÀN BỘ FILE MODELS
// Các Model cần được load trước Controller vì Controller gọi Model trong __construct()
// =========================================================
require_once './models/ProductModel.php';
require_once './models/Booking.php';
require_once './models/HDVModel.php';
require_once './models/EmployeeModel.php';
require_once './models/TourAssignmentModel.php';
require_once './models/TourCustomerModel.php';
require_once './models/DashboardModel.php';
require_once './models/TourLogModel.php';     // BỔ SUNG 2 MODEL MỚI
require_once './models/TourFinanceModel.php'; // BỔ SUNG 2 MODEL MỚI


// 5. REQUIRE TOÀN BỘ FILE CONTROLLERS
// =========================================================
require_once './controllers/ProductController.php';
require_once './controllers/BookingController.php';
require_once 'controllers/HDVController.php';
require_once 'controllers/EmployeeController.php';
require_once 'controllers/TourAssignmentController.php';
require_once 'controllers/TourCustomerController.php';
require_once './controllers/TourLogController.php';      // BỔ SUNG 2 CONTROLLER MỚI
require_once './controllers/TourFinanceController.php'; // BỔ SUNG 2 CONTROLLER MỚI


// 6. ROUTING VÀ XỬ LÝ REQUEST
// =========================================================
$act = $_GET['act'] ?? '/';
$id = $_GET['id'] ?? '';
$tourID = isset($_GET['tourID']) ? intval($_GET['tourID']) : null;

// Bắt đầu định tuyến
match ($act) {

    // Trang chủ
    '/' => (new ProductController())->Home(),
    'admin' => (new ProductController())->adminHome(),
    'category' => (new ProductController())->adminDashboard(),
    'detail' => (new ProductController())->adminDetail($id),
    'dashboard' => (new ProductController())->Dashboard(),

    // Trang booking
    // LƯU Ý: Nếu Model đã dùng Singleton, bạn nên xóa tham số ($db) khỏi Constructor.
    'booking-list' => (new BookingController($db))->index(),
    'booking-detail' => (new BookingController($db))->detail($id),
    'booking-create' => (new BookingController($db))->create(),
    'booking-update-status' => (new BookingController($db))->updateStatus(),

    // Điều hành
    'employees' => (new EmployeeController())->index(),
    'createEmployee' => (new EmployeeController())->create(),
    'detailEmployee' => (new EmployeeController())->detail($id),
    'editEmployee' => (new EmployeeController())->edit($id),
    'deleteEmployee' => (new EmployeeController())->delete($id),

    'assignments' => (new TourAssignmentController())->index($tourID),
    'createAssignment' => (new TourAssignmentController())->create($tourID),
    'deleteAssignment' => (new TourAssignmentController())->delete($id, $tourID),

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
    'hdv-diary-delete' => (new HDVController())->diaryDelete(),
    'hdv-checkin-checkout' => (new HDVController())->checkInOut(),
    'hdv-checkin-save' => (new HDVController())->checkInSave(),
    'hdv-checkout-save' => (new HDVController())->checkOutSave(),
    'hdv-special-requests' => (new HDVController())->specialRequests(),
    'hdv-special-request-save' => (new HDVController())->specialRequestSave(),


    // =============================
    // TOUR LOG (NHẬT KÝ TOUR) - ĐÃ DÙNG SINGLETON (Bỏ $db)
    // =============================
    'tour-list' => (new TourLogController())->index($tourID),
    'tourlog-list' => (new TourLogController())->index($tourID),
    'tourlog-create' => (new TourLogController())->createForm($tourID),
    'tourlog-store' => (new TourLogController())->store(),
    'tourlog-edit' => (new TourLogController())->editForm($id),
    'tourlog-update' => (new TourLogController())->update($id),
    'tourlog-delete' => (new TourLogController())->delete($id, $tourID),

    // =============================
    // TOUR FINANCE (BÁO CÁO TÀI CHÍNH) - ĐÃ DÙNG SINGLETON (Bỏ $db)
    // =============================
    'finance-list' => (new TourFinanceController())->index($tourID),
    'finance-create' => (new TourFinanceController())->createForm($tourID),
    'finance-store' => (new TourFinanceController())->store(),
    'finance-edit' => (new TourFinanceController())->editForm($id),
    'finance-update' => (new TourFinanceController())->update($id),
    'finance-delete' => (new TourFinanceController())->delete($id, $tourID),

    default => (new ProductController())->Home(),
};