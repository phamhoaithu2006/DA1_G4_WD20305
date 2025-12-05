<?php

class TourAssignmentModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }
    //Lịch trình tổng quát
public function getAllHDV() {
   $sql = "SELECT e.FullName, e.Phone, e.Email, t.TourName, t.StartDate, t.EndDate
        FROM employee e
        LEFT JOIN tourassignment ta ON e.EmployeeID = ta.EmployeeID
        LEFT JOIN tour t ON ta.TourID = t.TourID
        ORDER BY t.StartDate ASC";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// Lấy danh sách khách hàng theo TourID
// models/TourAssignmentModel.php
public function getCustomersByTour($tourId)
{// hoặc PDO connection của bạn
    $sql = "SELECT c.CustomerID, c.FullName, c.Email, c.Phone, tc.RoomNumber, tc.Note
            FROM TourCustomer tc
            JOIN Customer c ON tc.CustomerID = c.CustomerID
            WHERE tc.TourID = :tid";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['tid' => $tourId]);
    return $stmt->fetchAll();
}

// models/TourAssignmentModel.php
public function getOneDetail($tourId)
{
    $sql = "SELECT t.*, c.CategoryName, s.SupplierName
            FROM Tour t
            LEFT JOIN Category c ON t.CategoryID = c.CategoryID
            LEFT JOIN Supplier s ON t.SupplierID = s.SupplierID
            WHERE t.TourID = :tid
            LIMIT 1";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['tid' => $tourId]);
    return $stmt->fetch();
}
public function getServicesByTour($tourId) {
        $sql = "SELECT ts.*, s.SupplierName, s.Email as SupplierEmail 
                FROM TourService ts
                LEFT JOIN Supplier s ON ts.SupplierID = s.SupplierID
                WHERE ts.TourID = :tid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tid' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Thêm dịch vụ mới
    public function addService($data) {
        // --- XỬ LÝ QUAN TRỌNG ĐỂ TRÁNH LỖI 1452 ---
        // Kiểm tra: Nếu supId rỗng hoặc bằng 0 thì gán là NULL
        $supId = !empty($data['supId']) ? $data['supId'] : null;

        $sql = "INSERT INTO TourService (TourID, SupplierID, ServiceType, Note, Quantity, Price, Status)
                VALUES (:tourId, :supId, :type, :note, :qty, :price, 0)";
        
        $stmt = $this->conn->prepare($sql);
        
        // Lưu ý: Dùng biến $supId vừa xử lý ở trên, KHÔNG dùng $data['supId']
        return $stmt->execute([
            ':tourId' => $data['tourId'],
            ':supId'  => $supId, 
            ':type'   => $data['type'],
            ':note'   => $data['note'],
            ':qty'    => $data['qty'],
            ':price'  => $data['price']
        ]);
    }
// Lấy danh sách nhân viên được phân công cho tour này
    public function getStaffByTour($tourId) {
        $sql = "SELECT e.FullName, e.Role, e.Phone 
                FROM TourAssignment ta
                JOIN Employee e ON ta.EmployeeID = e.EmployeeID
                WHERE ta.TourID = :tid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tid' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // 3. Cập nhật trạng thái dịch vụ (Dùng cho quy trình xác nhận)
    public function updateServiceStatus($serviceId, $status) {
        $sql = "UPDATE TourService SET Status = :status WHERE ServiceID = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['status' => $status, 'id' => $serviceId]);
    }

    // 4. Lấy thông tin 1 dịch vụ cụ thể (để gửi mail)
    public function getServiceDetail($serviceId) {
        $sql = "SELECT ts.*, s.SupplierName, s.Email as SupplierEmail, t.TourName, t.StartDate
                FROM TourService ts
                JOIN Tour t ON ts.TourID = t.TourID
                LEFT JOIN Supplier s ON ts.SupplierID = s.SupplierID
                WHERE ts.ServiceID = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $serviceId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
// --- PHẦN MỚI THÊM: QUẢN LÝ LỊCH TRÌNH (ITINERARY) ---

    // 1. Lấy danh sách lịch trình của 1 tour (Sắp xếp theo Ngày và Giờ)
    public function getItineraryByTour($tourId) {
        $sql = "SELECT * FROM TourItinerary 
                WHERE TourID = :tid 
                ORDER BY DayNumber ASC, TimeStart ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tid' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Thêm lịch trình mới
    public function addItinerary($data) {
        $sql = "INSERT INTO TourItinerary (TourID, DayNumber, Title, Content, TimeStart, Location)
                VALUES (:tourId, :day, :title, :content, :time, :loc)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // 3. Xóa lịch trình
    public function deleteItinerary($id) {
        $sql = "DELETE FROM TourItinerary WHERE ItineraryID = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
    // --- PHẦN MỚI: QUẢN LÝ KHÁCH TRONG TOUR ---

    // 1. Lấy danh sách khách của tour
// Lấy danh sách khách hàng đã được xếp vào Tour
    public function getTourCustomers($tourId) {
        $sql = "SELECT c.FullName, c.Phone, c.Email, tc.RoomNumber, tc.Note
                FROM TourCustomer tc
                JOIN Customer c ON tc.CustomerID = c.CustomerID
                WHERE tc.TourID = :tid";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tid' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // 2. Thêm khách vào tour (Giả sử chọn từ danh sách khách có sẵn hoặc tạo mới nhanh)
    // Ở đây mình làm đơn giản là thêm vào bảng TourCustomer từ Booking
    public function addCustomerToTour($data) {
        // BƯỚC 1: Loại bỏ bookingId khỏi mảng dữ liệu vì Database không có cột này
        if(isset($data['bookingId'])) {
            unset($data['bookingId']);
        }

        // BƯỚC 2: Sửa câu lệnh SQL (Bỏ cột BookingID)
        $sql = "INSERT INTO TourCustomer (TourID, CustomerID, RoomNumber, Note)
                VALUES (:tourId, :custId, :room, :note)";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }
    // (Tùy chọn) Lấy danh sách Booking của tour này để chọn khách
    public function getBookingsByTour($tourId) {
        $sql = "SELECT b.BookingID, c.CustomerID, c.FullName 
                FROM Booking b
                JOIN Customer c ON b.CustomerID = c.CustomerID
                WHERE b.TourID = :tid AND b.Status != 'Đã hủy'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tid' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Thêm hàm này vào class TourAssignmentModel
    public function getAllSuppliers() {
        $sql = "SELECT SupplierID, SupplierName FROM Supplier";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}