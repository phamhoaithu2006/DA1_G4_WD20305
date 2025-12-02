<?php
// Require toàn bộ các file khai báo môi trường, thực thi,...(không require view)

// Require file Common
require_once './commons/env.php'; // khai báo biến môi trường
require_once './commons/function.php'; // hàm hỗ trợ

// =========================================================
// BỔ SUNG LỆNH REQUIRE CHO LỚP DATABASE TẠI ĐÂY (VỊ TRÍ MỚI)
// Lớp Database phải được load trước khi các Model được load
// vì Model cần lớp Database trong hàm __construct()
// =========================================================
// *LƯU Ý: Nếu file Database.php không nằm trong thư mục models, bạn cần chỉnh lại đường dẫn này*


// Require toàn bộ file Controllers
require_once './controllers/ProductController.php';
require_once './controllers/BookingController.php';
require_once 'controllers/HDVController.php';
require_once 'controllers/EmployeeController.php';
require_once 'controllers/TourAssignmentController.php';
require_once 'controllers/TourCustomerController.php';

// =============================
// BỔ SUNG 2 CONTROLLER MỚI
// =============================
require_once './controllers/TourLogController.php';
require_once './controllers/TourFinanceController.php';

// Require toàn bộ file Models
require_once './models/ProductModel.php';
require_once './models/Booking.php';
require_once './models/HDVModel.php';
require_once './models/EmployeeModel.php';
require_once './models/TourAssignmentModel.php';
require_once './models/TourCustomerModel.php';
require_once './models/DashboardModel.php';

// =============================
// BỔ SUNG 2 MODEL MỚI
// =============================
require_once './models/TourLogModel.php';
require_once './models/TourFinanceModel.php';

// Route
$act = $_GET['act'] ?? '/';
$id = $_GET['id'] ?? '';
// XÓA: Dòng này không cần thiết nếu Model dùng Database::getInstance()
// $db = connectDB(); 
$tourID = isset($_GET['tourID']) ? intval($_GET['tourID']) : null;

// Để bảo bảo tính chất chỉ gọi 1 hàm controller để xử lý request thì mình sử dụng match

match ($act) {

    // Trang chủ
    '/' => (new ProductController())->Home(),
    // Trang admin
    'admin' => (new ProductController())->adminHome(),
    'category' => (new ProductController())->adminDashboard(),
    'detail' => (new ProductController())->adminDetail($id),
    'dashboard' => (new ProductController())->Dashboard(),

    // Trang booking
    // LƯU Ý: Các Controller dưới đây vẫn đang dùng tham số $db. 
    // Nếu bạn muốn dùng lớp Database Singleton, bạn nên xóa tham số ($db) khỏi các constructor này.
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
    // SỬA: Dùng $id đã được xử lý an toàn thay vì $_GET['id']
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
    // TOUR LOG (NHẬT KÝ TOUR)
    // =============================
    'tour-list'         => (new TourLogController())->index($tourID), // <-- thêm dòng này
    'tourlog-list'      => (new TourLogController())->index($tourID),
    'tourlog-create'    => (new TourLogController())->createForm($tourID),
    'tourlog-store'     => (new TourLogController())->store(),
    'tourlog-edit'      => (new TourLogController())->editForm($id),
    'tourlog-update'    => (new TourLogController())->update($id),
    'tourlog-delete'    => (new TourLogController())->delete($id, $tourID),

    // =============================
    // TOUR FINANCE (BÁO CÁO TÀI CHÍNH)
    // =============================
    'finance-list'      => (new TourFinanceController())->index($tourID),
    'finance-create'    => (new TourFinanceController())->createForm($tourID),
    'finance-store'     => (new TourFinanceController())->store(),
    'finance-edit'      => (new TourFinanceController())->editForm($id),
    'finance-update'    => (new TourFinanceController())->update($id),
    'finance-delete'    => (new TourFinanceController())->delete($id, $tourID),

    default => (new ProductController())->Home(),
};
