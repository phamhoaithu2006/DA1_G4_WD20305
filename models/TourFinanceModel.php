<?php
// models/TourFinanceModel.php

// BẮT BUỘC: Thêm REQUIRE_ONCE để Model nhìn thấy lớp Database
require_once __DIR__ . '/../commons/Database.php'; 

class TourFinanceModel
{
    private $db;
    
    public function __construct()
    {
        // Lấy kết nối bằng Singleton
        $db_instance = Database::getInstance();
        $this->db = $db_instance->getConnection();

        // Kiểm tra kết nối (Nên giữ lại để debug)
        if ($this->db === null) {
            die("Lỗi: Model không thể lấy kết nối CSDL.");
        }
    } // <-- Dấu ngoặc nhọn đóng hàm __construct() đã được đặt đúng chỗ
    
    // =======================================================

    public function getByTour($tourId)
    {
        $stmt = $this->db->prepare("SELECT tf.*, t.TourName FROM TourFinance tf LEFT JOIN Tour t ON tf.TourID = t.TourID WHERE tf.TourID = :tourId");
        $stmt->execute([':tourId' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM TourFinance WHERE FinanceID = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ============= CREATE =============

    public function create($data)
    {
        // Chỉ giữ lại 3 cột có thể chèn
        $valid_data = array_intersect_key($data, array_flip(['TourID', 'Revenue', 'Expense']));

        // Cú pháp SQL ĐÚNG
        $sql = "INSERT INTO TourFinance (TourID, Revenue, Expense)
                VALUES (:TourID, :Revenue, :Expense)";

        $stmt = $this->db->prepare($sql);

        // Bắt lỗi execute và trả về kết quả
        try {
            return $stmt->execute($valid_data);
        } catch (PDOException $e) {
            // Nên ghi log lỗi để debug chi tiết
            return false;
        }
    }

    // ============= UPDATE =============

    public function update($id, $data)
    {
        // Xóa Profit nếu có trong data
        unset($data['Profit']);

        $sql = "UPDATE TourFinance
                SET Revenue = :Revenue, Expense = :Expense
                WHERE FinanceID = :id";

        $stmt = $this->db->prepare($sql);
        $data['id'] = $id;

        return $stmt->execute($data);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM TourFinance WHERE FinanceID = :id");
        return $stmt->execute([':id' => $id]);
    }
}