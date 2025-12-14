<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php
// Yêu cầu các file layout chung từ thư mục gốc
// PATH_ROOT đã được định nghĩa trong env.php
require_once PATH_ROOT . 'views/admin/navbar.php';
?>

<div class="d-flex admin-layout">
    <div class="sidebar-wrapper bg-white shadow-sm border-end">
        <?php
        require_once PATH_ROOT . 'views/admin/sidebar.php';
        ?>
    </div>

    <div class="admin-content flex-grow-1 p-4">

        <!-- TIÊU ĐỀ TRANG -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Báo cáo tài chính tổng quan</h2>
                <p class="text-muted mb-0">Xem tổng kết doanh thu, chi phí và lợi nhuận toàn hệ thống</p>
            </div>
            <a href="?act=tour-performance" class="btn btn-primary shadow-sm">
                <i class="bi bi-speedometer2 me-1"></i> Xem báo cáo hiệu quả Tour
            </a>
        </div>

        <!-- KHỐI 1: TỔNG KẾT TÀI CHÍNH (SUMMARY CARDS) -->
        <h3 class="fw-bold text-dark mb-3">Tổng kết hệ thống</h3>
        <?php if ($summary): ?>
            <div class="row g-4 mb-5">

                <!-- Tổng Doanh Thu -->
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-info-subtle border-start border-5 border-info">
                        <div class="card-body p-0">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="text-info-emphasis fw-bold mb-1 text-uppercase small">Tổng doanh thu</p>
                                    <h3 class="fw-bold text-dark mb-0">
                                        <?php echo number_format($summary['TotalRevenue'], 0, ',', '.'); ?> ₫
                                    </h3>
                                </div>
                                <div class="fs-2 text-info-emphasis opacity-50">
                                    <i class="bi bi-wallet2"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tổng Chi Phí (Tạm thời giả định có biến TotalExpense trong $summary) -->
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-warning-subtle border-start border-5 border-warning">
                        <div class="card-body p-0">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="text-warning-emphasis fw-bold mb-1 text-uppercase small">Tổng chi phí</p>
                                    <h3 class="fw-bold text-dark mb-0">
                                        <?php
                                        // Tính toán Tổng Chi Phí: Tổng DT - Tổng LN
                                        $totalExpense = $summary['TotalRevenue'] - $summary['TotalProfit'];
                                        echo number_format($totalExpense, 0, ',', '.');
                                        ?> ₫
                                    </h3>
                                </div>
                                <div class="fs-2 text-warning-emphasis opacity-50">
                                    <i class="bi bi-receipt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tổng Lợi Nhuận -->
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-success-subtle border-start border-5 border-success">
                        <div class="card-body p-0">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="text-success-emphasis fw-bold mb-1 text-uppercase small">Tổng lợi nhuận</p>
                                    <h3 class="fw-bold text-dark mb-0">
                                        <?php echo number_format($summary['TotalProfit'], 0, ',', '.'); ?> ₫
                                    </h3>
                                </div>
                                <div class="fs-2 text-success-emphasis opacity-50">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        <?php endif; ?>

        <!-- KHỐI 2: CHI TIẾT LỢI NHUẬN TỪNG TOUR (DETAIL TABLE) -->
        <h3 class="fw-bold text-dark mb-3">Chi tiết lợi nhuận theo Tour</h3>
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-secondary text-uppercase small fw-bold">Tour ID</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold text-end">Doanh thu</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold text-end">Chi phí</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold text-end">Lợi nhuận</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold text-center">Tỷ suất lợi nhuận</th>
                                <th class="pe-4 py-3 text-secondary text-uppercase small fw-bold text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($finance_data)): ?>
                                <?php foreach ($finance_data as $tour): ?>
                                    <?php
                                    $profitMargin = ($tour['Revenue'] > 0) ? ($tour['Profit'] / $tour['Revenue']) * 100 : 0;

                                    // Logic màu sắc hiệu suất
                                    $marginClass = 'bg-danger-subtle text-danger-emphasis';
                                    if ($profitMargin >= 30) {
                                        $marginClass = 'bg-success-subtle text-success-emphasis';
                                    } elseif ($profitMargin >= 15) {
                                        $marginClass = 'bg-warning-subtle text-warning-emphasis';
                                    }
                                    ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-primary">#<?= $tour['TourID'] ?></td>

                                        <td class="text-end text-dark"><?php echo number_format($tour['Revenue'], 0, ',', '.'); ?> ₫</td>
                                        <td class="text-end text-muted"><?php echo number_format($tour['Expense'], 0, ',', '.'); ?> ₫</td>

                                        <td class="text-end fw-bold text-dark">
                                            <?php echo number_format($tour['Profit'], 0, ',', '.'); ?> ₫
                                        </td>

                                        <td class="text-center">
                                            <span class="badge rounded-pill <?= $marginClass ?> px-3 py-2 border border-opacity-10">
                                                <i class="bi bi-percent me-1"></i>
                                                <?php echo number_format($profitMargin, 2, ',', '.'); ?>%
                                            </span>
                                        </td>

                                        <td class="text-center pe-4">
                                            <a href="<?= BASE_URL ?>?act=finance-detail&tourID=<?php echo $tour['TourID']; ?>"
                                                class="btn btn-sm btn-light border text-primary shadow-sm"
                                                data-bs-toggle="tooltip" title="Xem chi tiết">
                                                Xem chi tiết <i class="bi bi-arrow-right ms-1"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <div class="fs-1 text-light-emphasis mb-2"><i class="bi bi-table"></i></div>
                                        Không có dữ liệu tài chính chi tiết
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>