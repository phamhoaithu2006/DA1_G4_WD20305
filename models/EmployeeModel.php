<?php
class EmployeeModel {
    public $conn;
    public function __construct() {
        $this->conn = connectDB();
    }

    // 1. Lấy danh sách tất cả nhân viên
    public function getAllEmployees() {
        $sql = "SELECT e.*, 
                (SELECT COUNT(*) FROM TourAssignment WHERE EmployeeID = e.EmployeeID) as TourCount
                FROM Employee e
                ORDER BY e.Role ASC, e.FullName ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Lấy thông tin chi tiết 1 nhân viên
    public function getEmployeeByID($id) {
        $sql = "SELECT * FROM Employee WHERE EmployeeID = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 3. Thêm mới nhân viên (Cập nhật đầy đủ trường)
    public function addEmployee($data) {
        $defaultPassword = password_hash("123456", PASSWORD_DEFAULT); // Mật khẩu mặc định
        
        $sql = "INSERT INTO Employee (FullName, Role, Phone, Email, Password, Avatar, DateOfBirth, Certificates, Languages, ExperienceYears, Type, HealthStatus) 
                VALUES (:name, :role, :phone, :email, :password, :avatar, :dob, :certs, :langs, :exp, :type, :health)";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':name'     => $data['name'],
            ':role'     => $data['role'],
            ':phone'    => $data['phone'],
            ':email'    => $data['email'],
            ':password' => $defaultPassword,
            ':avatar'   => $data['avatar'] ?? null,
            ':dob'      => $data['dob'] ?? null,
            ':certs'    => $data['certs'] ?? null,
            ':langs'    => $data['langs'] ?? null,
            ':exp'      => $data['exp'] ?? 0,
            ':type'     => $data['type'] ?? 'Nội địa',
            ':health'   => $data['health'] ?? null
        ]);
    }

    // 4. Cập nhật nhân viên (Cập nhật đầy đủ trường)
    public function updateEmployee($id, $data) {
        // Xây dựng câu query động: Chỉ cập nhật Avatar nếu có file mới
        $sql = "UPDATE Employee SET 
                FullName=:name, Role=:role, Phone=:phone, Email=:email, 
                DateOfBirth=:dob, Certificates=:certs, Languages=:langs, 
                ExperienceYears=:exp, Type=:type, HealthStatus=:health";
        
        // Nếu có avatar mới thì thêm vào câu lệnh SQL
        if (!empty($data['avatar'])) {
            $sql .= ", Avatar=:avatar";
        }
        
        $sql .= " WHERE EmployeeID=:id";

        $stmt = $this->conn->prepare($sql);
        
        $params = [
            ':id'       => $id,
            ':name'     => $data['name'],
            ':role'     => $data['role'],
            ':phone'    => $data['phone'],
            ':email'    => $data['email'],
            ':dob'      => $data['dob'],
            ':certs'    => $data['certs'],
            ':langs'    => $data['langs'],
            ':exp'      => $data['exp'],
            ':type'     => $data['type'],
            ':health'   => $data['health']
        ];

        // Nếu có avatar thì bind param
        if (!empty($data['avatar'])) {
            $params[':avatar'] = $data['avatar'];
        }

        return $stmt->execute($params);
    }

    // 5. Xóa nhân viên
    public function deleteEmployee($id) {
        $sql = "DELETE FROM Employee WHERE EmployeeID=:id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id'=>$id]);
    }

    // 6. Phân công tour
    public function assignTourToEmployee($empId, $tourId) {
        $checkSql = "SELECT * FROM TourAssignment WHERE EmployeeID = :eid AND TourID = :tid";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->execute([':eid' => $empId, ':tid' => $tourId]);
        
        if ($checkStmt->rowCount() > 0) return false; 

        $sql = "INSERT INTO TourAssignment (EmployeeID, TourID) VALUES (:eid, :tid)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':eid' => $empId, ':tid' => $tourId]);
    }

    // 7. Lấy danh sách tour đã dẫn
    public function getToursByEmployee($empId) {
        $sql = "SELECT t.TourName, t.StartDate, t.EndDate, t.Price, ta.Role as AssignedRole
                FROM TourAssignment ta
                JOIN Tour t ON ta.TourID = t.TourID
                WHERE ta.EmployeeID = :eid
                ORDER BY t.StartDate DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':eid' => $empId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>