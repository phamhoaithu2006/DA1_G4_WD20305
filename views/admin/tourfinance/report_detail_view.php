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
                <h2 class="fw-bold text-dark mb-1">
                    Chi tiết tài chính Tour #<?= $tourID ?>
                </h2>
                <p class="text-muted mb-0">Bảng tổng quan doanh thu, chi phí và lợi nhuận của Tour</p>
            </div>

            <a href="<?= BASE_URL ?>?act=finance-report" class="btn btn-light border shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Quay lại
            </a>
        </div>

        <!-- Nội dung chính -->
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <?php if ($detail_data): ?>

                <div class="row g-4">

                    <div class="col-md-6">
                        <div class="card border-0 bg-light rounded-4 p-4 h-100 shadow-sm">
                            <h6 class="text-secondary text-uppercase small fw-bold mb-2">Doanh thu</h6>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-3"
                                    style="width: 55px; height: 55px; font-size: 1.4rem;">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                                <p class="display-6 fw-bold mb-0">
                                    <?= number_format($detail_data['Revenue'], 0, ',', '.') ?> VNĐ
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-0 bg-light rounded-4 p-4 h-100 shadow-sm">
                            <h6 class="text-secondary text-uppercase small fw-bold mb-2">Chi phí</h6>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center me-3"
                                    style="width: 55px; height: 55px; font-size: 1.4rem;">
                                    <i class="bi bi-wallet2"></i>
                                </div>
                                <p class="display-6 fw-bold mb-0">
                                    <?= number_format($detail_data['Expense'], 0, ',', '.') ?> VNĐ
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-0 bg-light rounded-4 p-4 h-100 shadow-sm">
                            <h6 class="text-secondary text-uppercase small fw-bold mb-2">Lợi Nhuận</h6>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center me-3"
                                    style="width: 55px; height: 55px; font-size: 1.4rem;">
                                    <i class="bi bi-graph-up-arrow"></i>
                                </div>
                                <p class="display-6 fw-bold mb-0">
                                    <?= number_format($detail_data['Profit'], 0, ',', '.') ?> VNĐ
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <?php
                        $percentClass = $detail_data['ProfitMargin'] >= 30
                            ? 'bg-success-subtle text-success-emphasis'
                            : 'bg-warning-subtle text-warning-emphasis';
                        ?>
                        <div class="card border-0 <?= $percentClass ?> rounded-4 p-4 h-100 shadow-sm">
                            <h6 class="text-uppercase small fw-bold mb-2">Tỷ suất lợi nhuận</h6>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                    style="width: 55px; height: 55px; font-size: 1.4rem;">
                                    <i class="bi bi-percent"></i>
                                </div>
                                <p class="display-6 fw-bold mb-0">
                                    <?= number_format($detail_data['ProfitMargin'], 2, ',', '.') ?>%
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

            <?php else: ?>
                <div class="text-center py-5">
                    <div class="fs-1 text-muted mb-3"><i class="bi bi-question-circle"></i></div>
                    <p class="text-muted">Không tìm thấy dữ liệu tài chính cho Tour ID #<?= $tourID ?></p>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>