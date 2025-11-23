<?php
// models/HDVModel.php
// Model xử lý dữ liệu cho HDV

// Kết nối DB
require_once './commons/env.php';
require_once './commons/function.php';

// Sử dụng PDO (connectDB() trả về PDO)
// Lấy nhân viên theo email
function getEmployeeByEmail($email)
{
    $conn = connectDB();
    $sql = "SELECT * FROM Employee WHERE Email = :email LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['email' => $email]);
    return $stmt->fetch();
}

// Lấy các tour được phân công cho HDV
// Trả về mảng các hàng (array)
function getAssignedTours($employeeId)
{
    $conn = connectDB();
    $sql = "SELECT t.TourID, t.TourName, t.StartDate, t.EndDate, t.Price, 
                   c.CategoryName, s.SupplierName
            FROM TourAssignment ta
            JOIN Tour t ON ta.TourID = t.TourID
            LEFT JOIN Category c ON t.CategoryID = c.CategoryID
            LEFT JOIN Supplier s ON t.SupplierID = s.SupplierID
            WHERE ta.EmployeeID = :eid
            ORDER BY t.StartDate ASC";

    $stmt = $conn->prepare($sql);
    $stmt->execute(['eid' => $employeeId]);
    return $stmt->fetchAll();
}

// Lấy chi tiết tour 
function getTourDetailById($tourId)
{
    $conn = connectDB();
    $sql = "SELECT t.*, c.CategoryName, s.SupplierName
            FROM Tour t
            LEFT JOIN Category c ON t.CategoryID = c.CategoryID
            LEFT JOIN Supplier s ON t.SupplierID = s.SupplierID
            WHERE t.TourID = :tid LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->execute(['tid' => $tourId]);
    return $stmt->fetch();
}

// Lấy danh sách khách trong tour
// Trả về mảng
function getCustomersInTour($tourId)
{
    $conn = connectDB();
    $sql = "SELECT c.FullName, c.Email, c.Phone, tc.RoomNumber, tc.Note
            FROM TourCustomer tc
            JOIN Customer c ON tc.CustomerID = c.CustomerID
            WHERE tc.TourID = :tid";

    $stmt = $conn->prepare($sql);
    $stmt->execute(['tid' => $tourId]);
    return $stmt->fetchAll();
}

// Lấy nhật ký tour
// Trả về mảng
function getTourLogs($tourId)
{
    $conn = connectDB();

    // Kiểm tra xem các cột Images và Incident có tồn tại không
    try {
        $checkSql = "SHOW COLUMNS FROM TourLog LIKE 'Images'";
        $checkStmt = $conn->query($checkSql);
        $hasImages = $checkStmt->rowCount() > 0;

        $checkSql2 = "SHOW COLUMNS FROM TourLog LIKE 'Incident'";
        $checkStmt2 = $conn->query($checkSql2);
        $hasIncident = $checkStmt2->rowCount() > 0;
    } catch (Exception $e) {
        // Nếu không kiểm tra được, giả sử không có
        $hasImages = false;
        $hasIncident = false;
    }

    // Xây dựng select dựa trên các cột có sẵn
    $selectFields = "tl.LogID, tl.LogDate, tl.Note";
    if ($hasImages) {
        $selectFields .= ", tl.Images";
    }
    if ($hasIncident) {
        $selectFields .= ", tl.Incident";
    }
    $selectFields .= ", e.FullName AS EmployeeName";

    $sql = "SELECT $selectFields
            FROM TourLog tl
            LEFT JOIN Employee e ON tl.EmployeeID = e.EmployeeID
            WHERE tl.TourID = :tid
            ORDER BY tl.LogDate DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute(['tid' => $tourId]);
    $results = $stmt->fetchAll();

    // Đảm bảo các key Images và Incident luôn tồn tại trong kết quả
    foreach ($results as &$row) {
        if (!isset($row['Images'])) {
            $row['Images'] = null;
        }
        if (!isset($row['Incident'])) {
            $row['Incident'] = null;
        }
    }

    return $results;
}

// Lấy một nhật ký theo id
function getTourLogById($logId)
{
    $conn = connectDB();

    // Kiểm tra xem các cột Images và Incident có tồn tại không
    try {
        $checkSql = "SHOW COLUMNS FROM TourLog LIKE 'Images'";
        $checkStmt = $conn->query($checkSql);
        $hasImages = $checkStmt->rowCount() > 0;

        $checkSql2 = "SHOW COLUMNS FROM TourLog LIKE 'Incident'";
        $checkStmt2 = $conn->query($checkSql2);
        $hasIncident = $checkStmt2->rowCount() > 0;
    } catch (Exception $e) {
        $hasImages = false;
        $hasIncident = false;
    }

    // Xây dựng select dựa trên các cột có sẵn
    $selectFields = "LogID, TourID, EmployeeID, LogDate, Note";
    if ($hasImages) {
        $selectFields .= ", Images";
    }
    if ($hasIncident) {
        $selectFields .= ", Incident";
    }

    $sql = "SELECT $selectFields FROM TourLog WHERE LogID = :lid LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['lid' => $logId]);
    $result = $stmt->fetch();

    // Đảm bảo các key Images và Incident luôn tồn tại
    if ($result) {
        if (!isset($result['Images'])) {
            $result['Images'] = null;
        }
        if (!isset($result['Incident'])) {
            $result['Incident'] = null;
        }
    }

    return $result;
}

// Lưu nhật ký tour (thêm mới hoặc cập nhật)
function saveTourLog($data)
{
    $conn = connectDB();

    // Kiểm tra xem các cột Images và Incident có tồn tại không
    try {
        $checkSql = "SHOW COLUMNS FROM TourLog LIKE 'Images'";
        $checkStmt = $conn->query($checkSql);
        $hasImages = $checkStmt->rowCount() > 0;

        $checkSql2 = "SHOW COLUMNS FROM TourLog LIKE 'Incident'";
        $checkStmt2 = $conn->query($checkSql2);
        $hasIncident = $checkStmt2->rowCount() > 0;
    } catch (Exception $e) {
        $hasImages = false;
        $hasIncident = false;
    }

    if (!empty($data['LogID'])) {
        // Cập nhật
        if ($hasImages && $hasIncident) {
            $sql = "UPDATE TourLog SET Note = :note, Images = :images, Incident = :incident, 
                                       LogDate = NOW(), EmployeeID = :eid
                    WHERE LogID = :lid";
            $stmt = $conn->prepare($sql);
            return $stmt->execute([
                'note' => $data['Note'],
                'images' => $data['Images'] ?? null,
                'incident' => $data['Incident'] ?? null,
                'eid' => $data['EmployeeID'],
                'lid' => $data['LogID']
            ]);
        } else {
            // Chỉ cập nhật các cột cơ bản
            $sql = "UPDATE TourLog SET Note = :note, LogDate = NOW(), EmployeeID = :eid
                    WHERE LogID = :lid";
            $stmt = $conn->prepare($sql);
            return $stmt->execute([
                'note' => $data['Note'],
                'eid' => $data['EmployeeID'],
                'lid' => $data['LogID']
            ]);
        }
    } else {
        // Thêm mới
        if ($hasImages && $hasIncident) {
            $sql = "INSERT INTO TourLog (TourID, EmployeeID, Note, Images, Incident, LogDate)
                    VALUES (:tid, :eid, :note, :images, :incident, NOW())";
            $stmt = $conn->prepare($sql);
            return $stmt->execute([
                'tid' => $data['TourID'],
                'eid' => $data['EmployeeID'],
                'note' => $data['Note'],
                'images' => $data['Images'] ?? null,
                'incident' => $data['Incident'] ?? null
            ]);
        } else {
            // Chỉ thêm các cột cơ bản
            $sql = "INSERT INTO TourLog (TourID, EmployeeID, Note, LogDate)
                    VALUES (:tid, :eid, :note, NOW())";
            $stmt = $conn->prepare($sql);
            return $stmt->execute([
                'tid' => $data['TourID'],
                'eid' => $data['EmployeeID'],
                'note' => $data['Note']
            ]);
        }
    }
}

// Helper function: kiểm tra bảng có tồn tại không
function tableExists($tableName)
{
    $conn = connectDB();
    try {
        $sql = "SHOW TABLES LIKE :table";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['table' => $tableName]);
        return $stmt->rowCount() > 0;
    } catch (Exception $e) {
        return false;
    }
}

function ensureCheckInOutTable()
{
    $conn = connectDB();
    if (tableExists('TourCheckInOut')) {
        return true;
    }
    try {
        $sql = "CREATE TABLE IF NOT EXISTS `TourCheckInOut` (
          `CheckInOutID` INT(11) NOT NULL AUTO_INCREMENT,
          `TourID` INT(11) NOT NULL,
          `EmployeeID` INT(11) NOT NULL,
          `Type` ENUM('checkin','checkout') NOT NULL,
          `Note` TEXT NULL,
          `CreatedAt` DATETIME NOT NULL,
          PRIMARY KEY (`CheckInOutID`),
          INDEX `idx_tour` (`TourID`),
          INDEX `idx_employee` (`EmployeeID`),
          INDEX `idx_type` (`Type`),
          INDEX `idx_created` (`CreatedAt`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $conn->exec($sql);
        return tableExists('TourCheckInOut');
    } catch (Exception $e) {
        return false;
    }
}

// Lưu check-in/check-out
function saveCheckInOut($data)
{
    $conn = connectDB();

    if (!ensureCheckInOutTable()) {
        return false;
    }

    try {
        $checkSql = "SHOW COLUMNS FROM TourCheckInOut LIKE 'Location'";
        $checkStmt = $conn->query($checkSql);
        $hasLocation = $checkStmt->rowCount() > 0;
    } catch (Exception $e) {
        $hasLocation = false;
    }

    if ($hasLocation) {
        $sql = "INSERT INTO TourCheckInOut (TourID, EmployeeID, Type, Location, Note, CreatedAt)
                VALUES (:tid, :eid, :type, :location, :note, NOW())";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'tid' => $data['TourID'],
            'eid' => $data['EmployeeID'],
            'type' => $data['Type'],
            'location' => $data['Location'] ?? null,
            'note' => $data['Note'] ?? null
        ]);
    } else {
        $sql = "INSERT INTO TourCheckInOut (TourID, EmployeeID, Type, Note, CreatedAt)
                VALUES (:tid, :eid, :type, :note, NOW())";
        $stmt = $conn->prepare($sql);
        $locationText = isset($data['Location']) && strlen(trim($data['Location'])) > 0 ? trim($data['Location']) : '';
        $noteText = isset($data['Note']) ? trim($data['Note']) : '';
        $combinedNote = $locationText !== '' ? ('Địa điểm: ' . $locationText . ($noteText !== '' ? ' | ' . $noteText : '')) : ($noteText !== '' ? $noteText : null);
        return $stmt->execute([
            'tid' => $data['TourID'],
            'eid' => $data['EmployeeID'],
            'type' => $data['Type'],
            'note' => $combinedNote
        ]);
    }
}

// Lấy lịch sử check-in/check-out
function getCheckInOutHistory($tourId)
{
    $conn = connectDB();

    if (!tableExists('TourCheckInOut')) {
        return [];
    }

    try {
        $checkSql = "SHOW COLUMNS FROM TourCheckInOut LIKE 'Location'";
        $checkStmt = $conn->query($checkSql);
        $hasLocation = $checkStmt->rowCount() > 0;
    } catch (Exception $e) {
        $hasLocation = false;
    }

    $selectFields = "cio.Type, cio.Note, cio.CreatedAt";
    if ($hasLocation) {
        $selectFields .= ", cio.Location";
    }
    $selectFields .= ", e.FullName AS EmployeeName";

    $sql = "SELECT $selectFields
            FROM TourCheckInOut cio
            LEFT JOIN Employee e ON cio.EmployeeID = e.EmployeeID
            WHERE cio.TourID = :tid
            ORDER BY cio.CreatedAt DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['tid' => $tourId]);
    $rows = $stmt->fetchAll();

    if (!$hasLocation) {
        foreach ($rows as &$row) {
            if (!isset($row['Location'])) {
                $row['Location'] = null;
            }
        }
    }

    return $rows;
}

// Lấy danh sách khách với thông tin yêu cầu đặc biệt
function getCustomersWithSpecialRequests($tourId)
{
    $conn = connectDB();

    // Kiểm tra bảng TourCustomerSpecialRequest có tồn tại không
    $hasSpecialRequestTable = tableExists('TourCustomerSpecialRequest');

    if ($hasSpecialRequestTable) {
        $sql = "SELECT c.CustomerID, c.FullName, c.Email, c.Phone, 
                       tc.RoomNumber, tc.Note,
                       COALESCE(sr.Vegetarian, 0) AS Vegetarian,
                       sr.MedicalCondition, sr.OtherRequests, sr.SpecialRequests
                FROM TourCustomer tc
                JOIN Customer c ON tc.CustomerID = c.CustomerID
                LEFT JOIN TourCustomerSpecialRequest sr ON tc.CustomerID = sr.CustomerID AND tc.TourID = sr.TourID
                WHERE tc.TourID = :tid";
    } else {
        // Nếu bảng chưa tồn tại, chỉ lấy thông tin cơ bản
        $sql = "SELECT c.CustomerID, c.FullName, c.Email, c.Phone, 
                       tc.RoomNumber, tc.Note,
                       0 AS Vegetarian,
                       NULL AS MedicalCondition, 
                       NULL AS OtherRequests, 
                       NULL AS SpecialRequests
                FROM TourCustomer tc
                JOIN Customer c ON tc.CustomerID = c.CustomerID
                WHERE tc.TourID = :tid";
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute(['tid' => $tourId]);
    return $stmt->fetchAll();
}

// Lưu & cập nhật yêu cầu đặc biệt
function saveSpecialRequest($data)
{
    $conn = connectDB();

    // Kiểm tra bảng có tồn tại không
    if (!tableExists('TourCustomerSpecialRequest')) {
        return false; // bảng chưa tồn tại, không thể lưu
    }

    // Kiểm tra xem đã có record chưa
    $checkSql = "SELECT * FROM TourCustomerSpecialRequest 
                 WHERE TourID = :tid AND CustomerID = :cid LIMIT 1";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->execute(['tid' => $data['TourID'], 'cid' => $data['CustomerID']]);
    $existing = $checkStmt->fetch();

    if ($existing) {
        // Cập nhật
        $sql = "UPDATE TourCustomerSpecialRequest 
                SET Vegetarian = :vegetarian, MedicalCondition = :medical, 
                    OtherRequests = :other, SpecialRequests = :special, UpdatedAt = NOW()
                WHERE TourID = :tid AND CustomerID = :cid";
    } else {
        // Thêm mới
        $sql = "INSERT INTO TourCustomerSpecialRequest 
                (TourID, CustomerID, Vegetarian, MedicalCondition, OtherRequests, SpecialRequests, CreatedAt, UpdatedAt)
                VALUES (:tid, :cid, :vegetarian, :medical, :other, :special, NOW(), NOW())";
    }

    $stmt = $conn->prepare($sql);
    return $stmt->execute([
        'tid' => $data['TourID'],
        'cid' => $data['CustomerID'],
        'vegetarian' => $data['Vegetarian'] ?? 0,
        'medical' => $data['MedicalCondition'] ?? null,
        'other' => $data['OtherRequests'] ?? null,
        'special' => $data['SpecialRequests'] ?? null
    ]);
}
