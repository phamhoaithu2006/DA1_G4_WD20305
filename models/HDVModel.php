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

// Lấy nhật ký tour
// Trả về mảng
function getTourLogs($tourId)
{
    $conn = connectDB();

    ensureTourLogOptionalColumns();

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

    ensureTourLogOptionalColumns();

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

    ensureTourLogOptionalColumns();

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

// Xóa nhật ký tour
function deleteTourLog($logId)
{
    $conn = connectDB();

    // Lấy thông tin log trước khi xóa để xóa file ảnh
    $log = getTourLogById($logId);
    if (!$log) {
        return false;
    }

    // Xóa file ảnh nếu có
    if (!empty($log['Images'])) {
        $images = json_decode($log['Images'], true);
        if (is_array($images)) {
            foreach ($images as $imgPath) {
                // Chuyển URL thành đường dẫn file
                if (strpos($imgPath, BASE_URL) === 0) {
                    $filePath = str_replace(BASE_URL, './', $imgPath);
                    if (file_exists($filePath)) {
                        @unlink($filePath);
                    }
                }
            }
        }
    }

    // Xóa record trong database
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
        if ($hasLocation) {
            $select[] = 'Location';
        }
    } catch (Exception $e) {
    }

    $sql = "SELECT " . implode(', ', $select) . " FROM TourCheckInOut WHERE CheckInOutID = :id LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $entryId]);
    $row = $stmt->fetch();
    if ($row && !isset($row['Location'])) {
        $row['Location'] = null;
    }
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

    $sql = "SELECT c.CustomerID, c.FullName, c.Email, c.Phone, 
                   tc.RoomNumber, tc.Note
            FROM TourCustomer tc
            JOIN Customer c ON tc.CustomerID = c.CustomerID
            WHERE tc.TourID = :tid";

    $stmt = $conn->prepare($sql);
    $stmt->execute(['tid' => $tourId]);
    $results = $stmt->fetchAll();

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

        // Gán giá trị mặc định nếu không có dữ liệu
        $row['Vegetarian'] = $specialData['vegetarian'] ?? 0;
        $row['MedicalCondition'] = $specialData['medical_condition'] ?? null;
        $row['OtherRequests'] = $specialData['other_requests'] ?? null;
        $row['SpecialRequests'] = $specialData['special_requests'] ?? null;
    }

    return $results;
}

// Lưu & cập nhật yêu cầu đặc biệt (lưu vào cột Note của TourCustomer dạng JSON)
function saveSpecialRequest($data)
{
    $conn = connectDB();

    // Tạo object chứa thông tin yêu cầu đặc biệt
    $specialRequestData = [
        'vegetarian' => $data['Vegetarian'] ?? 0,
        'medical_condition' => $data['MedicalCondition'] ?? null,
        'other_requests' => $data['OtherRequests'] ?? null,
        'special_requests' => $data['SpecialRequests'] ?? null
    ];

    // Chuyển thành JSON
    $noteJson = json_encode($specialRequestData, JSON_UNESCAPED_UNICODE);

    // Cập nhật vào cột Note của bảng TourCustomer
    $sql = "UPDATE TourCustomer 
            SET Note = :note
            WHERE TourID = :tid AND CustomerID = :cid";

    $stmt = $conn->prepare($sql);
    return $stmt->execute([
        'note' => $noteJson,
        'tid' => $data['TourID'],
        'cid' => $data['CustomerID']
    ]);
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

// Gán phòng cho một khách (dùng khi HDV nhập tay)
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

// Lấy danh sách phòng đã phân trong tour (mảng room => [customerIds])
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
