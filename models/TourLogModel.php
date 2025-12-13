<?php
// models/TourLogModel.php

class TourLogModel
{
    public $conn;

    public function __construct()
    {
        // Sử dụng hàm connectDB() từ commons/function.php
        $this->conn = connectDB();
    }

    // Lấy danh sách Log theo TourID (kèm tên nhân viên)
    public function getAllLogsByTour($tourId)
    {
        $sql = "SELECT tl.*, e.FullName 
                FROM tourlog tl
                LEFT JOIN employee e ON tl.EmployeeID = e.EmployeeID
                WHERE tl.TourID = :tourId
                ORDER BY tl.LogDate DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':tourId' => $tourId]);
        return $stmt->fetchAll();
    }

    // Lấy chi tiết 1 Log để sửa
    public function getLogById($logId)
    {
        $sql = "SELECT * FROM tourlog WHERE LogID = :logId";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':logId' => $logId]);
        return $stmt->fetch();
    }

    // Thêm mới Log
    public function insertLog($tourId, $employeeId, $note, $image, $incident)
    {
        $sql = "INSERT INTO tourlog (TourID, EmployeeID, Note, Images, Incident, LogDate) 
                VALUES (:tourId, :employeeId, :note, :image, :incident, NOW())";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':tourId' => $tourId,
            ':employeeId' => $employeeId,
            ':note' => $note,
            ':image' => $image,
            ':incident' => $incident
        ]);
    }

    // Cập nhật Log
    public function updateLog($logId, $note, $image, $incident)
    {
        // Nếu có ảnh mới thì update cả ảnh, không thì giữ nguyên
        if ($image !== null) {
            $sql = "UPDATE tourlog SET Note = :note, Images = :image, Incident = :incident WHERE LogID = :logId";
            $params = [
                ':note' => $note,
                ':image' => $image,
                ':incident' => $incident,
                ':logId' => $logId
            ];
        } else {
            $sql = "UPDATE tourlog SET Note = :note, Incident = :incident WHERE LogID = :logId";
            $params = [
                ':note' => $note,
                ':incident' => $incident,
                ':logId' => $logId
            ];
        }

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    // Xóa Log
    public function deleteLog($logId)
    {
        $sql = "DELETE FROM tourlog WHERE LogID = :logId";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':logId' => $logId]);
    }
}
