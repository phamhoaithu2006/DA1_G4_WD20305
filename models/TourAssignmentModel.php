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




}