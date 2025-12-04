<?php

class EmployeeModel {
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }

    // --- SỬA LẠI HÀM NÀY ---
    public function getAllEmployees() {
        // Logic: 
        // 1. LEFT JOIN để lấy thông tin Tour (nếu có).
        // 2. ORDER BY:
        //    - (t.TourID IS NOT NULL) DESC: Đưa người có tour (TRUE=1) lên đầu, người rảnh (FALSE=0) xuống dưới.
        //    - t.StartDate ASC: Ai đi tour sớm hơn xếp trước.
        //    - e.FullName ASC: Nếu cùng trạng thái thì xếp theo tên A-Z.
        
        $sql = "SELECT e.*, t.TourName, t.StartDate, t.EndDate
                FROM Employee e
                LEFT JOIN TourAssignment ta ON e.EmployeeID = ta.EmployeeID
                LEFT JOIN Tour t ON ta.TourID = t.TourID
                ORDER BY (t.TourID IS NOT NULL) DESC, t.StartDate ASC, e.FullName ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Các hàm Lấy 1, Thêm, Sửa, Xóa giữ nguyên
    public function getEmployeeByID($id) {
        $sql = "SELECT * FROM Employee WHERE EmployeeID = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addEmployee($name, $role, $phone, $email) {
        $defaultPassword = password_hash("123456", PASSWORD_DEFAULT);
        $sql = "INSERT INTO Employee (FullName, Role, Phone, Email, Password) 
                VALUES (:name, :role, :phone, :email, :password)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':name'     => $name,
            ':role'     => $role,
            ':phone'    => $phone,
            ':email'    => $email,
            ':password' => $defaultPassword
        ]);
    }

    public function updateEmployee($id, $name, $role, $phone, $email) {
        $sql = "UPDATE Employee SET FullName=:name, Role=:role, Phone=:phone, Email=:email WHERE EmployeeID=:id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id'=>$id,
            ':name'=>$name,
            ':role'=>$role,
            ':phone'=>$phone,
            ':email'=>$email
        ]);
    }

    public function deleteEmployee($id) {
        $sql = "DELETE FROM Employee WHERE EmployeeID=:id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id'=>$id]);
    }
    public function assignTourToEmployee($empId, $tourId) {
        // Kiểm tra xem nhân viên đã được gán vào tour này chưa để tránh trùng lặp
        $checkSql = "SELECT * FROM TourAssignment WHERE EmployeeID = :eid AND TourID = :tid";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->execute([':eid' => $empId, ':tid' => $tourId]);
        
        if ($checkStmt->rowCount() > 0) {
            return false; // Đã phân công rồi
        }

        // Nếu chưa, thực hiện thêm mới
        $sql = "INSERT INTO TourAssignment (EmployeeID, TourID) VALUES (:eid, :tid)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':eid' => $empId, ':tid' => $tourId]);
    }
    // Lấy danh sách các tour đã được phân công cho nhân viên
    // Lấy danh sách các tour đã được phân công cho nhân viên
    public function getToursByEmployee($empId) {
        // ĐÃ SỬA: Xóa "ta.AssignedDate" để tránh lỗi
        $sql = "SELECT t.TourName, t.StartDate, t.EndDate, t.Price 
                FROM TourAssignment ta
                JOIN Tour t ON ta.TourID = t.TourID
                WHERE ta.EmployeeID = :eid
                ORDER BY t.StartDate DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':eid' => $empId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}