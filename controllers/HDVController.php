<?php
// controllers/HDVController.php
require_once './models/HDVModel.php';

class HDVController
{
    // Hiển thị trang login
    public function login()
    {
        require_once './views/hdv/login.php';
    }

    // Xử lý login
    public function checkLogin()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ?act=hdv-login");
            exit;
        }

        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($email === '' || $password === '') {
            $_SESSION['hdv_error'] = "Vui lòng nhập email và mật khẩu.";
            header("Location: ?act=hdv-login");
            exit;
        }

        $emp = getEmployeeByEmail($email);

        if (!$emp) {
            $_SESSION['hdv_error'] = "Tài khoản không tồn tại.";
            header("Location: ?act=hdv-login");
            exit;
        }

        // Kiểm tra mật khẩu plain text
        if ($emp['Password'] === $password) {
            $_SESSION['hdv_id'] = $emp['EmployeeID'];
            $_SESSION['hdv_name'] = $emp['FullName'];
            header("Location: ?act=hdv-dashboard");
            exit;
        }

        // Nếu dùng mật khẩu hash (bcrypt)
        if (password_verify($password, $emp['Password'])) {
            $_SESSION['hdv_id'] = $emp['EmployeeID'];
            $_SESSION['hdv_name'] = $emp['FullName'];
            header("Location: ?act=hdv-dashboard");
            exit;
        }

        $_SESSION['hdv_error'] = "Sai mật khẩu.";
        header("Location: ?act=hdv-login");
        exit;
    }

    // Logout
    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: ?act=hdv-login");
        exit;
    }

    // Dashboard HDV → Chuyển hướng đến danh sách tour
    public function dashboard()
    {
        header("Location: ?act=hdv-tour");
        exit;
    }

    // Danh sách tour được phân công
    public function tourList()
    {
        session_start();
        if (empty($_SESSION['hdv_id'])) {
            header("Location: ?act=hdv-login");
            exit;
        }

        $employeeId = $_SESSION['hdv_id'];
        $tours = getAssignedTours($employeeId);

        require_once './views/hdv/tour_list.php';
    }

    // Chi tiết tour
    public function tourDetail()
    {
        session_start();
        if (empty($_SESSION['hdv_id'])) {
            header("Location: ?act=hdv-login");
            exit;
        }

        $tourId = $_GET['id'] ?? null;

        if (!$tourId) {
            header("Location: ?act=hdv-tour");
            exit;
        }

        $tour = getTourDetailById($tourId);
        if (!$tour) {
            $_SESSION['hdv_error'] = "Tour không tồn tại.";
            header("Location: ?act=hdv-tour");
            exit;
        }

        $customers = getCustomersInTour($tourId);
        $logs = getTourLogs($tourId);

        require_once './views/hdv/tour_detail.php';
    }
}
