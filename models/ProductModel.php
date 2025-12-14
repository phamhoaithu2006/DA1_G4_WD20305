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

    // --- [REVISED] QUẢN LÝ NHÀ CUNG CẤP (SUPPLIERS) ---

    // 1. Lấy tất cả NCC (Merged duplicate method)
    // Note: Assuming table name is 'Supplier' based on original code. Change to 'Suppliers' if needed.
    public function getAllSuppliers() {
        $sql = "SELECT * FROM Supplier ORDER BY SupplierID DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Lấy 1 NCC theo ID
    public function getSupplierById($id) {
        // Note: Assuming table name is 'Supplier'
        $sql = "SELECT * FROM Supplier WHERE SupplierID = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 3. Thêm mới NCC
   // Sửa lại tên cột cho đúng với Database của bạn
public function insertSupplier($data) {
    // Chỉ lưu Tên và Liên hệ (đảm bảo DB bạn có 2 cột này)
    $sql = "INSERT INTO Supplier (SupplierName, ContactInfo) 
            VALUES (:name, :contact)";
            
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([
        ':name' => $data['SupplierName'],
        ':contact' => $data['ContactInfo']
    ]);
}
    // 4. Cập nhật NCC
    public function updateSupplier($id, $data) {
        $sql = "UPDATE Supplier 
                SET SupplierName = :name, ContactInfo = :contact, Address = :addr, ServiceTypes = :type 
                WHERE SupplierID = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':name' => $data['SupplierName'],
            ':contact' => $data['ContactInfo'],
            ':addr' => $data['Address'],
            ':type' => $data['ServiceTypes']
        ]);
    }

    // 5. Xóa NCC
    public function deleteSupplier($id) {
        try {
            $sql = "DELETE FROM Supplier WHERE SupplierID = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            // Lỗi do ràng buộc khóa ngoại (NCC đang có trong Tour/Dịch vụ)
            return false;
        }
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
        // Using PDO directly via $this->conn
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$tourId, $imageUrl]);
    }

    // Lấy thông tin 1 ảnh gallery (để xóa file)
    public function getGalleryImageById($imageId) {
        // Assuming pdo_query_one is a global function from a helper file.
        // If not, replace with standard PDO logic like getOneDetail above.
        $sql = "SELECT * FROM tour_gallery WHERE ImageID = ?";
        // Standard PDO replacement if pdo_query_one isn't available:
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$imageId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Xóa ảnh khỏi DB
    public function deleteGalleryImage($imageId) {
        $sql = "DELETE FROM tour_gallery WHERE ImageID = ?";
        // Standard PDO replacement if pdo_execute isn't available:
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$imageId]);
    }

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
?>