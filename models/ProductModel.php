<?php
class ProductModel
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }


    // 3. Thêm Tour mới
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

    // 4. Xóa Tour
    public function deleteTour($id) {
        $sql = "DELETE FROM Tour WHERE TourID = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // 5. Lấy danh mục & Nhà cung cấp (cho Select box)
    public function getAllCategories() {
        $sql = "SELECT * FROM Category";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllSuppliers() {
        $sql = "SELECT * FROM Supplier";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ====================================================
    // PHẦN QUẢN LÝ LỊCH TRÌNH (ITINERARY)
    // ====================================================

    // 6. Lấy danh sách lịch trình theo TourID
    public function getTourItinerary($tourId) {
        $sql = "SELECT * FROM TourItinerary WHERE TourID = :tourId ORDER BY DayNumber ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':tourId' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 7. Thêm lịch trình mới
    public function insertItinerary($data) {
        $sql = "INSERT INTO TourItinerary (TourID, DayNumber, Title, Description, Accommodation, Meals)
                VALUES (:tourId, :day, :title, :desc, :hotel, :meals)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':tourId' => $data['TourID'],
            ':day' => $data['DayNumber'],
            ':title' => $data['Title'],
            ':desc' => $data['Description'],
            ':hotel' => $data['Accommodation'],
            ':meals' => $data['Meals']
        ]);
    }

    // 8. Xóa lịch trình
    public function deleteItinerary($id) {
        $sql = "DELETE FROM TourItinerary WHERE ItineraryID = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    // ... Các hàm cũ giữ nguyên ...

    // [MỚI] Lấy danh sách ảnh Gallery
    public function getTourGallery($tourId) {
        $sql = "SELECT * FROM tour_gallery WHERE TourID = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // [MỚI] Lấy bảng giá chi tiết
    public function getTourPricing($tourId) {
        $sql = "SELECT * FROM tour_pricing WHERE TourID = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // [MỚI] Lấy danh sách Nhà cung cấp dịch vụ cho Tour (Từ bảng TourService)
    public function getTourServices($tourId) {
        $sql = "SELECT ts.*, s.SupplierName, s.ContactInfo 
                FROM tourservice ts
                LEFT JOIN supplier s ON ts.SupplierID = s.SupplierID
                WHERE ts.TourID = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // [MỚI] Lấy danh sách khách hàng đã đặt Tour
    public function getTourCustomersList($tourId) {
        $sql = "
            SELECT 
                b.BookingID,
                b.BookingDate,
                b.Status,
                c.FullName,
                c.Phone,
                c.Email,
                (SELECT COUNT(*) FROM tourcustomer tc WHERE tc.CustomerID = c.CustomerID AND tc.TourID = b.TourID) as GroupSize
            FROM booking b
            JOIN customer c ON b.CustomerID = c.CustomerID
            WHERE b.TourID = :tourId 
            ORDER BY b.BookingDate DESC
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':tourId' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Hàm lấy chi tiết để check ngày (nếu chưa có)
    public function getTourDate($tourId) {
        $sql = "SELECT StartDate, EndDate FROM Tour WHERE TourID = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $tourId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    //Thêm file mới
    public function getUpcomingTours() {
        $sql = "SELECT TourID, TourName, Price, StartDate, EndDate, SupplierID 
                FROM Tour 
                WHERE StartDate >= CURRENT_DATE 
                ORDER BY StartDate ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ... Other existing methods (getAllTour, getOneDetail, insertTour, etc.) ...
    public function getAllTour() {
        $sql = "SELECT c.CategoryID, c.CategoryName, t.TourID, t.TourName, t.Price, t.StartDate, t.EndDate, t.Image, s.SupplierName
                FROM Category c
                INNER JOIN Tour t ON c.CategoryID = t.CategoryID
                LEFT JOIN Supplier s ON t.SupplierID = s.SupplierID
                ORDER BY c.CategoryName, t.TourName";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getOneDetail($id) {
        $sql = "SELECT t.*, c.CategoryName, s.SupplierName
                FROM Tour t
                LEFT JOIN Category c ON t.CategoryID = c.CategoryID
                LEFT JOIN Supplier s ON t.SupplierID = s.SupplierID
                WHERE t.TourID = :TourID";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':TourID' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getActiveTours() {
        $sql = "SELECT TourID, TourName, StartDate, EndDate 
                FROM Tour 
                WHERE EndDate >= CURRENT_DATE 
                ORDER BY StartDate ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // [MỚI] Hàm lấy thông tin ngày của 1 tour để check validate
    public function getTourDates($id) {
        $sql = "SELECT StartDate, EndDate FROM Tour WHERE TourID = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Thêm ảnh vào gallery
    public function insertGalleryImage($tourId, $imageUrl) {
        $sql = "INSERT INTO tour_gallery (TourID, ImageURL) VALUES (?, ?)";
        // Giả sử bạn dùng PDO, code sẽ tựa như sau (tùy vào class Connect của bạn):
        // $stmt = $this->conn->prepare($sql);
        // return $stmt->execute([$tourId, $imageUrl]);
        
        // Hoặc nếu dùng hàm pdo_execute có sẵn:
        return pdo_execute($sql, $tourId, $imageUrl); 
    }

    // Lấy thông tin 1 ảnh gallery (để xóa file)
    public function getGalleryImageById($imageId) {
        $sql = "SELECT * FROM tour_gallery WHERE ImageID = ?";
        return pdo_query_one($sql, $imageId);
    }

    // Xóa ảnh khỏi DB
    public function deleteGalleryImage($imageId) {
        $sql = "DELETE FROM tour_gallery WHERE ImageID = ?";
        return pdo_execute($sql, $imageId);
    }
    // ... Dán vào trong class ProductModel ...

    // 9. Thêm dịch vụ liên kết (TourService)
    public function insertService($data) {
        $sql = "INSERT INTO TourService (TourID, SupplierID, ServiceType, Quantity, Price, Note) 
                VALUES (:tourId, :supId, :type, :qty, :price, :note)";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':tourId' => $data['tour_id'],
            ':supId'  => $data['supplier_id'],
            ':type'   => $data['service_type'],
            ':qty'    => $data['quantity'],
            ':price'  => $data['price'],
            ':note'   => $data['note']
        ]);
    }
}