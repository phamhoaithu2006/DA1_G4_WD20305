<?php
require_once 'models/EmployeeModel.php';

class EmployeeController {
    private $employeeModel;

    public function __construct() {
        $this->employeeModel = new EmployeeModel();
    }

    public function index() {
        $employees = $this->employeeModel->getAllEmployees();
        
        require 'views/admin/Operate/employee/list.php';
    }

    public function detail($id) {
        $employee = $this->employeeModel->getEmployeeByID($id);
        require 'views/admin/Operate/employee/detail.php';
    }

    public function create() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->employeeModel->addEmployee($_POST['name'], $_POST['role'], $_POST['phone'], $_POST['email']);
            header('Location: index.php?action=employees');
        } else {
            require 'views/admin/Operate/employee/create.php';
        }
    }

    public function edit($id) {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->employeeModel->updateEmployee($id, $_POST['name'], $_POST['role'], $_POST['phone'], $_POST['email']);
            header('Location: index.php?action=employees');
        } else {
            $employee = $this->employeeModel->getEmployeeByID($id);
            require 'views/admin/Operate/employee/edit.php';
        }
    }

    public function delete($id) {
        $this->employeeModel->deleteEmployee($id);
        header('Location: index.php?action=employees');
    }
}