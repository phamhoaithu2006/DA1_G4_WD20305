<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/../navbar.php'; ?>

<div class="d-flex admin-layout">
    <div class="sidebar-wrapper bg-white shadow-sm border-end">
        <?php require_once __DIR__ . '/../sidebar.php'; ?>
    </div>

    <div class="admin-content flex-grow-1 p-4" style="background-color: #f8f9fa;">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">Báo cáo & Chất lượng</h4>
                <p class="text-muted mb-0">Theo dõi phản hồi khách hàng và đánh giá hiệu suất nhân sự</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-secondary small fw-bold text-uppercase">Mã Tour</th>
                                <th class="py-3 text-secondary small fw-bold text-uppercase">Tên Tour</th>
                                <th class="py-3 text-secondary small fw-bold text-uppercase">Thời gian</th>
                                <th class="py-3 text-secondary small fw-bold text-uppercase">Trạng thái</th>
                                <th class="text-end pe-4 py-3 text-secondary small fw-bold text-uppercase">Hành động
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($tours)): ?>
                                <?php foreach ($tours as $t):
                                    $isFinished = strtotime($t['EndDate']) < time();
                                    $statusBadge = $isFinished
                                        ? '<span class="badge bg-success-subtle text-success border border-success-subtle">Đã hoàn thành</span>'
                                        : '<span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle">Đang vận hành</span>';
                                ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-secondary">#<?= $t['TourID'] ?></td>
                                        <td>
                                            <div class="fw-bold text-dark"><?= htmlspecialchars($t['TourName']) ?></div>
                                            <small
                                                class="text-muted"><?= htmlspecialchars($t['SupplierName'] ?? 'Tự tổ chức') ?></small>
                                        </td>
                                        <td>
                                            <div class="small">
                                                <i class="bi bi-calendar-event me-1 text-muted"></i>
                                                <?= date('d/m/Y', strtotime($t['StartDate'])) ?>
                                                <i class="bi bi-arrow-right mx-1 text-muted"></i>
                                                <?= date('d/m/Y', strtotime($t['EndDate'])) ?>
                                            </div>
                                        </td>
                                        <td><?= $statusBadge ?></td>
                                        <td class="text-end pe-4">
                                            <a href="?act=tour-report&id=<?= $t['TourID'] ?>"
                                                class="btn btn-sm btn-primary shadow-sm fw-bold">
                                                <i class="bi bi-clipboard-data me-1"></i> Xem báo cáo
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">Chưa có dữ liệu tour</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>