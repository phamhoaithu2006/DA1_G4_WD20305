<?php
// Require file Common
require_once './commons/env.php';
require_once './commons/function.php';

// Require Controllers
require_once './controllers/ProductController.php';
require_once './controllers/BookingController.php';
require_once 'controllers/HDVController.php';
require_once 'controllers/EmployeeController.php';
require_once 'controllers/TourAssignmentController.php';
require_once 'controllers/ReportController.php';
require_once 'controllers/TourLogController.php';
require_once 'controllers/FinanceController.php';
require_once 'controllers/SupplierController.php';

// Require Models
require_once './models/ProductModel.php';
require_once './models/BookingModel.php';
require_once './models/HDVModel.php';
require_once './models/EmployeeModel.php';
require_once './models/TourAssignmentModel.php';
require_once './models/DashboardModel.php';
require_once './models/ReportModel.php';
require_once './models/TourLogModel.php';
require_once './models/FinanceModel.php';

// Khởi tạo
$act = $_GET['act'] ?? '/';
$id = $_GET['id'] ?? '';
$db = connectDB();
$tourID = isset($_GET['tourID']) ? intval($_GET['tourID']) : null;

match ($act) {
    // --- TRANG CHỦ & PRODUCT ---
    'home' => (new ProductController())->Home(),
    'category' => (new ProductController())->adminDashboard(), // Danh sách Tour
    'detail' => (new ProductController())->adminDetail($id),
    'dashboard' => (new ProductController())->Dashboard(),
    'tour-create' => (new ProductController())->create(),
    'tour-delete' => (new ProductController())->delete($id),

    // --- BOOKING ---
    'booking-list' => (new BookingController($db))->index(),
    'booking-detail' => (new BookingController($db))->detail(),
    'booking-create' => (new BookingController($db))->create(),
    'booking-update-status' => (new BookingController($db))->updateStatus(),

    // --- ĐIỀU HÀNH & NHÂN SỰ ---
    'employees' => (new EmployeeController())->index(), // Danh sách nhân sự
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
    'hdv-customer-checkin' => (new HDVController())->customerCheckInSave(),
    'hdv-customer-checkout' => (new HDVController())->customerCheckOutSave(),
};
