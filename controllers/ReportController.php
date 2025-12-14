<?php
require_once 'models/ReportModel.php';
require_once 'models/ProductModel.php';

class ReportController {
    private $model;
    private $tourModel;

    public function __construct() {
        $this->model = new ReportModel();
        $this->tourModel = new ProductModel();
    }
    public function index() {
        // Lấy tất cả tour (hoặc chỉ những tour đã kết thúc)
        $tours = $this->tourModel->getAllTour(); 
        require 'views/admin/Report/list.php'; // Bạn cần tạo view này (copy từ trang danh sách tour và đổi nút "Sửa" thành "Xem báo cáo")
    }

    // Hiển thị báo cáo chi tiết 1 Tour
    public function tourReport($tourId) {
        // Lấy thông tin cơ bản
        $tour = $this->tourModel->getOneDetail($tourId);
        
        // 1. Nhật ký / Diễn biến
        $logs = $this->model->getTourLogs($tourId);
        
        // 2. Phản hồi khách hàng
        $feedbacks = $this->model->getFeedback($tourId);
        $avgRating = 0;
        if(count($feedbacks) > 0) {
            $total = 0;
            foreach($feedbacks as $f) $total += $f['Rating'];
            $avgRating = round($total / count($feedbacks), 1);
        }

        // 3. Đánh giá nhân sự
        $staffs = $this->model->getStaffInTour($tourId);
        $evaluations = $this->model->getEvaluations($tourId);

        require 'views/admin/Report/tour_report.php';
    }

    // Xử lý Admin đánh giá nhân viên
    public function evaluateStaff() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Giả sử có session Admin
            $adminId = $_SESSION['user']['EmployeeID'] ?? 1; // ID Admin demo

            $data = [
                'tour_id' => $_POST['tour_id'],
                'employee_id' => $_POST['employee_id'],
                'evaluator_id' => $adminId,
                'score' => $_POST['score'],
                'note' => $_POST['note']
            ];

            $this->model->saveEvaluation($data);
            echo "<script>alert('Đã lưu đánh giá thành công!'); window.history.back();</script>";
        }
    }
}
?>