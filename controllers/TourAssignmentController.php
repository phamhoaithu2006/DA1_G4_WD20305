<?php
require_once 'models/TourAssignmentModel.php';
require_once 'models/EmployeeModel.php';

class TourAssignmentController
{
    private $model;
    private $employeeModel;

    public function __construct()
    {
        $this->model = new TourAssignmentModel();
        $this->employeeModel = new EmployeeModel();
    }

    // Hiển thị danh sách phân công
    public function index($tourID)
    {
        $tourID = intval($tourID);

        if ($tourID <= 0) {
            die("tourID không hợp lệ.");
        }

        $assignments = $this->model->getAssignmentsByTour($tourID);

        // Truyền tourID sang view
        require 'views/admin/Operate/assignments/list.php';
    }

    // Thêm phân công
    public function create($tourID)
    {
        $tourID = intval($tourID);
        if ($tourID <= 0) {
            die("tourID không hợp lệ.");
        }

        // Lấy toàn bộ nhân sự
        $allEmployees = $this->employeeModel->getAllEmployees();

        // Submit form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $employeeID = $_POST['employeeID'] ?? null;
            $role       = $_POST['role'] ?? null;

            if ($employeeID && $role) {
                $this->model->addAssignment($tourID, $employeeID, $role);
            }

            header("Location: " . BASE_URL . "?act=assignments&tourID=$tourID");
            exit;
        }

        require 'views/admin/Operate/assignments/create.php';
    }

    // Xóa phân công
    public function delete($id, $tourID)
    {
        $id = intval($id);
        $tourID = intval($tourID);

        if ($id > 0) {
            $this->model->deleteAssignment($id);
        }

        header("Location: " . BASE_URL . "?act=assignments&tourID=$tourID");
        exit;
    }
}
