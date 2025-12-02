<?php
class TourFinanceModel
{
    private $db;
    public function __construct()
    {
        // Kết nối DB thông qua hàm helper connectDB()
        $this->db = connectDB();
    }

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

    // ============= CREATE (KHÔNG CHO PHÉP SET Profit) =============

    public function create($data)
    {
        // Xóa Profit nếu có trong data
        unset($data['Profit']);

        $sql = "INSERT INTO TourFinance (FinanceID, TourID, Revenue, Expense, Profit)
                VALUES (:FinanceID, :TourID, :Revenue, :, :Profit)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // ============= UPDATE (KHÔNG CHO PHÉP SET Profit) =============

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
