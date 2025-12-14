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
    'service-add' => (new ProductController())->serviceCreate(), // Hiển thị form
    'service-store' => (new ProductController())->serviceStore(),
    // --- QUẢN LÝ LỊCH TRÌNH TOUR (ADMIN) ---
    'tour-itinerary-form' => (new ProductController())->itineraryForm($id),
    'tour-itinerary-store' => (new ProductController())->itineraryStore(),
    'tour-itinerary-delete' => (new ProductController())->itineraryDelete($id),

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
    'assign-staff' => (new EmployeeController())->assignTour(), // Xử lý phân công
    'add-special-request' => (new TourAssignmentController())->addSpecialRequest(),
    'update-request-status' => (new TourAssignmentController())->updateRequestStatus(),
    'tour-create' => (new ProductController())->create(),
    'tour-delete' => (new ProductController())->delete($id),

    // --- [BỔ SUNG] ROUTE XỬ LÝ ẢNH GALLERY ---
    'gallery-upload' => (new ProductController())->galleryUpload(),
    'delete-gallery-image' => (new ProductController())->deleteGalleryImage($id, $_GET['tour_id'] ?? 0),

    // ... Các dòng tiếp theo ...
    // --- BÁO CÁO & CHẤT LƯỢNG ---
    'tour-report' => (new ReportController())->tourReport($id),
    'evaluate-staff' => (new ReportController())->evaluateStaff(),
    'report-list' => (new ReportController())->index(),
    // --- VẬN HÀNH TOUR (OPERATIONS) ---
    'schedule' => (new TourAssignmentController())->index(), // Lịch trình tổng quát (Sidebar)
    'operate-tour' => (new TourAssignmentController())->operate($id), // Dashboard điều hành 1 tour
    'update-logistics' => (new TourAssignmentController())->updateLogistics(),
    'remove-staff' => (new TourAssignmentController())->removeStaff(),

    // --- DỊCH VỤ TOUR ---
    'add-service' => (new TourAssignmentController())->addService(), // Đổi tên cho khớp với view: add-service
    'service-status-update' => (new TourAssignmentController())->updateServiceStatus(), // Đổi tên cho khớp logic
    'tour-customer-add' => (new TourAssignmentController())->addTourCustomer(),

    // Nhật kí tour của admin
    'tour-list' => (new TourLogController())->index($tourID),
    'tourlog-list' => (new TourLogController())->index($tourID),
    'tourlog-create' => (new TourLogController())->createForm($tourID),
    'tourlog-store' => (new TourLogController())->store(),
    'tourlog-edit' => (new TourLogController())->editForm($id),
    'tourlog-update' => (new TourLogController())->update($id),
    'tourlog-delete' => (new TourLogController())->delete($id, $tourID),


    // --- BÁO CÁO TÀI CHÍNH ---
    'finance-report' => (new FinanceController($db))->index(),
    'finance-detail' => (new FinanceController($db))->detail($tourID),

    // Route cũ (Hiệu suất TB)
    'tour-performance' => (new FinanceController($db))->performanceReport(),

    // ===> ĐÂY LÀ ROUTE MỚI BẠN CẦN THÊM <===
    'finance-compare' => (new FinanceController($db))->compare(),

    // --- HDV ---
    'hdv-login' => (new HDVController())->login(),
    'hdv-check-login' => (new HDVController())->checkLogin(),
    'hdv-logout' => (new HDVController())->logout(),
    'hdv-dashboard' => (new HDVController())->dashboard(),
    'hdv-tour' => (new HDVController())->tourList(),
    'hdv-tour-detail' => (new HDVController())->tourDetail($id),
    'hdv-room' => (new HDVController())->roomAssign(),
    'hdv-room-save' => (new HDVController())->roomAssignSave(),
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

    // Default
    default => (new ProductController())->Home(),
};
