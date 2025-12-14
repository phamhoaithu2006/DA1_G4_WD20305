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
        $passwordOk = false;
        if ($emp['Password'] === $password) {
            $passwordOk = true;
        } elseif (password_verify($password, $emp['Password'])) {
            $passwordOk = true;
        }

        if ($passwordOk) {
            // Nếu nhân viên có Role = 'admin' -> gán session admin
            $role = isset($emp['Role']) ? strtolower($emp['Role']) : '';
            if ($role === 'admin') {
                $_SESSION['user_role'] = 'admin';
                $_SESSION['user_id'] = $emp['EmployeeID'];
                $_SESSION['user_name'] = $emp['FullName'];
                header("Location: ?act=dashboard");
                exit;
            }

            // Mặc định là HDV
            $_SESSION['hdv_id'] = $emp['EmployeeID'];
            $_SESSION['hdv_name'] = $emp['FullName'];
            $_SESSION['user_role'] = 'hdv';
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

    // Dashboard HDV: chuyển hướng đến danh sách tour
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

    // Hiển thị form nhật ký (thêm mới hoặc chỉnh sửa)
    public function diaryForm()
    {
        session_start();
        if (empty($_SESSION['hdv_id'])) {
            header("Location: ?act=hdv-login");
            exit;
        }

        $tourId = $_GET['id'] ?? null;
        $logId = $_GET['log_id'] ?? null;

        if (!$tourId) {
            header("Location: ?act=hdv-tour");
            exit;
        }
        $tour = getTourDetailById($tourId);
        $existingLog = null;
        if ($logId) {
            $existingLog = getTourLogById($logId);
            if (!$existingLog || $existingLog['TourID'] != $tourId) {
                $_SESSION['hdv_error'] = "Nhật ký không tồn tại.";
                header("Location: ?act=hdv-tour-detail&id=" . $tourId);
                exit;
            }
        }

        // Truyền biến vào view (các biến local sẽ có sẵn trong file require)
        $log = $existingLog; // để view có thể sử dụng
        require_once './views/hdv/diary_form.php';
    }

    // Lưu nhật ký tour
    public function diarySave()
    {
        session_start();
        if (empty($_SESSION['hdv_id'])) {
            header("Location: ?act=hdv-login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ?act=hdv-tour");
            exit;
        }

        $tourId = $_GET['id'] ?? null;
        $logId = $_GET['log_id'] ?? null;

        if (!$tourId) {
            header("Location: ?act=hdv-tour");
            exit;
        }

        $note = trim($_POST['note'] ?? '');
        $incident = trim($_POST['incident'] ?? '');

        if (empty($note)) {
            $_SESSION['hdv_error'] = "Vui lòng nhập ghi chú.";
            header("Location: ?act=hdv-diary-form&id=" . $tourId . ($logId ? "&log_id=" . $logId : ""));
            exit;
        }

        // Xử lý upload hình ảnh
        $images = [];
        if (!empty($_FILES['images']['name'][0])) {
            $uploadDir = './uploads/tour_logs/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
                if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                    $fileName = time() . '_' . basename($_FILES['images']['name'][$key]);
                    $targetPath = $uploadDir . $fileName;
                    if (move_uploaded_file($tmpName, $targetPath)) {
                        $images[] = BASE_URL . 'uploads/tour_logs/' . $fileName;
                    }
                }
            }
        }

        // Nếu đang chỉnh sửa, giữ lại hình ảnh cũ nếu không upload mới
        if ($logId && empty($images)) {
            $existingLog = getTourLogById($logId);
            if ($existingLog && !empty($existingLog['Images'])) {
                $images = json_decode($existingLog['Images'], true) ?? [];
            }
        }

        $data = [
            'TourID' => $tourId,
            'EmployeeID' => $_SESSION['hdv_id'],
            'Note' => $note,
            'Incident' => $incident ?: null,
            'Images' => !empty($images) ? json_encode($images) : null
        ];

        if ($logId) {
            $data['LogID'] = $logId;
        }

        if (saveTourLog($data)) {
            $_SESSION['hdv_success'] = $logId ? "Cập nhật nhật ký thành công!" : "Thêm nhật ký thành công!";
        } else {
            $_SESSION['hdv_error'] = "Có lỗi xảy ra khi lưu nhật ký.";
        }

        header("Location: ?act=hdv-tour-detail&id=" . $tourId);
        exit;
    }

    // Xóa nhật ký tour
    public function diaryDelete()
    {
        session_start();
        if (empty($_SESSION['hdv_id'])) {
            header("Location: ?act=hdv-login");
            exit;
        }

        $tourId = $_GET['id'] ?? null;
        $logId = $_GET['log_id'] ?? null;

        if (!$tourId || !$logId) {
            $_SESSION['hdv_error'] = "Thông tin không hợp lệ.";
            header("Location: ?act=hdv-tour");
            exit;
        }

        // Kiểm tra log có thuộc tour này không
        $log = getTourLogById($logId);
        if (!$log || $log['TourID'] != $tourId) {
            $_SESSION['hdv_error'] = "Nhật ký không tồn tại hoặc không thuộc tour này.";
            header("Location: ?act=hdv-tour-detail&id=" . $tourId);
            exit;
        }

        if (deleteTourLog($logId)) {
            $_SESSION['hdv_success'] = "Xóa nhật ký thành công!";
        } else {
            $_SESSION['hdv_error'] = "Có lỗi xảy ra khi xóa nhật ký.";
        }

        header("Location: ?act=hdv-tour-detail&id=" . $tourId);
        exit;
    }

    // Trang check-in/check-out
    public function checkInOut()
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

        $checkinHistory = getCheckInOutHistory($tourId);
        require_once './views/hdv/checkin_checkout.php';
    }

    // Lưu check-in
    public function checkInSave()
    {
        session_start();
        if (empty($_SESSION['hdv_id'])) {
            header("Location: ?act=hdv-login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ?act=hdv-tour");
            exit;
        }

        $tourId = $_GET['id'] ?? null;
        if (!$tourId) {
            header("Location: ?act=hdv-tour");
            exit;
        }

        $location = trim($_POST['checkin_location'] ?? '');
        $note = trim($_POST['checkin_note'] ?? '');

        if (empty($location)) {
            $_SESSION['hdv_error'] = "Vui lòng nhập địa điểm.";
            header("Location: ?act=hdv-checkin-checkout&id=" . $tourId);
            exit;
        }

        $data = [
            'TourID' => $tourId,
            'EmployeeID' => $_SESSION['hdv_id'],
            'Type' => 'checkin',
            'Location' => $location,
            'Note' => $note ?: null
        ];

        if (saveCheckInOut($data)) {
            $_SESSION['hdv_success'] = "Check-in thành công!";
        } else {
            $_SESSION['hdv_error'] = "Có lỗi xảy ra khi lưu check-in. Vui lòng kiểm tra database hoặc liên hệ quản trị viên.";
        }

        header("Location: ?act=hdv-checkin-checkout&id=" . $tourId);
        exit;
    }

    // Lưu check-out
    public function checkOutSave()
    {
        session_start();
        if (empty($_SESSION['hdv_id'])) {
            header("Location: ?act=hdv-login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ?act=hdv-tour");
            exit;
        }

        $tourId = $_GET['id'] ?? null;
        if (!$tourId) {
            header("Location: ?act=hdv-tour");
            exit;
        }

        $location = trim($_POST['checkout_location'] ?? '');
        $note = trim($_POST['checkout_note'] ?? '');

        if (empty($location)) {
            $_SESSION['hdv_error'] = "Vui lòng nhập địa điểm.";
            header("Location: ?act=hdv-checkin-checkout&id=" . $tourId);
            exit;
        }

        $data = [
            'TourID' => $tourId,
            'EmployeeID' => $_SESSION['hdv_id'],
            'Type' => 'checkout',
            'Location' => $location,
            'Note' => $note ?: null
        ];

        if (saveCheckInOut($data)) {
            $_SESSION['hdv_success'] = "Check-out thành công!";
        } else {
            $_SESSION['hdv_error'] = "Có lỗi xảy ra khi lưu check-out. Vui lòng kiểm tra database hoặc liên hệ quản trị viên.";
        }

        header("Location: ?act=hdv-checkin-checkout&id=" . $tourId);
        exit;
    }

    public function checkInOutDelete()
    {
        session_start();
        if (empty($_SESSION['hdv_id'])) {
            header("Location: ?act=hdv-login");
            exit;
        }

        $tourId = $_GET['id'] ?? null;
        $entryId = $_GET['entry_id'] ?? null;

        if (!$tourId || !$entryId) {
            $_SESSION['hdv_error'] = "Thông tin không hợp lệ.";
            header("Location: ?act=hdv-tour");
            exit;
        }

        $row = getCheckInOutById($entryId);
        if (!$row || $row['TourID'] != $tourId) {
            $_SESSION['hdv_error'] = "Bản ghi không tồn tại hoặc không thuộc tour này.";
            header("Location: ?act=hdv-checkin-checkout&id=" . $tourId);
            exit;
        }

        if (deleteCheckInOutEntry($entryId)) {
            $_SESSION['hdv_success'] = "Đã xóa bản ghi thành công.";
        } else {
            $_SESSION['hdv_error'] = "Có lỗi xảy ra khi xóa.";
        }

        header("Location: ?act=hdv-checkin-checkout&id=" . $tourId);
        exit;
    }

    // Trang yêu cầu đặc biệt
    public function specialRequests()
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

        $customers = getCustomersWithSpecialRequests($tourId);
        require_once './views/hdv/special_requests.php';
    }

    



public function specialRequestSave()
    {
        session_start();
        if (empty($_SESSION['hdv_id'])) {
            header("Location: ?act=hdv-login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ?act=hdv-tour");
            exit;
        }

        $tourId = $_GET['id'] ?? null;
        $customerId = $_POST['customer_id'] ?? null;

        if (!$tourId || !$customerId) {
            $_SESSION['hdv_error'] = "Dữ liệu không hợp lệ.";
            header("Location: ?act=hdv-tour");
            exit;
        }

        // Thu thập dữ liệu từ Form (bao gồm cả Tên, SĐT, Phòng nếu có)
        $data = [
            'TourID' => $tourId,
            'CustomerID' => $customerId,
            'FullName' => trim($_POST['FullName'] ?? ''),
            'Phone' => trim($_POST['Phone'] ?? ''),
            'RoomNumber' => trim($_POST['RoomNumber'] ?? ''),
            'Vegetarian' => isset($_POST['vegetarian']) ? 1 : 0, // Checkbox
            'MedicalCondition' => trim($_POST['medical_condition'] ?? ''),
            'OtherRequests' => trim($_POST['other_requests'] ?? ''),
            'SpecialRequests' => trim($_POST['note'] ?? '') // Ghi chú chung
        ];

        // Gọi hàm Model mới updateCustomerInfoAndRequests
        if (updateCustomerInfoAndRequests($data)) {
            $_SESSION['hdv_success'] = "Cập nhật thông tin khách hàng thành công!";
        } else {
            $_SESSION['hdv_error'] = "Có lỗi xảy ra khi cập nhật.";
        }

        header("Location: ?act=hdv-special-requests&id=" . $tourId);
        exit;
    }

    // Tự động phân phòng: giao quyền phân phòng cho HDV (gán phòng cho khách chưa có phòng)
    public function assignRooms()
    {
        session_start();
        if (empty($_SESSION['hdv_id'])) {
            header("Location: ?act=hdv-login");
            exit;
        }

        $tourId = $_GET['id'] ?? null;
        if (!$tourId) {
            $_SESSION['hdv_error'] = "Thông tin tour không hợp lệ.";
            header("Location: ?act=hdv-tour");
            exit;
        }

        // Gọi model để tự động phân phòng
        $assigned = autoAssignRooms($tourId, $_SESSION['hdv_id']);

        if ($assigned > 0) {
            $_SESSION['hdv_success'] = "Đã phân phòng cho $assigned khách thành công.";
        } else {
            $_SESSION['hdv_success'] = "Không có khách cần phân phòng hoặc đã được phân trước đó.";
        }

        header("Location: ?act=hdv-tour-detail&id=" . $tourId);
        exit;
    }

    // Điểm danh khách: đánh dấu đã điểm danh
    public function customerCheckInSave()
    {
        session_start();
        if (empty($_SESSION['hdv_id'])) {
            header("Location: ?act=hdv-login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ?act=hdv-tour");
            exit;
        }

        $tourId = $_GET['id'] ?? null;
        $customerId = $_POST['customer_id'] ?? null;

        if (!$tourId || !$customerId) {
            $_SESSION['hdv_error'] = "Thông tin không hợp lệ.";
            header("Location: ?act=hdv-tour");
            exit;
        }

        $ok = setCustomerAttendance($tourId, $customerId, $_SESSION['hdv_id'], 1);
        if ($ok) {
            $_SESSION['hdv_success'] = "Đã điểm danh khách thành công.";
        } else {
            $_SESSION['hdv_error'] = "Có lỗi xảy ra khi điểm danh. Vui lòng thử lại.";
        }

        header("Location: ?act=hdv-tour-detail&id=" . $tourId);
        exit;
    }

    // Bỏ điểm danh khách: đánh dấu chưa điểm danh
    public function customerCheckOutSave()
    {
        session_start();
        if (empty($_SESSION['hdv_id'])) {
            header("Location: ?act=hdv-login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ?act=hdv-tour");
            exit;
        }

        $tourId = $_GET['id'] ?? null;
        $customerId = $_POST['customer_id'] ?? null;

        if (!$tourId || !$customerId) {
            $_SESSION['hdv_error'] = "Thông tin không hợp lệ.";
            header("Location: ?act=hdv-tour");
            exit;
        }

        $ok = setCustomerAttendance($tourId, $customerId, $_SESSION['hdv_id'], 0);
        if ($ok) {
            $_SESSION['hdv_success'] = "Đã bỏ điểm danh khách.";
        } else {
            $_SESSION['hdv_error'] = "Có lỗi xảy ra khi cập nhật điểm danh.";
        }

        header("Location: ?act=hdv-tour-detail&id=" . $tourId);
        exit;
    }
}
