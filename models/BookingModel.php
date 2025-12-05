<?php
class BookingModel {
    private $db; // PDO

    public function __construct($db) {
        $this->db = $db;
    }

    // Lấy danh sách booking (có join Customer + Tour)
    public function getAllBookings() {
        $sql = "SELECT b.BookingID, b.BookingDate, b.Status, b.TotalAmount,
                       c.CustomerID, c.FullName AS CustomerName,
                       t.TourID, t.TourName
                FROM Booking b
                LEFT JOIN Customer c ON b.CustomerID = c.CustomerID
                LEFT JOIN Tour t ON b.TourID = t.TourID
                ORDER BY b.BookingDate DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy booking theo ID
    public function getBookingById($id) {
        $sql = "SELECT b.*, c.FullName AS CustomerName, c.Email, c.Phone, t.TourName, t.Price
                FROM Booking b
                LEFT JOIN Customer c ON b.CustomerID = c.CustomerID
                LEFT JOIN Tour t ON b.TourID = t.TourID
                WHERE b.BookingID = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tạo customer mới (trả về CustomerID)
    public function createCustomer($data) {
        $sql = "INSERT INTO Customer (FullName, Email, Phone, Address)
                VALUES (:fullname, :email, :phone, :address)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':fullname' => $data['FullName'],
            ':email' => $data['Email'] ?? null,
            ':phone' => $data['Phone'] ?? null,
            ':address' => $data['Address'] ?? null
        ]);
        return $this->db->lastInsertId();
    }

    // Tạo booking (trả về BookingID) — dùng transaction nếu cần insert thêm TourCustomer
    // $bookingData: [CustomerID, TourID, BookingDate (optional), Status, TotalAmount]
    public function createBooking($bookingData, $tourCustomers = []) {
        try {
            $this->db->beginTransaction();

            $sql = "INSERT INTO Booking (CustomerID, TourID, BookingDate, Status, TotalAmount)
                    VALUES (:customerId, :tourId, :bookingDate, :status, :totalAmount)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':customerId' => $bookingData['CustomerID'],
                ':tourId' => $bookingData['TourID'],
                ':bookingDate' => $bookingData['BookingDate'] ?? date('Y-m-d H:i:s'),
                ':status' => $bookingData['Status'] ?? 'Đang xử lý',
                ':totalAmount' => $bookingData['TotalAmount'] ?? null
            ]);
            $bookingId = $this->db->lastInsertId();

            // Nếu có danh sách khách (đoàn), insert vào TourCustomer
            if (!empty($tourCustomers)) {
                $sqlTC = "INSERT INTO TourCustomer (TourID, CustomerID, RoomNumber, Note)
                          VALUES (:tourId, :customerId, :roomNumber, :note)";
                $stmtTC = $this->db->prepare($sqlTC);
                foreach ($tourCustomers as $tc) {
                    $stmtTC->execute([
                        ':tourId' => $bookingData['TourID'],
                        ':customerId' => $tc['CustomerID'],
                        ':roomNumber' => $tc['RoomNumber'] ?? null,
                        ':note' => $tc['Note'] ?? null
                    ]);
                }
            }

            $this->db->commit();
            return $bookingId;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    // Cập nhật trạng thái booking
    public function updateStatus($bookingId, $status) {
        $sql = "UPDATE Booking SET Status = :status WHERE BookingID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':status' => $status, ':id' => $bookingId]);
    }

    // Cập nhật tổng tiền (nếu muốn tính lại)
    public function updateTotalAmount($bookingId, $amount) {
        $sql = "UPDATE Booking SET TotalAmount = :amount WHERE BookingID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':amount' => $amount, ':id' => $bookingId]);
    }

    // Lấy danh sách khách của tour (TourCustomer)
    public function getTourCustomers($tourId) {
        $sql = "SELECT tc.*, c.FullName FROM TourCustomer tc
                LEFT JOIN Customer c ON tc.CustomerID = c.CustomerID
                WHERE tc.TourID = :tourId";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':tourId' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}