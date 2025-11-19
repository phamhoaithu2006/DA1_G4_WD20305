<?php
// models/HDVModel.php
// Model xử lý dữ liệu cho HDV

// Kết nối DB
require_once './commons/env.php';
require_once './commons/function.php';

// Sử dụng PDO (connectDB() trả về PDO)
// Lấy nhân viên theo email
function getEmployeeByEmail($email)
{
    $conn = connectDB();
    $sql = "SELECT * FROM Employee WHERE Email = :email LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['email' => $email]);
    return $stmt->fetch();
}

// Lấy các tour được phân công cho HDV
// Trả về mảng các hàng (array)
function getAssignedTours($employeeId)
{
    $conn = connectDB();
    $sql = "SELECT t.TourID, t.TourName, t.StartDate, t.EndDate, t.Price, 
                   c.CategoryName, s.SupplierName
            FROM TourAssignment ta
            JOIN Tour t ON ta.TourID = t.TourID
            LEFT JOIN Category c ON t.CategoryID = c.CategoryID
            LEFT JOIN Supplier s ON t.SupplierID = s.SupplierID
            WHERE ta.EmployeeID = :eid
            ORDER BY t.StartDate ASC";

    $stmt = $conn->prepare($sql);
    $stmt->execute(['eid' => $employeeId]);
    return $stmt->fetchAll();
}

// Lấy chi tiết tour 
function getTourDetailById($tourId)
{
    $conn = connectDB();
    $sql = "SELECT t.*, c.CategoryName, s.SupplierName
            FROM Tour t
            LEFT JOIN Category c ON t.CategoryID = c.CategoryID
            LEFT JOIN Supplier s ON t.SupplierID = s.SupplierID
            WHERE t.TourID = :tid LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->execute(['tid' => $tourId]);
    return $stmt->fetch();
}

// Lấy danh sách khách trong tour
// Trả về mảng
function getCustomersInTour($tourId)
{
    $conn = connectDB();
    $sql = "SELECT c.FullName, c.Email, c.Phone, tc.RoomNumber, tc.Note
            FROM TourCustomer tc
            JOIN Customer c ON tc.CustomerID = c.CustomerID
            WHERE tc.TourID = :tid";

    $stmt = $conn->prepare($sql);
    $stmt->execute(['tid' => $tourId]);
    return $stmt->fetchAll();
}

// Lấy nhật ký tour
// Trả về mảng
function getTourLogs($tourId)
{
    $conn = connectDB();
    $sql = "SELECT tl.LogID, tl.LogDate, tl.Note, 
                   e.FullName AS EmployeeName
            FROM TourLog tl
            LEFT JOIN Employee e ON tl.EmployeeID = e.EmployeeID
            WHERE tl.TourID = :tid
            ORDER BY tl.LogDate ASC";

    $stmt = $conn->prepare($sql);
    $stmt->execute(['tid' => $tourId]);
    return $stmt->fetchAll();
}
