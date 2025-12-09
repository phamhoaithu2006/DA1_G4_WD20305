<?php
// Require toàn bộ các file khai báo môi trường, thực thi,...(không require view)

// Require file Common
require_once './commons/env.php'; // khai báo biến môi trường
require_once './commons/function.php'; // hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/ProductController.php';
require_once './controllers/BookingController.php';
require_once 'controllers/HDVController.php';
require_once 'controllers/EmployeeController.php';
require_once 'controllers/TourAssignmentController.php';


// Require toàn bộ file Models
require_once './models/ProductModel.php';
require_once './models/BookingModel.php';
require_once './models/HDVModel.php';
require_once './models/EmployeeModel.php';
require_once './models/TourAssignmentModel.php';

require_once './models/DashboardModel.php';

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
    'dashboard' => (new ProductController())->Dashboard(),
    'tour-create' => (new ProductController())->create(),
    'tour-delete' => (new ProductController())->delete($id),

    // Trang booking
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
    'ct-tour' => (new TourAssignmentController())->showCustomersByTour($tourID),
    // ... Các route cũ ...
    'itinerary-add' => (new TourAssignmentController())->addItinerary(),
    'itinerary-delete' => (new TourAssignmentController())->deleteItinerary(),
    'assign-employee' => (new EmployeeController())->assignTour(),
    // --- BỔ SUNG ROUTE ĐIỀU HÀNH ---
    // 1. Vào trang Dashboard điều hành (Xem dịch vụ & Lịch trình)
    'operate-tour' => (new TourAssignmentController())->operate($id),

    // 2. Xử lý thêm mới Booking/Dịch vụ (Method POST)
    'service-add' => (new TourAssignmentController())->addService(),

    // 3. Xử lý gửi mail & cập nhật trạng thái (Method POST)
    'service-status-update' => (new TourAssignmentController())->changeStatusService(),
    'tour-customer-add' => (new TourAssignmentController())->addTourCustomer(),

    // 4. Xử lý thêm lịch trình chi tiết (Method POST)
    // 'itinerary-add' => (new TourAssignmentController())->addItinerary(),
    // Lịch trình
    'schedule' => (new TourAssignmentController())->index(),
    'hdv-detail' => (new TourAssignmentController())->detail($id),
    'asm-detail-hdv' => (new TourAssignmentController())->getAllHDV(),
    'ct-tour' => (new TourAssignmentController())->showCustomersByTour($tourID),
    // Thông tin theo tour

    // Trang hdv
    'hdv-login' => (new HDVController())->login(),
    'hdv-check-login' => (new HDVController())->checkLogin(),
    'hdv-logout' => (new HDVController())->logout(),
    'hdv-dashboard' => (new HDVController())->dashboard(),
    'hdv-tour' => (new HDVController())->tourList(),
    'hdv-tour-detail' => (new HDVController())->tourDetail($id),
    'hdv-assign-room' => (new HDVController())->tourDetail($id),
    'hdv-assign-rooms' => (new HDVController())->assignRooms(),
    // Nhật ký & cập nhật tour của hdv
    'hdv-diary-form' => (new HDVController())->diaryForm(),
    'hdv-diary-save' => (new HDVController())->diarySave(),
    'hdv-checkin-checkout' => (new HDVController())->checkInOut(),
    'hdv-checkin-save' => (new HDVController())->checkInSave(),
    'hdv-checkout-save' => (new HDVController())->checkOutSave(),
    'hdv-checkin-delete' => (new HDVController())->checkInOutDelete(),
    'hdv-special-requests' => (new HDVController())->specialRequests(),
    'hdv-special-request-save' => (new HDVController())->specialRequestSave(),
};
