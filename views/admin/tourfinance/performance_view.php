<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/../navbar.php'; ?>

<div class="d-flex admin-layout">
    <div class="sidebar-wrapper bg-white shadow-sm border-end">
        <?php require_once __DIR__ . '/../sidebar.php'; ?>
    </div>

    <div class="admin-content flex-grow-1 p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Báo cáo hiệu quả Tour</h2>
                <p class="text-muted mb-0">Thống kê doanh thu – Lợi nhuận – Hiệu suất theo từng Tour</p>
            </div>
            <a href="<?= BASE_URL ?>?act=finance-report" class="btn btn-light border shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Quay lại
            </a>
        </div>

        <!-- Thống kê nhanh -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h5 class="text-secondary text-uppercase small fw-bold mb-3">Tỷ suất lợi nhuận trung bình</h5>
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-success-subtle text-success fw-bold d-flex align-items-center justify-content-center me-3"
                            style="width: 50px; height: 50px; font-size: 1.2rem;">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <p class="display-6 fw-bold text-success mb-0">
                            <?= number_format($avg_margin, 2) ?>%
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h5 class="text-secondary text-uppercase small fw-bold mb-3">Tỷ lệ lấp đầy trung bình</h5>
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center me-3"
                            style="width: 50px; height: 50px; font-size: 1.2rem;">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <p class="display-6 fw-bold text-primary mb-0">
                            <?= number_format($avg_occupancy, 2) ?>%
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bảng hiệu suất -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-secondary text-uppercase small fw-bold">Tour ID</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold">Doanh thu</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold">Lợi nhuận</th>
                                <th class="pe-4 py-3 text-secondary text-uppercase small fw-bold text-center">Hiệu suất</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($performance_data)): ?>
                                <?php foreach ($performance_data as $tour): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-primary">#<?= $tour['TourID'] ?></td>
                                        <td class="fw-medium text-dark"><?= number_format($tour['Revenue']) ?> VNĐ</td>
                                        <td class="fw-medium text-dark"><?= number_format($tour['Profit']) ?> VNĐ</td>

                                        <td class="text-center">
                                            <?php
                                            $badgeClass = $tour['ProfitMargin'] > 30
                                                ? 'bg-success-subtle text-success-emphasis'
                                                : 'bg-warning-subtle text-warning-emphasis';
                                            ?>
                                            <span class="badge rounded-pill <?= $badgeClass ?> px-3 py-2">
                                                <i class="bi bi-bar-chart-line me-1"></i>
                                                <?= number_format($tour['ProfitMargin'], 2) ?>%
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <div class="fs-1 mb-2"><i class="bi bi-inbox"></i></div>
                                        Không có dữ liệu hiệu suất Tour
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