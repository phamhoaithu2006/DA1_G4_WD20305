<?php
class ReportModel {
    public $conn;
    public function __construct() {
        $this->conn = connectDB();
    }

    // 1. Lấy diễn biến tour (Log từ HDV)
    public function getTourLogs($tourId) {
        $sql = "SELECT tl.*, e.FullName as ReporterName 
                FROM TourLog tl
                LEFT JOIN Employee e ON tl.EmployeeID = e.EmployeeID
                WHERE tl.TourID = :tid 
                ORDER BY tl.LogDate DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tid' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Lấy phản hồi khách hàng
    public function getFeedback($tourId) {
        $sql = "SELECT f.*, c.FullName, c.Phone 
                FROM TourFeedback f
                JOIN Customer c ON f.CustomerID = c.CustomerID
                WHERE f.TourID = :tid
                ORDER BY f.CreatedAt DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tid' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. Lấy danh sách nhân viên trong tour để Admin đánh giá
    public function getStaffInTour($tourId) {
        $sql = "SELECT ta.EmployeeID, e.FullName, e.Role, ta.Role as TourRole
                FROM TourAssignment ta
                JOIN Employee e ON ta.EmployeeID = e.EmployeeID
                WHERE ta.TourID = :tid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tid' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 4. Lưu đánh giá nhân viên
    public function saveEvaluation($data) {
        $sql = "INSERT INTO EmployeeEvaluation (TourID, EmployeeID, EvaluatorID, Score, Note)
                VALUES (:tid, :eid, :adminId, :score, :note)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':tid' => $data['tour_id'],
            ':eid' => $data['employee_id'],
            ':adminId' => $data['evaluator_id'], // ID của Admin đang đăng nhập
            ':score' => $data['score'],
            ':note' => $data['note']
        ]);
    }

    // 5. Lấy lịch sử đánh giá của tour này
    public function getEvaluations($tourId) {
        $sql = "SELECT ev.*, e.FullName as EmpName, adm.FullName as AdminName
                FROM EmployeeEvaluation ev
                JOIN Employee e ON ev.EmployeeID = e.EmployeeID
                LEFT JOIN Employee adm ON ev.EvaluatorID = adm.EmployeeID
                WHERE ev.TourID = :tid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tid' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>