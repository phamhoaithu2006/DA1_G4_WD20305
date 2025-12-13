<?php
// models/TourLogModel.php

class TourLogModel
{
    public $conn;

    public function __construct()
    {
        // Sử dụng hàm connectDB() từ commons/function.php
        // GIẢ ĐỊNH: connectDB() trả về đối tượng PDO
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
        // Vẫn giữ nguyên, không cần sửa
        $sql = "SELECT * FROM tourlog WHERE LogID = :logId";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':logId' => $logId]);
        return $stmt->fetch();
    }

    // Thêm mới Log - ĐÃ CẬP NHẬT: Thêm $employeeId và $logType
    public function insertLog($tourId, $employeeId, $note, $image, $incident, $logType)
    {
        $sql = "INSERT INTO tourlog (TourID, EmployeeID, Note, Images, Incident, LogType, LogDate) 
                VALUES (:tourId, :employeeId, :note, :image, :incident, :logType, NOW())";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':tourId' => $tourId,
            ':employeeId' => $employeeId,
            ':note' => $note,
            ':image' => $image,
            ':incident' => $incident,
            ':logType' => $logType // THÊM MỚI
        ]);
    }

    // Cập nhật Log - ĐÃ CẬP NHẬT: Thêm $employeeId và $logType
    public function updateLog($logId, $employeeId, $note, $image, $incident, $logType)
    {
        $baseSql = "UPDATE tourlog SET 
                        EmployeeID = :employeeId, 
                        Note = :note, 
                        Incident = :incident, 
                        LogType = :logType 
                    WHERE LogID = :logId";

        $params = [
            ':employeeId' => $employeeId, // THÊM MỚI
            ':note' => $note,
            ':incident' => $incident,
            ':logType' => $logType,       // THÊM MỚI
            ':logId' => $logId
        ];

        // Nếu có ảnh mới thì update thêm trường Images
        if ($image !== null) {
            $sql = "UPDATE tourlog SET 
                        EmployeeID = :employeeId, 
                        Note = :note, 
                        Images = :image, 
                        Incident = :incident, 
                        LogType = :logType 
                    WHERE LogID = :logId";
            $params[':image'] = $image;
        } else {
            $sql = $baseSql;
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
