<?php
class TourLogModel
{
    private $db;

    public function __construct()
    {
        // Dự án dùng connectDB(), không có class Database
        $this->db = connectDB();
    }

    public function getAllByTour($tourId)
    {
        $sql = "SELECT l.*, e.FullName AS EmployeeName 
                FROM TourLog l 
                LEFT JOIN Employee e ON l.EmployeeID = e.EmployeeID 
                WHERE l.TourID = :tourId 
                ORDER BY l.LogDate DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':tourId' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM TourLog WHERE LogID = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Trong TourLogModel.php -> create()
    public function create($data)
{
    // Đảm bảo tên tham số PDO khớp và sử dụng đúng khóa
    $sql = "INSERT INTO TourLog (TourID, EmployeeID, LogDate, Note) 
             VALUES (:TourID, :EmployeeID, :LogDate, :Note)";

    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
        ':TourID'     => $data['TourID'], // Nhận giá trị số nguyên đã được ép kiểu từ Controller
        ':EmployeeID' => $data['EmployeeID'] ?: null, 
        ':LogDate'    => $data['LogDate'] ?: date('Y-m-d H:i:s'),
        ':Note'       => $data['Note']
    ]);
}

    public function update($id, $data)
    {
        $sql = "UPDATE TourLog 
                SET EmployeeID = :employeeId, 
                    LogDate = :logDate, 
                    Note = :note 
                WHERE LogID = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':employeeId' => $data['EmployeeID'] ?: null,
            ':logDate'    => $data['LogDate'],
            ':note'       => $data['Note'],
            ':id'         => $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM TourLog WHERE LogID = :id");
        return $stmt->execute([':id' => $id]);
    }
}
