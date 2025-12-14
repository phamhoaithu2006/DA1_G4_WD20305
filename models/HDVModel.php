<?php
// models/HDVModel.php
// Model xử lý dữ liệu cho HDV

require_once './commons/env.php';
require_once './commons/function.php';

// =================================================================
// 1. AUTH & GENERAL TOUR INFO
// =================================================================

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

// =================================================================
// 2. CUSTOMER MANAGEMENT (Xử lý Khách hàng & JSON Data)
// =================================================================

// Lấy danh sách khách trong tour (Logic cơ bản)
function getCustomersInTour($tourId)
{
    $conn = connectDB();
    $sql = "SELECT c.CustomerID, c.FullName, c.Email, c.Phone, tc.RoomNumber, tc.Note
            FROM TourCustomer tc
            JOIN Customer c ON tc.CustomerID = c.CustomerID
            WHERE tc.TourID = :tid";

    $stmt = $conn->prepare($sql);
    $stmt->execute(['tid' => $tourId]);
    $rows = $stmt->fetchAll();

    foreach ($rows as &$row) {
        $row['AttendanceChecked'] = 0;
        $row['AttendanceTime'] = null;
        $row['AttendanceBy'] = null;

        $note = $row['Note'] ?? '';
        if (!empty($note)) {
            $decoded = json_decode($note, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                if (isset($decoded['attendance']) && is_array($decoded['attendance'])) {
                    $att = $decoded['attendance'];
                    $row['AttendanceChecked'] = !empty($att['checked']) ? 1 : 0;
                    $row['AttendanceTime'] = $att['time'] ?? null;
                    $row['AttendanceBy'] = $att['by'] ?? null;
                }
            }
        }
    }

    return $rows;
}

// Gán phòng (Nhập tay nhanh)
function assignRoom($tourId, $customerId, $roomNumber)
{
    $conn = connectDB();
    $sql = "UPDATE TourCustomer SET RoomNumber = :room WHERE TourID = :tid AND CustomerID = :cid";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([
        'room' => $roomNumber,
        'tid' => $tourId,
        'cid' => $customerId
    ]);
}

// Lấy danh sách phòng
function getRoomsOfTour($tourId)
{
    $conn = connectDB();
    $sql = "SELECT CustomerID, RoomNumber FROM TourCustomer WHERE TourID = :tid AND RoomNumber IS NOT NULL AND TRIM(RoomNumber) <> ''";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['tid' => $tourId]);
    $rows = $stmt->fetchAll();

    $rooms = [];
    foreach ($rows as $r) {
        $room = $r['RoomNumber'];
        if (!isset($rooms[$room])) $rooms[$room] = [];
        $rooms[$room][] = $r['CustomerID'];
    }
    return $rooms;
}

// =================================================================
// 3. TOUR LOGS (Nhật ký hành trình)
// =================================================================

function getTourLogs($tourId)
{
    $conn = connectDB();
    ensureTourLogOptionalColumns();

    ensureTourLogOptionalColumns();

    // Kiểm tra xem các cột Images và Incident có tồn tại không
    try {
        $checkSql = "SHOW COLUMNS FROM TourLog LIKE 'Images'";
        $hasImages = $conn->query($checkSql)->rowCount() > 0;
        $checkSql2 = "SHOW COLUMNS FROM TourLog LIKE 'Incident'";
        $hasIncident = $conn->query($checkSql2)->rowCount() > 0;
    } catch (Exception $e) {
        $hasImages = false; $hasIncident = false;
    }

    $selectFields = "tl.LogID, tl.LogDate, tl.Note";
    if ($hasImages) $selectFields .= ", tl.Images";
    if ($hasIncident) $selectFields .= ", tl.Incident";
    $selectFields .= ", e.FullName AS EmployeeName";

    $sql = "SELECT $selectFields FROM TourLog tl
            LEFT JOIN Employee e ON tl.EmployeeID = e.EmployeeID
            WHERE tl.TourID = :tid ORDER BY tl.LogDate DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute(['tid' => $tourId]);
    $results = $stmt->fetchAll();

    foreach ($results as &$row) {
        if (!isset($row['Images'])) $row['Images'] = null;
        if (!isset($row['Incident'])) $row['Incident'] = null;
    }
    return $results;
}

function getTourLogById($logId)
{
    $conn = connectDB();
    ensureTourLogOptionalColumns();

    ensureTourLogOptionalColumns();

    // Kiểm tra xem các cột Images và Incident có tồn tại không
    try {
        $hasImages = $conn->query("SHOW COLUMNS FROM TourLog LIKE 'Images'")->rowCount() > 0;
        $hasIncident = $conn->query("SHOW COLUMNS FROM TourLog LIKE 'Incident'")->rowCount() > 0;
    } catch (Exception $e) { $hasImages = false; $hasIncident = false; }

    $selectFields = "LogID, TourID, EmployeeID, LogDate, Note";
    if ($hasImages) $selectFields .= ", Images";
    if ($hasIncident) $selectFields .= ", Incident";

    $sql = "SELECT $selectFields FROM TourLog WHERE LogID = :lid LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['lid' => $logId]);
    $result = $stmt->fetch();

    if ($result) {
        if (!isset($result['Images'])) $result['Images'] = null;
        if (!isset($result['Incident'])) $result['Incident'] = null;
    }
    return $result;
}

function saveTourLog($data)
{
    $conn = connectDB();
    ensureTourLogOptionalColumns();

    ensureTourLogOptionalColumns();

    // Kiểm tra xem các cột Images và Incident có tồn tại không
    try {
        $hasImages = $conn->query("SHOW COLUMNS FROM TourLog LIKE 'Images'")->rowCount() > 0;
        $hasIncident = $conn->query("SHOW COLUMNS FROM TourLog LIKE 'Incident'")->rowCount() > 0;
    } catch (Exception $e) { $hasImages = false; $hasIncident = false; }

    if (!empty($data['LogID'])) {
        // Cập nhật bản ghi hiện có
        $setParts = ["Note = :note"];
        $params = [
            'note' => $data['Note'],
            'eid' => $data['EmployeeID'],
            'lid' => $data['LogID']
        ];

        if ($hasImages) {
            $setParts[] = "Images = :images";
            $params['images'] = $data['Images'] ?? null;
        }

        if ($hasIncident) {
            $setParts[] = "Incident = :incident";
            $params['incident'] = $data['Incident'] ?? null;
        }

        $setParts[] = "LogDate = NOW()";
        $setParts[] = "EmployeeID = :eid";

        $sql = "UPDATE TourLog SET " . implode(', ', $setParts) . " WHERE LogID = :lid";
        $stmt = $conn->prepare($sql);
        return $stmt->execute($params);
    } else {
        // Thêm nhật ký mới
        $columns = ['TourID', 'EmployeeID', 'Note'];
        $placeholders = [':tid', ':eid', ':note'];
        $params = [
            'tid' => $data['TourID'],
            'eid' => $data['EmployeeID'],
            'note' => $data['Note']
        ];

        if ($hasImages) {
            $columns[] = 'Images';
            $placeholders[] = ':images';
            $params['images'] = $data['Images'] ?? null;
        }

        if ($hasIncident) {
            $columns[] = 'Incident';
            $placeholders[] = ':incident';
            $params['incident'] = $data['Incident'] ?? null;
        }

        $columns[] = 'LogDate';
        $placeholders[] = 'NOW()';

        $sql = "INSERT INTO TourLog (" . implode(', ', $columns) . ")
                VALUES (" . implode(', ', $placeholders) . ")";
        $stmt = $conn->prepare($sql);
        return $stmt->execute($params);
    }
}

function deleteTourLog($logId)
{
    $conn = connectDB();
    $log = getTourLogById($logId);
    if (!$log) return false;

    // Xóa file ảnh
    if (!empty($log['Images'])) {
        $images = json_decode($log['Images'], true);
        if (is_array($images)) {
            foreach ($images as $imgPath) {
                if (strpos($imgPath, BASE_URL) === 0) {
                    $filePath = str_replace(BASE_URL, './', $imgPath);
                    if (file_exists($filePath)) @unlink($filePath);
                }
            }
        }
    }
    $sql = "DELETE FROM TourLog WHERE LogID = :lid";
    $stmt = $conn->prepare($sql);
    return $stmt->execute(['lid' => $logId]);
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

// Tự động bổ sung các cột tuỳ chọn cho bảng TourLog nếu thiếu
function ensureTourLogOptionalColumns()
{
    $conn = connectDB();

    if (!tableExists('TourLog')) {
        return;
    }

    $columns = [
        'Images' => "ALTER TABLE TourLog ADD COLUMN Images TEXT NULL",
        'Incident' => "ALTER TABLE TourLog ADD COLUMN Incident TEXT NULL"
    ];

    foreach ($columns as $name => $alterSql) {
        try {
            $check = $conn->query("SHOW COLUMNS FROM TourLog LIKE '{$name}'");
            if ($check->rowCount() === 0) {
                $conn->exec($alterSql);
            }
        } catch (Exception $e) {
            // Bỏ qua nếu không thể thêm, hàm gọi sẽ hoạt động với các cột sẵn có
        }
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

function saveCheckInOut($data)
{
    $conn = connectDB();
    if (!ensureCheckInOutTable()) return false;

    try {
        $hasLocation = $conn->query("SHOW COLUMNS FROM TourCheckInOut LIKE 'Location'")->rowCount() > 0;
    } catch (Exception $e) { $hasLocation = false; }

    if ($hasLocation) {
        $sql = "INSERT INTO TourCheckInOut (TourID, EmployeeID, Type, Location, Note, CreatedAt)
                VALUES (:tid, :eid, :type, :location, :note, NOW())";
        return $conn->prepare($sql)->execute([
            'tid' => $data['TourID'],
            'eid' => $data['EmployeeID'],
            'type' => $data['Type'],
            'location' => $data['Location'] ?? null,
            'note' => $data['Note'] ?? null
        ]);
    } else {
        // Fallback cho DB cũ
        $sql = "INSERT INTO TourCheckInOut (TourID, EmployeeID, Type, Note, CreatedAt)
                VALUES (:tid, :eid, :type, :note, NOW())";
        $loc = trim($data['Location'] ?? '');
        $note = trim($data['Note'] ?? '');
        $combined = $loc ? "Địa điểm: $loc" . ($note ? " | $note" : "") : $note;
        return $conn->prepare($sql)->execute([
            'tid' => $data['TourID'],
            'eid' => $data['EmployeeID'],
            'type' => $data['Type'],
            'note' => $combined ?: null
        ]);
    }
}

function getCheckInOutHistory($tourId)
{
    $conn = connectDB();
    if (!tableExists('TourCheckInOut')) return [];

    try {
        $hasLocation = $conn->query("SHOW COLUMNS FROM TourCheckInOut LIKE 'Location'")->rowCount() > 0;
    } catch (Exception $e) { $hasLocation = false; }

    $selectFields = "cio.CheckInOutID, cio.Type, cio.Note, cio.CreatedAt";
    if ($hasLocation) {
        $selectFields .= ", cio.Location";
    }
    $selectFields .= ", e.FullName AS EmployeeName";

    $sql = "SELECT $selectFields FROM TourCheckInOut cio
            LEFT JOIN Employee e ON cio.EmployeeID = e.EmployeeID
            WHERE cio.TourID = :tid ORDER BY cio.CreatedAt DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['tid' => $tourId]);
    $rows = $stmt->fetchAll();

    if (!$hasLocation) {
        foreach ($rows as &$row) $row['Location'] = null;
    }
    return $rows;
}

function getCheckInOutById($entryId)
{
    $conn = connectDB();
    if (!tableExists('TourCheckInOut')) {
        return null;
    }
    // Xây dựng select động theo cột hiện có
    $select = ['CheckInOutID', 'TourID', 'EmployeeID', 'Type', 'Note', 'CreatedAt'];
    try {
        $hasLocation = $conn->query("SHOW COLUMNS FROM TourCheckInOut LIKE 'Location'")->rowCount() > 0;
        if ($hasLocation) { $select[] = 'Location'; }
    } catch (Exception $e) {}

    $sql = "SELECT " . implode(', ', $select) . " FROM TourCheckInOut WHERE CheckInOutID = :id LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $entryId]);
    $row = $stmt->fetch();
    if ($row && !isset($row['Location'])) { $row['Location'] = null; }
    return $row;
}

function deleteCheckInOutEntry($entryId)
{
    $conn = connectDB();
    if (!tableExists('TourCheckInOut')) {
        return false;
    }
    $sql = "DELETE FROM TourCheckInOut WHERE CheckInOutID = :id";
    $stmt = $conn->prepare($sql);
    return $stmt->execute(['id' => $entryId]);
}

// Lấy danh sách khách với thông tin yêu cầu đặc biệt (đọc từ cột Note dạng JSON)
function getCustomersWithSpecialRequests($tourId)
{
    $conn = connectDB();
    if (!tableExists('TourCheckInOut')) return null;
    
    $select = ['CheckInOutID', 'TourID', 'EmployeeID', 'Type', 'Note', 'CreatedAt'];
    try {
        if ($conn->query("SHOW COLUMNS FROM TourCheckInOut LIKE 'Location'")->rowCount() > 0) {
            $select[] = 'Location';
        }
    } catch (Exception $e) {}

    $sql = "SELECT " . implode(', ', $select) . " FROM TourCheckInOut WHERE CheckInOutID = :id LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $entryId]);
    $row = $stmt->fetch();
    if ($row && !isset($row['Location'])) $row['Location'] = null;
    return $row;
}

    // Parse JSON từ cột Note
    foreach ($results as &$row) {
        $noteJson = $row['Note'] ?? '';
        $specialData = null;

        // Thử parse JSON
        if (!empty($noteJson)) {
            $decoded = json_decode($noteJson, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $specialData = $decoded;
            }
        }

// =================================================================
// 5. HELPER FUNCTIONS
// =================================================================

function tableExists($tableName)
{
    $conn = connectDB();
    try {
        $stmt = $conn->prepare("SHOW TABLES LIKE :table");
        $stmt->execute(['table' => $tableName]);
        return $stmt->rowCount() > 0;
    } catch (Exception $e) { return false; }
}

// Tự động phân phòng cho các khách chưa có phòng, ghi nhận người phân phòng vào Note (JSON)
function autoAssignRooms($tourId, $employeeId)
{
    $conn = connectDB();

    try {
        $conn->beginTransaction();

        // Lấy số phòng lớn nhất (nếu có) để đánh số tiếp
        $stmt = $conn->prepare("SELECT MAX(CAST(RoomNumber AS UNSIGNED)) as maxRoom FROM TourCustomer WHERE TourID = :tid");
        $stmt->execute(['tid' => $tourId]);
        $maxRoom = (int)$stmt->fetchColumn();

        // Lấy danh sách khách chưa có RoomNumber
        $stmt = $conn->prepare("SELECT CustomerID, Note FROM TourCustomer WHERE TourID = :tid AND (RoomNumber IS NULL OR TRIM(RoomNumber) = '') ORDER BY CustomerID ASC");
        $stmt->execute(['tid' => $tourId]);
        $rows = $stmt->fetchAll();

        if (empty($rows)) {
            $conn->commit();
            return 0;
        }

        $assigned = 0;
        $updateStmt = $conn->prepare("UPDATE TourCustomer SET RoomNumber = :room, Note = :note WHERE TourID = :tid AND CustomerID = :cid");

        foreach ($rows as $r) {
            $maxRoom++;
            $room = (string)$maxRoom;

            // Preserve existing Note JSON keys and add assigned metadata
            $note = $r['Note'] ?? '';
            $decoded = null;
            if (!empty($note)) {
                $decoded = json_decode($note, true);
                if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
                    $decoded = ['note_text' => $note];
                }
            } else {
                $decoded = [];
            }

            $decoded['assigned'] = [
                'by' => $employeeId,
                'at' => date('c'),
                'method' => 'auto'
            ];

            $noteJson = json_encode($decoded, JSON_UNESCAPED_UNICODE);

            $ok = $updateStmt->execute([
                'room' => $room,
                'note' => $noteJson,
                'tid' => $tourId,
                'cid' => $r['CustomerID']
            ]);

            if ($ok) {
                $assigned++;
            }
        }

        $conn->commit();
        return $assigned;
    } catch (Exception $e) {
        try {
            $conn->rollBack();
        } catch (Exception $_) {
        }
        return 0;
    }
}

// Lưu & cập nhật yêu cầu đặc biệt (lưu vào cột Note của TourCustomer dạng JSON)
function saveSpecialRequest($data)
{
    $conn = connectDB();
    if (!tableExists('TourLog')) return;
    $columns = [
        'Images' => "ALTER TABLE TourLog ADD COLUMN Images TEXT NULL",
        'Incident' => "ALTER TABLE TourLog ADD COLUMN Incident TEXT NULL"
    ];

function ensureCheckInOutTable()
{
    $conn = connectDB();
    if (tableExists('TourCheckInOut')) return true;
    try {
        $sql = "CREATE TABLE IF NOT EXISTS `TourCheckInOut` (
          `CheckInOutID` INT(11) NOT NULL AUTO_INCREMENT,
          `TourID` INT(11) NOT NULL,
          `EmployeeID` INT(11) NOT NULL,
          `Type` ENUM('checkin','checkout') NOT NULL,
          `Note` TEXT NULL,
          `CreatedAt` DATETIME NOT NULL,
          PRIMARY KEY (`CheckInOutID`),
          INDEX `idx_tour` (`TourID`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $conn->exec($sql);
        // Add Location if needed later manually or handled by logic
        return true;
    } catch (Exception $e) { return false; }
}

function setCustomerAttendance($tourId, $customerId, $employeeId, $checked)
{
    $conn = connectDB();

    $stmt = $conn->prepare("SELECT Note FROM TourCustomer WHERE TourID = :tid AND CustomerID = :cid LIMIT 1");
    $stmt->execute(['tid' => $tourId, 'cid' => $customerId]);
    $current = $stmt->fetchColumn();

    $decoded = [];
    if (!empty($current)) {
        $tmp = json_decode($current, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($tmp)) {
            $decoded = $tmp;
        } else {
            $decoded = ['note_text' => $current];
        }
    }

    $decoded['attendance'] = [
        'checked' => $checked ? 1 : 0,
        'time' => date('c'),
        'by' => $employeeId
    ];

    $noteJson = json_encode($decoded, JSON_UNESCAPED_UNICODE);

    $update = $conn->prepare("UPDATE TourCustomer SET Note = :note WHERE TourID = :tid AND CustomerID = :cid");
    return $update->execute(['note' => $noteJson, 'tid' => $tourId, 'cid' => $customerId]);
}
