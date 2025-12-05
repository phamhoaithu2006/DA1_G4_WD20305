<?php
class DashboardModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    // Tổng số danh mục
    public function getTotalCategories() {
        $stmt = $this->conn->query("SELECT COUNT(*) AS total FROM Category");
        return $stmt->fetch()['total'];
    }

    // Tổng số tour
    public function getTotalTours() {
        $stmt = $this->conn->query("SELECT COUNT(*) AS total FROM Tour");
        return $stmt->fetch()['total'];
    }

    // Tổng số khách hàng
    public function getTotalCustomers() {
        $stmt = $this->conn->query("SELECT COUNT(*) AS total FROM Customer");
        return $stmt->fetch()['total'];
    }

    // Tổng số booking
    public function getTotalBookings() {
        $stmt = $this->conn->query("SELECT COUNT(*) AS total FROM Booking");
        return $stmt->fetch()['total'];
    }

    // Tổng số nhân viên
    public function getTotalEmployees() {
        $stmt = $this->conn->query("SELECT COUNT(*) AS total FROM Employee");
        return $stmt->fetch()['total'];
    }

    // 5 booking gần đây
    public function getRecentBookings($limit = 5) {
        $stmt = $this->conn->prepare("
            SELECT b.BookingID, b.BookingDate, b.TotalAmount, b.Status,
                   c.FullName AS CustomerName,
                   t.TourName
            FROM Booking b
            LEFT JOIN Customer c ON b.CustomerID = c.CustomerID
            LEFT JOIN Tour t ON b.TourID = t.TourID
            ORDER BY b.BookingDate DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}