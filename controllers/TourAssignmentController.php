<?php
require_once 'models/TourAssignmentModel.php';
require_once 'models/EmployeeModel.php';
require_once 'models/ProductModel.php'; 

class TourAssignmentController
{
    private $model;

    public function __construct()
    {
        $this->model = new TourAssignmentModel();
    }

    // --- CÁC CHỨC NĂNG XEM THÔNG TIN CƠ BẢN ---

    // 1. Hiển thị danh sách lịch trình tour
    public function index()
    {
        $tourModel = new ProductModel(); 
        $tours = $tourModel->getAllTour();
        require 'views/admin/Operate/assignments/list.php';
    }

    // 2. Thông tin chi tiết Tour (View cũ)
    public function detail($id)
    {
        $tr = new ProductModel();
        $tour = $tr->getOneDetail($id);
        $title = "Chi tiết Tour"; 
        require_once 'views/admin/Operate/assignments/detail.php';
    }

    // 3. Thông tin đoàn theo HDV
    public function getAllHDV()
    {
        $data = $this->model->getAllHDV(); 
        require 'views/admin/Operate/assignments/HDV.php';
    }

    // 4. Thông tin danh sách khách hàng của Tour
    public function showCustomersByTour($tourId)
    {
        $tour = $this->model->getOneDetail($tourId);
        $customers = $this->model->getCustomersByTour($tourId);
        require 'views/admin/Operate/tourcustomers/list.php';
    }

    // --- CÁC CHỨC NĂNG ĐIỀU HÀNH & DỊCH VỤ (MỚI) ---

    // 5. Hiển thị Dashboard Điều hành (Gồm Lịch trình & Booking Dịch vụ)
   // 1. Cập nhật hàm operate() để lấy dữ liệu khách
 public function operate($tourId) {
        $tour = $this->model->getOneDetail($tourId);
        $services = $this->model->getServicesByTour($tourId); 
        
        // Itinerary logic...
        $itineraries = $this->model->getItineraryByTour($tourId);
        $groupedItinerary = [];
        foreach ($itineraries as $item) {
            $groupedItinerary[$item['DayNumber']][] = $item;
        }

        // Customers logic...
        $customers = $this->model->getTourCustomers($tourId);
        $bookings = $this->model->getBookingsByTour($tourId); 

        // --- MỚI: Lấy danh sách nhà cung cấp ---
        $suppliers = $this->model->getAllSuppliers(); 
        // ---------------------------------------
$assignedStaffs = $this->model->getStaffByTour($tourId);
        require 'views/admin/Operate/assignments/operate_dashboard.php';
    }

    // 6. Xử lý thêm mới Booking/Dịch vụ (POST)
    public function addService() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'tourId' => $_POST['tour_id'],
                'supId'  => !empty($_POST['supplier_id']) ? $_POST['supplier_id'] : null,
                'type'   => $_POST['service_type'],
                'note'   => $_POST['note'],
                'qty'    => $_POST['quantity'],
                'price'  => $_POST['price']
            ];
            
            // Gọi Model thêm mới
            $this->model->addService($data); 
            
            // Quay lại trang điều hành của tour đó
            header("Location: ?act=operate-tour&id=" . $_POST['tour_id']);
            exit;
        }
    }

    // 7. Xử lý cập nhật trạng thái & Gửi mail tự động (POST)
    public function changeStatusService() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $serviceId = $_POST['service_id'];
            $newStatus = $_POST['status']; // 1: Gửi yêu cầu, 2: Xác nhận
            $tourId    = $_POST['tour_id']; // Lấy ID tour để redirect về đúng chỗ
            
            // A. Cập nhật Database
            $this->model->updateServiceStatus($serviceId, $newStatus);

            // B. LOGIC TỰ ĐỘNG GỬI THÔNG BÁO
            if ($newStatus == 1) { // Nếu trạng thái là "Đã gửi yêu cầu"
                // Lấy thông tin chi tiết dịch vụ để gửi mail
                $serviceInfo = $this->model->getServiceDetail($serviceId);
                if ($serviceInfo) {
                    $this->sendEmailToSupplier($serviceInfo);
                }
            }

            // Quay lại trang điều hành
            header("Location: ?act=operate-tour&id=" . $tourId);
            exit;
        }
    }

    // 8. Hàm private: Giả lập gửi email
    private function sendEmailToSupplier($info) {
        // Kiểm tra nếu không có email thì bỏ qua
        if (empty($info['SupplierEmail'])) return;

        $to = $info['SupplierEmail'];
        $subject = "Đặt dịch vụ cho tour: " . $info['TourName'];
        
        $message = "Xin chào " . $info['SupplierName'] . ",\n\n";
        $message .= "Chúng tôi muốn đặt dịch vụ: " . $info['ServiceType'] . "\n";
        $message .= "Số lượng: " . $info['Quantity'] . "\n";
        $message .= "Ghi chú: " . $info['Note'] . "\n";
        $message .= "Ngày sử dụng (theo lịch tour): " . $info['StartDate'] . "\n\n";
        $message .= "Vui lòng xác nhận lại với chúng tôi.";

        // Code gửi mail thực tế (ví dụ dùng mail() của PHP hoặc PHPMailer)
        // mail($to, $subject, $message); 
        
        // Ghi log để test (xem trong file log của server hoặc hiển thị tạm)
        // error_log("Đã gửi mail đến: " . $to);
    }
    // 1. Sửa lại hàm operate hiện có
  

    // 2. Hàm thêm lịch trình (Thêm mới vào class)
    public function addItinerary() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'tourId'  => $_POST['tour_id'],
                'day'     => $_POST['day_number'],
                'time'    => $_POST['time_start'],
                'title'   => $_POST['title'],
                'loc'     => $_POST['location'],
                'content' => $_POST['content']
            ];
            
            $this->model->addItinerary($data);
            
            header("Location: ?act=operate-tour&id=" . $_POST['tour_id']);
            exit;
        }
    }

    // 3. Hàm xóa lịch trình (Thêm mới vào class)
    public function deleteItinerary() {
        if (isset($_GET['id']) && isset($_GET['tour_id'])) {
            $this->model->deleteItinerary($_GET['id']);
            header("Location: ?act=operate-tour&id=" . $_GET['tour_id']);
            exit;
        }
    }
    

    // 2. Hàm xử lý thêm khách vào đoàn
    public function addTourCustomer() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Tách CustomerID và BookingID từ value select (Ví dụ: "10-25" => CustID 10, BookingID 25)
            $selected = explode('-', $_POST['booking_customer']); 
            
            $data = [
                'tourId'    => $_POST['tour_id'],
                'custId'    => $selected[0],
                'bookingId' => $selected[1],
                'room'      => $_POST['room_number'],
                'note'      => $_POST['note']
            ];
            
            $this->model->addCustomerToTour($data);
            header("Location: ?act=operate-tour&id=" . $_POST['tour_id']);
            exit;
        }
    }
    
    
}