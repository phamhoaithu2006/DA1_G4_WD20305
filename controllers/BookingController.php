<?php
// Điểm danh bên tour bên hdv
// Nạp thêm thông tin
// Thêm Lịch trình chi tiết bên Quản lý tour
//Lịch trình chi tiết qua từng tour
//lỗi trùng lặp khách hàng
//Quản lý nhân sự tour đã hoàn thành, đang hoàn thành, sắp hoàn thành
//danh sách tour nạp thêm dữ liệu phần mô tả
//Sử lý booking theo người 1<
//Làm phần login
class BookingController
{
    private $bookingModel;
    private $tourModel; // optional for getting list of tours
    private $customerModel; // optional if separated
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        $this->bookingModel = new BookingModel($db);
        // nếu có model Tour/Customer, khởi tạo tương tự
        // $this->tourModel = new TourModel($db);
    }

    // Hiển thị danh sách booking
    public function index()
    {
        $bookings = $this->bookingModel->getAllBookings();
        require 'views/admin/Booking/index.php';
    }

    // Form tạo booking (GET) và xử lý tạo (POST)
   public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $tourId = intval($_POST['tour_id']);
                $numPeople = intval($_POST['num_people'] ?? 1);

                // 1. Lấy thông tin Tour để kiểm tra
                // [MỚI] Thêm lấy StartDate để kiểm tra hạn
                $stmt = $this->db->prepare("SELECT TourName, Price, MaxSlots, StartDate FROM Tour WHERE TourID = :id");
                $stmt->execute([':id' => $tourId]);
                $tour = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$tour) {
                    throw new Exception('Tour không tồn tại.');
                }

                // 2. [MỚI] KIỂM TRA HẠN ĐẶT TOUR (BACKEND VALIDATION)
                $today = date('Y-m-d');
                if ($tour['StartDate'] < $today) {
                    throw new Exception("Tour '{$tour['TourName']}' đã khởi hành ngày " . date('d/m/Y', strtotime($tour['StartDate'])) . ". Không thể đặt chỗ.");
                }

                // 3. KIỂM TRA CHỖ TRỐNG
                $availability = $this->bookingModel->checkAvailability($tourId, $numPeople);
                if (!$availability['status']) {
                    throw new Exception($availability['message']);
                }

                // 4. Xử lý thông tin người đặt
                $isExistingCustomer = !empty($_POST['customer_id']);
                if ($isExistingCustomer) {
                    $customerId = intval($_POST['customer_id']);
                } else {
                    $custData = [
                        'FullName' => trim($_POST['fullname']),
                        'Email'    => trim($_POST['email'] ?? ''),
                        'Phone'    => trim($_POST['phone'] ?? ''),
                        'Address'  => trim($_POST['address'] ?? '')
                    ];
                    if (empty($custData['FullName'])) throw new Exception('Chưa nhập tên người đại diện.');
                    $customerId = $this->bookingModel->createCustomer($custData);
                }

                // 5. Tính tiền
                $price = floatval($tour['Price']);
                $totalAmount = $price * $numPeople;

                // 6. Chuẩn bị dữ liệu Booking
                $bookingData = [
                    'CustomerID' => $customerId,
                    'TourID' => $tourId,
                    'BookingDate' => date('Y-m-d H:i:s'),
                    'Status' => 'Đang xử lý',
                    'TotalAmount' => $totalAmount
                ];

                // 7. Xử lý danh sách đoàn
                $tourCustomers = [];
                $tourCustomers[] = [
                    'CustomerID' => $customerId,
                    'RoomNumber' => 'Chưa xếp',
                    'Note' => 'Trưởng đoàn'
                ];

                if (!empty($_POST['group_members_json'])) {
                    $members = json_decode($_POST['group_members_json'], true);
                    if (is_array($members)) {
                        foreach ($members as $m) {
                            $memCustId = $this->bookingModel->createCustomer([
                                'FullName' => $m['name'],
                                'Phone'    => $m['phone'] ?? '',
                                'Email'    => '',
                                'Address'  => ''
                            ]);
                            
                            $tourCustomers[] = [
                                'CustomerID' => $memCustId,
                                'RoomNumber' => 'Chưa xếp',
                                'Note'       => $m['note'] ?? ''
                            ];
                        }
                    }
                }

                $bookingId = $this->bookingModel->createBooking($bookingData, $tourCustomers);

                header("Location: " . BASE_URL . "?act=booking-detail&id=" . $bookingId);
                exit;

            } catch (Exception $e) {
                $error = $e->getMessage();
                
                // [MỚI] Load lại danh sách tour (Chỉ lấy tour chưa khởi hành)
                $sql = "SELECT TourID, TourName, Price, MaxSlots 
                        FROM Tour 
                        WHERE StartDate >= CURRENT_DATE 
                        ORDER BY StartDate ASC";
                $tours = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
                
                require 'views/admin/Booking/create.php';
            }
        } else {
            // GET: Hiển thị form
            // [MỚI] CHỈ LẤY CÁC TOUR CÓ NGÀY KHỞI HÀNH >= HÔM NAY
            $sql = "SELECT TourID, TourName, Price, MaxSlots 
                    FROM Tour 
                    WHERE StartDate >= CURRENT_DATE 
                    ORDER BY StartDate ASC";
                    
            $tours = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            
            // Xử lý biến $selectedTour để tránh lỗi Undefined
            $selectedTour = $_GET['tour_id'] ?? '';
            
            require 'views/admin/Booking/create.php';
        }
    }
    // Xem chi tiết booking
    public function detail()
    {
        $id = intval($_GET['id'] ?? 0);
        $booking = $this->bookingModel->getBookingById($id);
        // Lấy khách đoàn (nếu muốn)
        $tourCustomers = $this->bookingModel->getTourCustomers($booking['TourID'] ?? 0);
        require 'views/admin/Booking/detail.php';
    }

    // Cập nhật trạng thái (POST)
    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo "Method not allowed";
            exit;
        }
        $id = intval($_POST['booking_id']);
        $status = trim($_POST['status']);
        try {
            $this->bookingModel->updateStatus($id, $status);
            //Về trang booking detail sau khi cập nhật
            header("Location:" . BASE_URL . "?act=booking-list");
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
            // Handle error: show detail with error
            $booking = $this->bookingModel->getBookingById($id);
            require 'views/admin/Booking/detail.php';
        }
    }
}