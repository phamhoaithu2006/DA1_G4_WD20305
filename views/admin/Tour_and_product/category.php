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

<?php require_once __DIR__ . '/../navbar.php'; ?>

<div class="d-flex admin-layout">

    <!-- Sidebar -->
    <div class="sidebar-wrapper bg-light border-end">
        <?php require_once __DIR__ . '/../sidebar.php'; ?>
    </div>

    <!-- Content -->
    <div class="admin-content flex-grow-1 p-4">
        <h2 class="page-title">Danh sách tour du lịch</h2>

        <?php if (!empty($grouped)): ?>
        <?php foreach ($grouped as $categoryName => $tourList): ?>

        <h4 class="category-title">
            <i class="bi bi-folder2-open"></i>
            <?= htmlspecialchars($categoryName) ?>
        </h4>

        <div class="row g-4">
            <?php foreach ($tourList as $tour): ?>
            <div class="col-lg-6 col-md-6">
                <div class="card tour-card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($tour['TourName']) ?></h5>

                        <p class="info-line">
                            <i class="bi bi-building text-primary"></i>
                            Nhà cung cấp: <?= htmlspecialchars($tour['SupplierName'] ?? 'Không có') ?>
                        </p>

                        <p class="info-line">
                            <i class="bi bi-cash-stack text-success"></i>
                            Giá: <?= number_format($tour['Price'], 0, ',', '.') ?> VNĐ
                        </p>

                        <p class="info-line">
                            <i class="bi bi-calendar-event text-warning"></i>
                            Khởi hành: <?= $tour['StartDate'] ?>
                        </p>

                        <p class="info-line">
                            <i class="bi bi-calendar2-check text-info"></i>
                            Kết thúc: <?= $tour['EndDate'] ?>
                        </p>

                        <a href="<?= BASE_URL ?>?act=detail&id=<?= $tour['CategoryID'] ?>" class="btn btn-view mt-auto">
                            <i class="bi bi-eye"></i> Xem chi tiết
                        </a>

                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php endforeach; ?>
        <?php else: ?>
        <p class="text-center text-muted">Chưa có tour nào</p>
        <?php endif; ?>
    </div>
</div>

<style>
.admin-layout {
    display: flex;
    min-height: 100vh;
    background-color: #f5f7fa;
}

.sidebar-wrapper {
    width: 260px;
    background-color: #fff;
}

.admin-content {
    flex-grow: 1;
    padding: 25px 30px;
}

/* TITLE TRANG */
.page-title {
    font-size: 1.75rem;
    font-weight: 650;
    text-align: center;
    color: #0d6efd;
    margin-bottom: 30px;
}

/* Category */
.category-title {
    font-size: 1.25rem;
    font-weight: 650;
    margin-top: 25px;
    margin-bottom: 12px;
    padding-left: 12px;
    border-left: 5px solid #0d6efd;
    color: #0d6efd;
}

/* Card */
.tour-card {
    border-radius: 16px;
    border: 1px solid #e4e4e4;
    background: #fff;
    transition: all .25s ease-in-out;
}

.tour-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
}

.card-title {
    font-size: 1.15rem;
    font-weight: 650;
    color: #222;
    margin-bottom: 12px;
}

.info-line {
    font-size: 0.95rem;
    margin-bottom: 6px;
    color: #333;
}

/* Button xem chi tiết */
.btn-view {
    background-color: #0d6efd;
    color: white;
    border-radius: 8px;
    padding: 8px 14px;
    transition: 0.2s;
}

.btn-view:hover {
    background-color: #0b5ed7;
    color: #fff;
    transform: scale(1.03);
}

@media (max-width: 768px) {
    .col-md-6 {
        flex: 0 0 100%;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>