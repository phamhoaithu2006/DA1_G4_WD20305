<?php
// commons/Database.php - Lớp quản lý kết nối CSDL (Singleton)

class Database
{
    private $conn;

    // Biến static để lưu trữ instance duy nhất của class
    private static $instance = null;

    // Ngăn chặn việc tạo đối tượng mới trực tiếp bên ngoài class
    private function __construct()
    {
        $this->connect();
    }

    // Phương thức để thiết lập kết nối PDO
    private function connect()
    {
        $this->conn = null;

        try {
            // SỬ DỤNG CÁC HẰNG SỐ ĐƯỢC KHAI BÁO TRONG env.php
            $host = DB_HOST;
            $db_name = DB_NAME;
            $username = DB_USERNAME;
            $password = DB_PASSWORD;
            // $port = DB_PORT; // Thường không cần thiết trừ khi khác 3306

            $dsn = "mysql:host={$host};dbname={$db_name};charset=utf8";

            $this->conn = new PDO($dsn, $username, $password);

            // Thiết lập chế độ xử lý lỗi và fetch mặc định
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            echo "Lỗi kết nối CSDL: " . $exception->getMessage();
            $this->conn = null;
        }
    }

    /**
     * Lấy instance duy nhất của class Database (Singleton Pattern).
     * @return Database
     */
    public static function getInstance(): Database
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Lấy đối tượng kết nối PDO.
     * @return PDO|null
     */
    public function getConnection(): ?PDO
    {
        return $this->conn;
    }
}
