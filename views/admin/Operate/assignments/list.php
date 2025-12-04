<?php
// Nhóm tour theo Category
$grouped = [];
if (!empty($tours) && is_array($tours)) {
    foreach ($tours as $tour) {
        $grouped[$tour['CategoryName']][] = $tour;
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/../../navbar.php'; ?>

<div class="d-flex admin-layout">
    <div class="sidebar-wrapper bg-white shadow-sm border-end">
        <?php require_once __DIR__ . '/../../sidebar.php'; ?>
    </div>

    <div class="admin-content flex-grow-1 p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Lịch trình & Điều hành</h2>
                <p class="text-muted mb-0">Quản lý lịch khởi hành và phân công nhân sự.</p>
            </div>
        </div>

        <?php if (!empty($grouped)): ?>
        <?php foreach ($grouped as $categoryName => $tourList): ?>

        <div class="category-section mb-5">
            <h5 class="category-title text-primary d-flex align-items-center mb-3">
                <span class="bg-primary-subtle text-primary rounded p-2 me-2">
                    <i class="bi bi-folder2-open"></i>
                </span>
                <?= htmlspecialchars($categoryName) ?>
            </h5>

            <div class="row g-4">
                <?php foreach ($tourList as $tour): ?>
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden tour-schedule-card">
                        <div class="card-body p-4 d-flex flex-column">

                            <h5 class="card-title fw-bold text-dark mb-3">
                                <?= htmlspecialchars($tour['TourName']) ?>
                            </h5>

                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2 text-secondary small">
                                    <i class="bi bi-building me-2 text-primary"></i>
                                    <span>NCC: <span
                                            class="fw-medium text-dark"><?= htmlspecialchars($tour['SupplierName'] ?? 'Không có') ?></span></span>
                                </div>
                                <div class="d-flex align-items-center mb-2 text-secondary small">
                                    <i class="bi bi-cash-stack me-2 text-success"></i>
                                    <span>Giá: <span
                                            class="fw-bold text-success"><?= number_format($tour['Price'], 0, ',', '.') ?>
                                            đ</span></span>
                                </div>
                            </div>

                            <div class="bg-light rounded-3 p-3 mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted text-uppercase fw-bold">Khởi hành</small>
                                    <span class="badge bg-white text-primary border shadow-sm">
                                        <?= date('d/m/Y', strtotime($tour['StartDate'])) ?>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted text-uppercase fw-bold">Kết thúc</small>
                                    <span class="badge bg-white text-danger border shadow-sm">
                                        <?= date('d/m/Y', strtotime($tour['EndDate'])) ?>
                                    </span>
                                </div>
                            </div>

                            <div class="mt-auto d-grid gap-2 d-md-flex">
                                <a href="<?= BASE_URL ?>?act=hdv-detail&id=<?= $tour['CategoryID'] ?>"
                                    class="btn btn-light border text-primary fw-medium flex-grow-1">
                                    <i class="bi bi-people me-1"></i> Chi tiết đoàn
                                </a>
                                <a href="?act=operate-tour&id=<?= $tour['TourID'] ?>"
                                    class="btn btn-warning fw-bold text-dark flex-grow-1 shadow-sm">
                                    <i class="bi bi-gear-fill me-1"></i> Điều hành
                                </a>
                            </div>

                        </div>
                        <div class="card-border-left bg-primary position-absolute start-0 top-0 bottom-0"
                            style="width: 4px;"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php endforeach; ?>
        <?php else: ?>
        <div class="text-center py-5">
            <div class="mb-3 text-muted"><i class="bi bi-calendar-x fs-1"></i></div>
            <h5 class="text-muted">Chưa có lịch trình tour nào</h5>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
/* Layout */
:root {
    --header-height: 70px;
    --sidebar-width: 260px;
}

body {
    background-color: #f5f7fa;
    font-family: 'Segoe UI', sans-serif;
    padding-top: var(--header-height);
}

.sidebar-wrapper {
    width: var(--sidebar-width);
    position: fixed;
    top: var(--header-height);
    bottom: 0;
    left: 0;
    z-index: 100;
    overflow-y: auto;
}

.admin-content {
    margin-left: var(--sidebar-width);
    min-height: calc(100vh - var(--header-height));
}

/* Card Style */
.tour-schedule-card {
    transition: transform 0.2s, box-shadow 0.2s;
    position: relative;
}

.tour-schedule-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
}

/* Responsive */
@media (max-width: 992px) {
    .sidebar-wrapper {
        margin-left: calc(var(--sidebar-width) * -1);
    }

    .admin-content {
        margin-left: 0;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>