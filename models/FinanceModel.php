<?php
// models/FinanceModel.php

class FinanceModel
{
    private $conn;

    public function __construct($db)
    {
        // $db là đối tượng PDO được truyền từ index.php
        $this->conn = $db;
    }

    /**
     * Lấy dữ liệu tài chính chi tiết của TẤT CẢ các Tour.
     * Dùng PDO::query() cho các truy vấn SELECT không có tham số.
     * @return array
     */
    public function getAllFinanceData()
    {
        $sql = "
            SELECT
                FinanceID,
                TourID,
                Revenue,
                Expense,
                Profit,
                (Profit / Revenue) * 100 AS ProfitMargin
            FROM
                tourfinance
            ORDER BY TourID ASC
        ";

        // SỬ DỤNG PHƯƠNG THỨC PDO::query() THAY VÌ mysqli_query()
        $stmt = $this->conn->query($sql);

        // SỬ DỤNG PHƯƠNG THỨC PDO::fetchAll() THAY VÌ mysqli_fetch_assoc()
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    /**
     * Lấy báo cáo tổng hợp (Tổng Revenue, Expense, Profit).
     * @return array|null
     */
    public function getFinanceSummary()
    {
        $sql = "
            SELECT
                SUM(Revenue) AS TotalRevenue,
                SUM(Expense) AS TotalExpense,
                SUM(Profit) AS TotalProfit
            FROM
                tourfinance
        ";

        $stmt = $this->conn->query($sql);

        // SỬ DỤNG PDO::fetch()
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy dữ liệu chi tiết của một Tour cụ thể (Sử dụng Prepared Statement)
     * @param int $tourID
     * @return array|null
     */
    public function getFinanceByTourID($tourID)
    {
        if (!$tourID) {
            return null;
        }
        $sql = "
            SELECT
                FinanceID,
                TourID,
                Revenue,
                Expense,
                Profit,
                (Profit / Revenue) * 100 AS ProfitMargin
            FROM
                tourfinance
            WHERE TourID = :tourID
        ";

        // 1. CHUẨN BỊ TRUY VẤN
        $stmt = $this->conn->prepare($sql);

        // 2. GÁN THAM SỐ
        $stmt->bindParam(':tourID', $tourID, PDO::PARAM_INT);

        // 3. THỰC THI
        $stmt->execute();

        // 4. LẤY KẾT QUẢ
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // models/FinanceModel.php (Bổ sung thêm hàm này)

    /**
     * Tính toán Tỷ suất Lợi nhuận Trung bình của tất cả các Tour
     * @return float
     */
    public function getAverageProfitMargin()
    {
        $sql = "
            SELECT
                SUM(Profit) AS TotalProfit,
                SUM(Revenue) AS TotalRevenue
            FROM
                tourfinance
        ";

        $stmt = $this->conn->query($sql); // Dùng PDO::query()
        $summary = $stmt->fetch(PDO::FETCH_ASSOC);

        $total_profit = $summary['TotalProfit'] ?? 0;
        $total_revenue = $summary['TotalRevenue'] ?? 0;

        if ($total_revenue > 0) {
            // Tỷ suất lợi nhuận trung bình toàn hệ thống (Tổng LN / Tổng DT)
            return ($total_profit / $total_revenue) * 100;
        } else {
            return 0.00;
        }
    }

    // models/FinanceModel.php

    public function getComparisonData($periodType, $year)
    {
        // ===> THÊM DÒNG NÀY ĐỂ FIX LỖI 1055 <===
        // Tắt chế độ ONLY_FULL_GROUP_BY chỉ cho phiên làm việc này
        $this->conn->exec("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");

        // --- Code cũ giữ nguyên bên dưới ---
        $groupBy = "";
        $selectLabel = "";

        if ($periodType === 'quarter') {
            $groupBy = "QUARTER(tf.FinanceDate)";
            $selectLabel = "CONCAT('Quý ', QUARTER(tf.FinanceDate))";
        } elseif ($periodType === 'month') {
            $groupBy = "MONTH(tf.FinanceDate)";
            $selectLabel = "CONCAT('Tháng ', MONTH(tf.FinanceDate))";
        } else {
            $groupBy = "YEAR(tf.FinanceDate)";
            $selectLabel = "YEAR(tf.FinanceDate)";
        }

        $sql = "SELECT 
                    t.TourName,
                    $selectLabel as TimeLabel,
                    SUM(tf.Revenue) as TotalRevenue,
                    SUM(tf.Profit) as TotalProfit,
                    (SUM(tf.Profit) / SUM(tf.Revenue) * 100) as ProfitMargin
                FROM tourfinance tf
                JOIN tour t ON tf.TourID = t.TourID
                WHERE YEAR(tf.FinanceDate) = :year
                GROUP BY t.TourName, $groupBy
                ORDER BY TotalProfit DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':year' => $year]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
