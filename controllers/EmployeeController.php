<?php
require_once 'models/EmployeeModel.php';
require_once 'models/ProductModel.php'; 

class EmployeeController {
    private $employeeModel;
    private $tourModel; 

    public function __construct() {
        $this->employeeModel = new EmployeeModel();
        $this->tourModel = new ProductModel(); 
    }

    

    public function detail($id) {
        $employee = $this->employeeModel->getEmployeeByID($id);
        $assignedTours = $this->employeeModel->getToursByEmployee($id);
        require 'views/admin/Operate/employee/detail.php';
    }

    // --- Hàm hỗ trợ Upload Ảnh ---
    private function uploadAvatar($file) {
        if (isset($file) && $file['error'] == 0) {
            $targetDir = "uploads/avatars/";
            // Tạo thư mục nếu chưa có
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            
            $fileName = time() . "_" . basename($file["name"]);
            $targetFilePath = $targetDir . $fileName;
            
            // Kiểm tra định dạng ảnh
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            $allowTypes = array('jpg','png','jpeg','gif');
            if(in_array(strtolower($fileType), $allowTypes)){
                if(move_uploaded_file($file["tmp_name"], $targetFilePath)){
                    return $targetFilePath; // Trả về đường dẫn ảnh
                }
            }
        }
        return null; // Không có ảnh hoặc lỗi
    }

    public function create() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xử lý upload ảnh
            $avatarPath = $this->uploadAvatar($_FILES['avatar'] ?? null);

            // Gom dữ liệu
            $data = [
                'name' => $_POST['name'],
                'role' => $_POST['role'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
                'dob' => $_POST['dob'] ?? null,
                'avatar' => $avatarPath,
                'certs' => $_POST['certs'] ?? '',
                'langs' => $_POST['langs'] ?? '',
                'exp' => $_POST['exp'] ?? 0,
                'type' => $_POST['type'] ?? 'Nội địa',
                'health' => $_POST['health'] ?? ''
            ];

            $this->employeeModel->addEmployee($data);
            header('Location: index.php?act=employees');
            exit;
        } else {
            $employee = null;
            require 'views/admin/Operate/employee/create.php';
        }
    }

    public function edit($id) {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xử lý upload ảnh
            $avatarPath = $this->uploadAvatar($_FILES['avatar'] ?? null);

            $data = [
                'name' => $_POST['name'],
                'role' => $_POST['role'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
                'dob' => $_POST['dob'] ?? null,
                'avatar' => $avatarPath, // Nếu null (không up ảnh mới) thì Model sẽ giữ ảnh cũ
                'certs' => $_POST['certs'] ?? '',
                'langs' => $_POST['langs'] ?? '',
                'exp' => $_POST['exp'] ?? 0,
                'type' => $_POST['type'] ?? 'Nội địa',
                'health' => $_POST['health'] ?? ''
            ];

            $this->employeeModel->updateEmployee($id, $data);
            header('Location: index.php?act=employees');
            exit;
        } else {
            $employee = $this->employeeModel->getEmployeeByID($id);
            require 'views/admin/Operate/employee/edit.php';
        }
    }

    public function delete($id) {
        $this->employeeModel->deleteEmployee($id);
        header('Location: index.php?act=employees');
        exit;
    }

    public function index() {
        $employees = $this->employeeModel->getAllEmployees();
        
        // [SỬA] Thay vì lấy getAllTour(), ta dùng hàm mới getActiveTours()
        // Chỉ lấy những tour chưa hoàn thành để hiện trong modal
        $tours = $this->tourModel->getActiveTours(); 

        require 'views/admin/Operate/employee/list.php'; 
    }

    // ...

    public function assignTour() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $empId = $_POST['employee_id'];
            $tourId = $_POST['tour_id'];
            
            // [MỚI] VALIDATION: Kiểm tra xem tour này đã hoàn thành chưa
            $tourDate = $this->tourModel->getTourDates($tourId);
            
            if (!$tourDate) {
                echo "<script>alert('Tour không tồn tại!'); window.location.href='?act=employees';</script>";
                return;
            }

            // So sánh ngày hiện tại với ngày kết thúc tour
            $today = date('Y-m-d');
            if ($today > $tourDate['EndDate']) {
                echo "<script>alert('LỖI: Tour này đã hoàn thành. Không thể phân công thêm nhân sự!'); window.location.href='?act=employees';</script>";
                return;
            }

            // Nếu hợp lệ thì gọi Model phân công
            $result = $this->employeeModel->assignTourToEmployee($empId, $tourId);
            
            // Kiểm tra kết quả trả về từ Model
            if ($result === false) {
                echo "<script>alert('Nhân viên này đã có trong tour rồi!'); window.location.href='?act=employees';</script>";
            } else {
                echo "<script>alert('Phân công thành công!'); window.location.href='?act=employees';</script>";
            }
        }
    }
}
?>