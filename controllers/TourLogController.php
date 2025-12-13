<?php
// controllers/TourLogController.php

class TourLogController
{
    public $tourLogModel;

    public function __construct()
    {
        $this->tourLogModel = new TourLogModel();
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
        require_once 'views/admin/tourlog/create.php';
    }

    // Xử lý lưu dữ liệu (Route: tourlog-store)
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tourId = $_POST['tour_id'];
            $note = $_POST['note'];
            $incident = $_POST['incident'];

            // Giả sử lấy ID nhân viên từ Session Login
            // $employeeId = $_SESSION['user']['id'] ?? 1; 
            $employeeId = 1; // Tạm thời set cứng nếu chưa có login

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

            $this->tourLogModel->insertLog($tourId, $employeeId, $note, $imagePath, $incident);

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
        require_once 'views/admin/tourlog/edit.php';
    }

    // Xử lý cập nhật (Route: tourlog-update)
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tourId = $_POST['tour_id']; // Để redirect về đúng chỗ
            $note = $_POST['note'];
            $incident = $_POST['incident'];

            // Xử lý ảnh
            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/tourlogs/';
                $fileName = time() . '_' . basename($_FILES['image']['name']);
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $fileName)) {
                    $imagePath = $uploadDir . $fileName;
                }
            }

            $this->tourLogModel->updateLog($id, $note, $imagePath, $incident);

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
