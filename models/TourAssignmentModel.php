<?php
class TourAssignmentModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    // --- CORE TOUR INFO ---
    public function getOneDetail($tourId) {
        $sql = "SELECT t.*, c.CategoryName, s.SupplierName
                FROM Tour t
                LEFT JOIN Category c ON t.CategoryID = c.CategoryID
                LEFT JOIN Supplier s ON t.SupplierID = s.SupplierID
                WHERE t.TourID = :tid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tid' => $tourId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateLogistics($tourId, $point, $time) {
        $sql = "UPDATE Tour SET MeetingPoint = :p, MeetingTime = :t WHERE TourID = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':p' => $point, ':t' => $time, ':id' => $tourId]);
    }

    // --- STAFF ASSIGNMENT ---
    public function getAvailableStaff($role, $startDate, $endDate) {
        $sql = "SELECT * FROM Employee 
                WHERE Role = :role 
                AND EmployeeID NOT IN (
                    SELECT ta.EmployeeID FROM TourAssignment ta 
                    JOIN Tour t ON ta.TourID = t.TourID
                    WHERE (t.StartDate <= :end AND t.EndDate >= :start)
                )";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':role' => $role, ':start' => $startDate, ':end' => $endDate]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function assignStaff($tourId, $empId, $role) {
        $check = $this->conn->prepare("SELECT * FROM TourAssignment WHERE TourID=:t AND EmployeeID=:e");
        $check->execute([':t'=>$tourId, ':e'=>$empId]);
        if($check->rowCount() > 0) return false;

        $sql = "INSERT INTO TourAssignment (TourID, EmployeeID, Role) VALUES (:t, :e, :r)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':t' => $tourId, ':e' => $empId, ':r' => $role]);
    }

    public function removeStaff($assignmentId) {
        $stmt = $this->conn->prepare("DELETE FROM TourAssignment WHERE AssignmentID = :id");
        return $stmt->execute([':id' => $assignmentId]);
    }

    public function getAssignedStaff($tourId) {
        $sql = "SELECT ta.AssignmentID, ta.Role as AssignedRole, e.* FROM TourAssignment ta
                JOIN Employee e ON ta.EmployeeID = e.EmployeeID
                WHERE ta.TourID = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- SERVICES ---
    public function getServicesByTour($tourId) {
        $sql = "SELECT ts.*, s.SupplierName, s.ContactInfo 
                FROM TourService ts 
                LEFT JOIN Supplier s ON ts.SupplierID = s.SupplierID 
                WHERE ts.TourID = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllSuppliers() {
        return $this->conn->query("SELECT * FROM Supplier")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addService($data) {
        $sql = "INSERT INTO TourService (TourID, SupplierID, ServiceType, Note, Quantity, Price, ServiceDate, Status)
                VALUES (:tourId, :supId, :type, :note, :qty, :price, :sDate, 0)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':tourId' => $data['tourId'],
            ':supId' => $data['supId'] ?: null,
            ':type' => $data['type'],
            ':note' => $data['note'],
            ':qty' => $data['qty'],
            ':price' => $data['price'],
            ':sDate' => $data['date']
        ]);
    }

    public function updateServiceStatus($id, $status) {
        $stmt = $this->conn->prepare("UPDATE TourService SET Status = :s WHERE ServiceID = :id");
        return $stmt->execute([':s' => $status, ':id' => $id]);
    }

    // --- CUSTOMERS ---
    public function getTourCustomers($tourId) {
        $sql = "SELECT c.CustomerID, c.FullName, c.Phone, c.Email, tc.RoomNumber, tc.Note
                FROM TourCustomer tc
                JOIN Customer c ON tc.CustomerID = c.CustomerID
                WHERE tc.TourID = :tid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tid' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // --- SPECIAL REQUESTS ---
    public function getSpecialRequests($tourId) {
        $sql = "SELECT r.*, c.FullName, c.Phone 
                FROM CustomerSpecialRequest r
                JOIN Customer c ON r.CustomerID = c.CustomerID
                WHERE r.TourID = :tid
                ORDER BY r.IsCritical DESC, r.CreatedAt ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tid' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addSpecialRequest($data) {
        $sql = "INSERT INTO CustomerSpecialRequest (TourID, CustomerID, RequestType, Content, IsCritical, Status)
                VALUES (:tid, :cid, :type, :content, :critical, 'Mới tiếp nhận')";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':tid'      => $data['tour_id'],
            ':cid'      => $data['customer_id'],
            ':type'     => $data['type'],
            ':content'  => $data['content'],
            ':critical' => $data['is_critical']
        ]);
    }

    public function updateRequestStatus($reqId, $status) {
        $sql = "UPDATE CustomerSpecialRequest SET Status = :status WHERE RequestID = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':status' => $status, ':id' => $reqId]);
    }

    public function countCriticalPending($tourId) {
        $sql = "SELECT COUNT(*) FROM CustomerSpecialRequest 
                WHERE TourID = :tid AND IsCritical = 1 AND Status != 'Hoàn thành'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tid' => $tourId]);
        return $stmt->fetchColumn();
    }
}
?>