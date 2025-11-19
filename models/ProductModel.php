<?php
// Có class chứa các function thực thi tương tác với cơ sở dữ liệu 
class ProductModel
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Viết truy vấn danh sách sản phẩm 
    public function getAllTour()
    {
        $sql = "
        SELECT 
            c.CategoryID,
            c.CategoryName,
            t.TourID,
            t.TourName,
            t.Price,
            t.StartDate,
            t.EndDate,
            s.SupplierName
        FROM Category c
        INNER JOIN Tour t 
            ON c.CategoryID = t.CategoryID
        LEFT JOIN Supplier s 
            ON t.SupplierID = s.SupplierID
        ORDER BY c.CategoryName, t.TourName
    ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getOneDetail($id)
    {
        $sql = "
       SELECT t.*, c.CategoryName, s.SupplierName
       FROM tour t
       LEFT JOIN category c ON t.CategoryID = c.CategoryID
       LEFT JOIN supplier s ON t.SupplierID = s.SupplierID
       WHERE t.TourID = :TourID
    ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':TourID' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
