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
            t.Image,          -- Thêm dòng này
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
    //add
    // Thêm tour mới vào CSDL
    public function insertTour($data) {
        $sql = "INSERT INTO Tour (TourName, CategoryID, SupplierID, Price, StartDate, EndDate, Description, Image)
                VALUES (:name, :catId, :supId, :price, :start, :end, :desc, :img)";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':name' => $data['name'],
            ':catId' => $data['category_id'],
            ':supId' => $data['supplier_id'],
            ':price' => $data['price'],
            ':start' => $data['start_date'],
            ':end' => $data['end_date'],
            ':desc' => $data['description'],
            ':img' => $data['image']
        ]);
    }

    // Lấy danh sách danh mục (để hiện trong select box)
    public function getAllCategories() {
        $sql = "SELECT * FROM Category";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách nhà cung cấp (để hiện trong select box)
    public function getAllSuppliers() {
        $sql = "SELECT * FROM Supplier";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function deleteTour($id) {
        $sql = "DELETE FROM Tour WHERE TourID = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}