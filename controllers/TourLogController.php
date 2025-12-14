<?php
// controllers/TourLogController.php

// Vui lòng đảm bảo các file Model sau đã được include/require_once đúng đường dẫn
// Ví dụ:
// require_once 'models/TourLogModel.php';
// require_once 'models/EmployeeModel.php'; 

class TourLogController
{
    public $tourLogModel;
    public $employeeModel;

    public function __construct()
    {
        $this->tourLogModel = new TourLogModel();
        // KHỞI TẠO EmployeeModel
        $this->employeeModel = new EmployeeModel();
    }

    // Hiển thị danh sách Log (Route: tourlog-list)
    public function index($tourID)
    {
        if (!$tourID) {
            echo "Thiếu ID Tour!"; // Hoặc redirect về trang lỗi
            return;
        }

        $logs = $this->tourLogModel->getAllLogsByTour($tourID);
        // Truyền biến sang view
        require_once 'views/admin/tourlog/index.php';
    }

    // Hiển thị form thêm mới (Route: tourlog-create)
    public function createForm($tourID)
    {
        // Lấy TẤT CẢ nhân viên từ Model
        $allEmployees = $this->employeeModel->getAllEmployees();

        // LỌC danh sách nhân viên chỉ giữ lại Hướng dẫn viên và Admin
        $employees = array_filter($allEmployees, function ($employee) {
            return in_array($employee['Role'], ['Hướng dẫn viên', 'Admin']);
        });

        // $tourID và $employees được truyền sang views/admin/tourlog/create.php
        require_once 'views/admin/tourlog/create.php';
    }

    // Xử lý lưu dữ liệu (Route: tourlog-store)
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tourId = $_POST['tour_id'];
            $note = $_POST['note'];
            $incident = $_POST['incident'] ?? null;
            $logType = $_POST['log_type'];
            $employeeId = $_POST['employee_id'];

            // Xử lý upload ảnh
            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/tourlogs/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $targetPath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    $imagePath = $targetPath;
                }
            }

            // CẬP NHẬT: Thêm $employeeId và $logType vào model
            $this->tourLogModel->insertLog($tourId, $employeeId, $note, $imagePath, $incident, $logType);

            // Redirect về trang danh sách
            header("Location: index.php?act=tourlog-list&tourID=" . $tourId);
            exit();
        }
    }

    // Hiển thị form sửa (Route: tourlog-edit)
    public function editForm($id)
    {
        $log = $this->tourLogModel->getLogById($id);
        if (!$log) {
            echo "Không tìm thấy nhật ký!";
            return;
        }

        // Lấy TẤT CẢ nhân viên từ Model
        $allEmployees = $this->employeeModel->getAllEmployees();

        // LỌC danh sách nhân viên chỉ giữ lại Hướng dẫn viên và Admin
        $employees = array_filter($allEmployees, function ($employee) {
            return in_array($employee['Role'], ['Hướng dẫn viên', 'Admin']);
        });

        // Biến $employees và $log được truyền sang views/admin/tourlog/edit.php
        require_once 'views/admin/tourlog/edit.php';
    }

    // Xử lý cập nhật (Route: tourlog-update)
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tourId = $_POST['tour_id'];
            $note = $_POST['note'];
            $incident = $_POST['incident'] ?? null;
            $logType = $_POST['log_type'];
            $employeeId = $_POST['employee_id'];

            // Lấy đường dẫn ảnh cũ để tránh bị mất nếu người dùng không upload ảnh mới
            $currentLog = $this->tourLogModel->getLogById($id);
            $imagePath = $currentLog['Images'] ?? null; // Giữ ảnh cũ

            // Xử lý ảnh mới
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/tourlogs/';
                $fileName = time() . '_' . basename($_FILES['image']['name']);
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $fileName)) {
                    $imagePath = $uploadDir . $fileName;
                }
            }

            // CẬP NHẬT: Thêm $employeeId và $logType vào model
            $this->tourLogModel->updateLog($id, $employeeId, $note, $imagePath, $incident, $logType);

            header("Location: index.php?act=tourlog-list&tourID=" . $tourId);
            exit();
        }
    }

    // Xử lý xóa (Route: tourlog-delete)
    public function delete($id, $tourID)
    {
        $this->tourLogModel->deleteLog($id);
        // $tourID được truyền từ URL để redirect về đúng danh sách
        header("Location: index.php?act=tourlog-list&tourID=" . $tourID);
        exit();
    }
}
