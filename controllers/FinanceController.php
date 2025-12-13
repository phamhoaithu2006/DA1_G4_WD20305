<?php
// controllers/FinanceController.php

class FinanceController
{
    private $model;

    public function __construct($db)
    {
        $this->model = new FinanceModel($db);
    }

    // --- CÁC HÀM CŨ GIỮ NGUYÊN ---
    public function index()
    {
        $finance_data = $this->model->getAllFinanceData();
        $summary = $this->model->getFinanceSummary();
        include PATH_ROOT . 'views/admin/tourfinance/report_index_view.php';
    }

    public function performanceReport()
    {
        $avg_margin = $this->model->getAverageProfitMargin();
        $performance_data = $this->model->getAllFinanceData();
        $avg_occupancy = 0.00;
        include PATH_ROOT . 'views/admin/tourfinance/performance_view.php';
    }

    public function detail($tourID)
    {
        if (!$tourID) {
            header('Location: ?act=finance-report');
            exit;
        }
        $detail_data = $this->model->getFinanceByTourID($tourID);
        include PATH_ROOT . 'views/admin/tourfinance/report_detail_view.php';
    }

    // --- CHỨC NĂNG MỚI: SO SÁNH HIỆU QUẢ ---
    public function compare()
    {
        // 1. Lấy tham số filter (Mặc định Quý và Năm nay)
        $type = $_GET['type'] ?? 'quarter';
        $year = $_GET['year'] ?? date('Y');

        // 2. Gọi Model lấy dữ liệu
        $comparison_data = $this->model->getComparisonData($type, $year);

        // 3. Chuẩn bị dữ liệu cho Biểu đồ ChartJS
        $chartLabels = [];
        $chartRevenue = [];
        $chartProfit = [];

        if (!empty($comparison_data)) {
            foreach ($comparison_data as $item) {
                // Nhãn: Tên Tour (Thời gian)
                $chartLabels[] = $item['TourName'] . " (" . $item['TimeLabel'] . ")";
                $chartRevenue[] = $item['TotalRevenue'];
                $chartProfit[] = $item['TotalProfit'];
            }
        }

        // 4. Load View mới
        include PATH_ROOT . 'views/admin/tourfinance/compare_view.php';
    }
}
