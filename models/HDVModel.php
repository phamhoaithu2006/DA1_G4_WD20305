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

    foreach ($rows as &$r) {
        $checked = 0;
        if (!empty($r['Note'])) {
            $note = json_decode($r['Note'], true);
            if (is_array($note) && isset($note['attendance']) && isset($note['attendance']['checked'])) {
                $checked = (int)$note['attendance']['checked'] === 1 ? 1 : 0;
            }
        }
        $r['AttendanceChecked'] = $checked;
    }
    return $rows;
}

// Lấy danh sách khách kèm thông tin Yêu cầu đặc biệt (Parse JSON)
function getCustomersWithSpecialRequests($tourId)
{
    $conn = connectDB();
    $sql = "SELECT c.CustomerID, c.FullName, c.Email, c.Phone, 
                   tc.RoomNumber, tc.Note
            FROM TourCustomer tc
            JOIN Customer c ON tc.CustomerID = c.CustomerID
            WHERE tc.TourID = :tid";

    $stmt = $conn->prepare($sql);
    $stmt->execute(['tid' => $tourId]);
    $results = $stmt->fetchAll();

    foreach ($results as &$row) {
        $noteJson = $row['Note'] ?? '';
        $data = [];
        if (!empty($noteJson)) {
            $decoded = json_decode($noteJson, true);
            $data = is_array($decoded) ? $decoded : [];
        }

        // Lấy dữ liệu từ mảng JSON
        $row['Vegetarian'] = $data['vegetarian'] ?? 0;
        $row['MedicalCondition'] = $data['medical_condition'] ?? '';
        $row['OtherRequests'] = $data['other_requests'] ?? '';
        $row['SpecialRequests'] = $data['special_requests'] ?? ''; // Ghi chú chung
    }
    return $results;
}

// [QUAN TRỌNG] Cập nhật thông tin khách & Yêu cầu đặc biệt (Merge JSON để không mất điểm danh)
function updateCustomerInfoAndRequests($data) {
    $conn = connectDB();

    // 1. Cập nhật thông tin cơ bản trong bảng Customer (SĐT, Tên)
    if (isset($data['FullName']) || isset($data['Phone'])) {
        $sqlCust = "UPDATE Customer SET FullName = :name, Phone = :phone WHERE CustomerID = :cid";
        $stmtCust = $conn->prepare($sqlCust);
        $stmtCust->execute([
            'name' => $data['FullName'],
            'phone' => $data['Phone'],
            'cid' => $data['CustomerID']
        ]);
    }

    // 2. Cập nhật RoomNumber trong TourCustomer
    if (isset($data['RoomNumber'])) {
        $sqlRoom = "UPDATE TourCustomer SET RoomNumber = :room WHERE TourID = :tid AND CustomerID = :cid";
        $stmtRoom = $conn->prepare($sqlRoom);
        $stmtRoom->execute([
            'room' => $data['RoomNumber'],
            'tid' => $data['TourID'],
            'cid' => $data['CustomerID']
        ]);
    }

    // 3. Xử lý JSON Note (Lấy cũ -> Gộp mới -> Lưu lại)
    $stmtGet = $conn->prepare("SELECT Note FROM TourCustomer WHERE TourID = :tid AND CustomerID = :cid LIMIT 1");
    $stmtGet->execute(['tid' => $data['TourID'], 'cid' => $data['CustomerID']]);
    $currentNote = $stmtGet->fetchColumn();

    $jsonArr = [];
    if (!empty($currentNote)) {
        $decoded = json_decode($currentNote, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $jsonArr = $decoded;
        } else {
             // Nếu note cũ là text thường (dữ liệu cũ), lưu nó lại
             $jsonArr = ['old_text_note' => $currentNote];
        }
    }

    // Cập nhật các trường yêu cầu đặc biệt
    $jsonArr['vegetarian'] = isset($data['Vegetarian']) ? (int)$data['Vegetarian'] : ($jsonArr['vegetarian'] ?? 0);
    $jsonArr['medical_condition'] = $data['MedicalCondition'] ?? ($jsonArr['medical_condition'] ?? '');
    $jsonArr['other_requests'] = $data['OtherRequests'] ?? ($jsonArr['other_requests'] ?? '');
    $jsonArr['special_requests'] = $data['SpecialRequests'] ?? ($jsonArr['special_requests'] ?? '');

    $newNoteJson = json_encode($jsonArr, JSON_UNESCAPED_UNICODE);
    
    $sqlUpdate = $conn->prepare("UPDATE TourCustomer SET Note = :note WHERE TourID = :tid AND CustomerID = :cid");
    return $sqlUpdate->execute([
        'note' => $newNoteJson,
        'tid' => $data['TourID'],
        'cid' => $data['CustomerID']
    ]);
}

// [QUAN TRỌNG] Điểm danh (Merge JSON)
function setCustomerAttendance($tourId, $customerId, $employeeId, $checked)
{
    $conn = connectDB();

    // Lấy Note hiện tại
    $stmt = $conn->prepare("SELECT Note FROM TourCustomer WHERE TourID = :tid AND CustomerID = :cid LIMIT 1");
    $stmt->execute(['tid' => $tourId, 'cid' => $customerId]);
    $current = $stmt->fetchColumn();

    $decoded = [];
    if (!empty($current)) {
        $tmp = json_decode($current, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($tmp)) {
            $decoded = $tmp;
        } else {
            $decoded = ['old_text_note' => $current];
        }
    }

    // Cập nhật trạng thái điểm danh
    $decoded['attendance'] = [
        'checked' => $checked ? 1 : 0,
        'time' => date('Y-m-d H:i:s'),
        'by' => $employeeId
    ];

    $noteJson = json_encode($decoded, JSON_UNESCAPED_UNICODE);

    $update = $conn->prepare("UPDATE TourCustomer SET Note = :note WHERE TourID = :tid AND CustomerID = :cid");
    return $update->execute(['note' => $noteJson, 'tid' => $tourId, 'cid' => $customerId]);
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

    // Check optional columns
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

    try {
        $hasImages = $conn->query("SHOW COLUMNS FROM TourLog LIKE 'Images'")->rowCount() > 0;
        $hasIncident = $conn->query("SHOW COLUMNS FROM TourLog LIKE 'Incident'")->rowCount() > 0;
    } catch (Exception $e) { $hasImages = false; $hasIncident = false; }

    if (!empty($data['LogID'])) {
        // UPDATE
        $setParts = ["Note = :note", "LogDate = NOW()", "EmployeeID = :eid"];
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
        $sql = "UPDATE TourLog SET " . implode(', ', $setParts) . " WHERE LogID = :lid";
        $stmt = $conn->prepare($sql);
        return $stmt->execute($params);
    } else {
        // INSERT
        $columns = ['TourID', 'EmployeeID', 'Note', 'LogDate'];
        $placeholders = [':tid', ':eid', ':note', 'NOW()'];
        $params = [
            'tid' => $data['TourID'],
            'eid' => $data['EmployeeID'],
            'note' => $data['Note']
        ];
        if ($hasImages) {
            $columns[] = 'Images'; $placeholders[] = ':images';
            $params['images'] = $data['Images'] ?? null;
        }
        if ($hasIncident) {
            $columns[] = 'Incident'; $placeholders[] = ':incident';
            $params['incident'] = $data['Incident'] ?? null;
        }
        $sql = "INSERT INTO TourLog (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";
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

// =================================================================
// 4. CHECK-IN / CHECK-OUT SYSTEM
// =================================================================

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

    $selectFields = "cio.Type, cio.Note, cio.CreatedAt, e.FullName AS EmployeeName";
    if ($hasLocation) $selectFields .= ", cio.Location";

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

function deleteCheckInOutEntry($entryId)
{
    $conn = connectDB();
    if (!tableExists('TourCheckInOut')) return false;
    $sql = "DELETE FROM TourCheckInOut WHERE CheckInOutID = :id";
    $stmt = $conn->prepare($sql);
    return $stmt->execute(['id' => $entryId]);
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

function ensureTourLogOptionalColumns()
{
    $conn = connectDB();
    if (!tableExists('TourLog')) return;
    $columns = [
        'Images' => "ALTER TABLE TourLog ADD COLUMN Images TEXT NULL",
        'Incident' => "ALTER TABLE TourLog ADD COLUMN Incident TEXT NULL"
    ];
    foreach ($columns as $name => $alterSql) {
        try {
            if ($conn->query("SHOW COLUMNS FROM TourLog LIKE '{$name}'")->rowCount() === 0) {
                $conn->exec($alterSql);
            }
        } catch (Exception $e) {}
    }
}

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
?>