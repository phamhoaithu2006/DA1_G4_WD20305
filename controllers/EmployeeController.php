<?php
require_once 'models/EmployeeModel.php';
require_once 'models/ProductModel.php'; // <--- THÊM DÒNG NÀY

class EmployeeController {
    private $employeeModel;
    private $tourModel; // <--- THÊM BIẾN NÀY

    public function __construct() {
        $this->employeeModel = new EmployeeModel();
        $this->tourModel = new ProductModel(); // <--- KHỞI TẠO MODEL TOUR
    }

    public function index() {
        $employees = $this->employeeModel->getAllEmployees();
        
        // --- MỚI: Lấy danh sách tour để truyền vào Modal phân công ---
        $tours = $this->tourModel->getAllTour(); 

        require 'views/admin/Operate/employee/list.php'; 
    }

    public function detail($id) {
        // Lấy thông tin nhân viên
        $employee = $this->employeeModel->getEmployeeByID($id);
        
        // --- MỚI: Lấy danh sách tour đã nhận ---
        $assignedTours = $this->employeeModel->getToursByEmployee($id);
        
        require 'views/admin/Operate/employee/detail.php';
    }

    public function create() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->employeeModel->addEmployee($_POST['name'], $_POST['role'], $_POST['phone'], $_POST['email']);
            header('Location: index.php?act=employees');
            exit;
        } else {
            $employee = null;
            // SỬA: 'employees' -> 'employee'
            require 'views/admin/Operate/employee/edit.php';
        }
    }

    public function edit($id) {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->employeeModel->updateEmployee($id, $_POST['name'], $_POST['role'], $_POST['phone'], $_POST['email']);
            header('Location: index.php?act=employees');
            exit;
        } else {
            $employee = $this->employeeModel->getEmployeeByID($id);
            // SỬA: 'employees' -> 'employee'
            require 'views/admin/Operate/employee/edit.php';
        }
    }

    public function delete($id) {
        $this->employeeModel->deleteEmployee($id);
        header('Location: index.php?act=employees');
        exit;
    }

    // ... (Các hàm detail, create, edit, delete giữ nguyên) ...

    // --- MỚI: Hàm xử lý phân công tour ---
    public function assignTour() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $empId = $_POST['employee_id'];
            $tourId = $_POST['tour_id'];
            
            // Gọi hàm trong Model để lưu
            $this->employeeModel->assignTourToEmployee($empId, $tourId);
            
            // Quay lại danh sách
            header('Location: index.php?act=employees');
            exit;
        }
    }
    
    
}