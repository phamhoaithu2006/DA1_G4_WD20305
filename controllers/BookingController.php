<?php
<<<<<<< HEAD
class BookingController
{
=======
class BookingController {
>>>>>>> 3ffeda95b17b161d1c7f83d77992cd563572f79d
    private $bookingModel;
    private $tourModel; // optional for getting list of tours
    private $customerModel; // optional if separated
    private $db;

<<<<<<< HEAD
    public function __construct($db)
    {
=======
    public function __construct($db) {
>>>>>>> 3ffeda95b17b161d1c7f83d77992cd563572f79d
        $this->db = $db;
        $this->bookingModel = new BookingModel($db);
        // nếu có model Tour/Customer, khởi tạo tương tự
        // $this->tourModel = new TourModel($db);
    }

    // Hiển thị danh sách booking
<<<<<<< HEAD
    public function index()
    {
=======
    public function index() {
>>>>>>> 3ffeda95b17b161d1c7f83d77992cd563572f79d
        $bookings = $this->bookingModel->getAllBookings();
        require 'views/admin/Booking/index.php';
    }

    // Form tạo booking (GET) và xử lý tạo (POST)
<<<<<<< HEAD
    public function create()
    {
=======
    public function create() {
>>>>>>> 3ffeda95b17b161d1c7f83d77992cd563572f79d
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Lấy đầu vào
                $isExistingCustomer = !empty($_POST['customer_id']);
                if ($isExistingCustomer) {
                    $customerId = intval($_POST['customer_id']);
                } else {
                    // tạo customer mới
                    $custData = [
                        'FullName' => trim($_POST['fullname']),
                        'Email' => trim($_POST['email'] ?? ''),
                        'Phone' => trim($_POST['phone'] ?? ''),
                        'Address' => trim($_POST['address'] ?? '')
                    ];
<<<<<<< HEAD
                    // Validation tối thiểu
=======
                    // validation tối thiểu
>>>>>>> 3ffeda95b17b161d1c7f83d77992cd563572f79d
                    if (empty($custData['FullName'])) throw new Exception('Chưa nhập tên khách.');
                    $customerId = $this->bookingModel->createCustomer($custData);
                }

                $tourId = intval($_POST['tour_id']);
                $numPeople = intval($_POST['num_people'] ?? 1);
                // Lấy giá tour (nếu muốn tự tính TotalAmount)
                $stmt = $this->db->prepare("SELECT Price FROM Tour WHERE TourID = :id");
                $stmt->execute([':id' => $tourId]);
                $tour = $stmt->fetch(PDO::FETCH_ASSOC);
                $price = $tour ? floatval($tour['Price']) : 0.0;

<<<<<<< HEAD
                $totalAmount = $price * max(1, $numPeople);
=======
                $totalAmount = $price * max(1,$numPeople);
>>>>>>> 3ffeda95b17b161d1c7f83d77992cd563572f79d

                // Chuẩn bị bookingData
                $bookingData = [
                    'CustomerID' => $customerId,
                    'TourID' => $tourId,
                    'BookingDate' => date('Y-m-d H:i:s'),
                    'Status' => 'Đang xử lý',
                    'TotalAmount' => $totalAmount
                ];

                // Nếu là đoàn: có thể có danh sách khách khác (ví dụ từ form JSON hoặc nhiều input)
                $tourCustomers = [];
                if (!empty($_POST['group_members'])) {
                    // Giả sử group_members gửi lên là JSON array [{FullName, Phone, Email, RoomNumber, Note}, ...]
                    $members = json_decode($_POST['group_members'], true);
                    foreach ($members as $m) {
                        // Tạo customer cho từng thành viên (hoặc nếu chỉ lưu thông tin tạm, có thể reuse)
                        $memberCustId = $this->bookingModel->createCustomer([
                            'FullName' => $m['FullName'],
                            'Email' => $m['Email'] ?? null,
                            'Phone' => $m['Phone'] ?? null,
                            'Address' => $m['Address'] ?? null
                        ]);
                        $tourCustomers[] = [
                            'CustomerID' => $memberCustId,
                            'RoomNumber' => $m['RoomNumber'] ?? null,
                            'Note' => $m['Note'] ?? null
                        ];
                    }
                }

                $bookingId = $this->bookingModel->createBooking($bookingData, $tourCustomers);

                // Redirect hoặc hiển thị thành công
                header("Location: " . BASE_URL . "?act=booking-detail&id=" . $bookingId);
                exit;
            } catch (Exception $e) {
                $error = $e->getMessage();
<<<<<<< HEAD
                // Load lại view create với $error
=======
                // load lại view create với $error
>>>>>>> 3ffeda95b17b161d1c7f83d77992cd563572f79d
                require 'views/admin/Booking/create.php';
            }
        } else {
            // GET: show form, cần list Tour để select
            $tours = $this->db->query("SELECT TourID, TourName, Price FROM Tour")->fetchAll(PDO::FETCH_ASSOC);
            require 'views/admin/Booking/create.php';
        }
    }

    // Xem chi tiết booking
<<<<<<< HEAD
    public function detail()
    {
=======
    public function detail() {
>>>>>>> 3ffeda95b17b161d1c7f83d77992cd563572f79d
        $id = intval($_GET['id'] ?? 0);
        $booking = $this->bookingModel->getBookingById($id);
        // Lấy khách đoàn (nếu muốn)
        $tourCustomers = $this->bookingModel->getTourCustomers($booking['TourID'] ?? 0);
        require 'views/admin/Booking/detail.php';
    }

    // Cập nhật trạng thái (POST)
<<<<<<< HEAD
    public function updateStatus()
    {
=======
    public function updateStatus() {
>>>>>>> 3ffeda95b17b161d1c7f83d77992cd563572f79d
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo "Method not allowed";
            exit;
        }
        $id = intval($_POST['booking_id']);
        $status = trim($_POST['status']);
        try {
            $this->bookingModel->updateStatus($id, $status);
            header("Location: /Booking/detail.php?id=" . $id);
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
<<<<<<< HEAD
            // Handle error: show detail with error
=======
            // handle error: show detail with error
>>>>>>> 3ffeda95b17b161d1c7f83d77992cd563572f79d
            $booking = $this->bookingModel->getBookingById($id);
            require 'views/admin/Booking/detail.php';
        }
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 3ffeda95b17b161d1c7f83d77992cd563572f79d
