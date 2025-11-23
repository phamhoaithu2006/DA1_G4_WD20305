<?php
require_once 'models/TourAssignmentModel.php';
require_once 'models/EmployeeModel.php';

<<<<<<< HEAD
class TourAssignmentController
{
    private $model;
    private $employeeModel;

    public function __construct()
    {
=======
class TourAssignmentController {
    private $model;
    private $employeeModel;

    public function __construct() {
>>>>>>> 3ffeda95b17b161d1c7f83d77992cd563572f79d
        $this->model = new TourAssignmentModel();
        $this->employeeModel = new EmployeeModel();
    }

<<<<<<< HEAD
    // Hiển thị danh sách phân công
=======
    // ==========================
    // HIỂN THỊ DANH SÁCH PHÂN CÔNG
    // ==========================
>>>>>>> 3ffeda95b17b161d1c7f83d77992cd563572f79d
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

<<<<<<< HEAD
    // Thêm phân công
=======
    // ==========================
    // THÊM PHÂN CÔNG
    // ==========================
>>>>>>> 3ffeda95b17b161d1c7f83d77992cd563572f79d
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

<<<<<<< HEAD
    // Xóa phân công
=======
    // ==========================
    // XÓA PHÂN CÔNG
    // ==========================
>>>>>>> 3ffeda95b17b161d1c7f83d77992cd563572f79d
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
<<<<<<< HEAD
}
=======
}
>>>>>>> 3ffeda95b17b161d1c7f83d77992cd563572f79d
