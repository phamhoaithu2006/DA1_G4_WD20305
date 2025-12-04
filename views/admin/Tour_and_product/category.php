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

<div class="sidebar-wrapper bg-white shadow-sm border-end">
    <?php require_once __DIR__ . '/../sidebar.php'; ?>
</div>

<div class="admin-content">
    <div class="container-fluid p-0">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title mb-0">Danh sách Tour du lịch</h2>
            <a href="?act=tour-create" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Thêm Tour mới
            </a>
        </div>

        <?php if (!empty($grouped)): ?>
        <?php foreach ($grouped as $categoryName => $tourList): ?>

        <div class="category-section mb-5">
            <h4 class="category-title text-primary d-flex align-items-center mb-3">
                <span class="bg-primary-subtle text-primary rounded p-2 me-2">
                    <i class="bi bi-folder2-open"></i>
                </span>
                <?= htmlspecialchars($categoryName) ?>
            </h4>

            <div class="row g-4">
                <?php foreach ($tourList as $tour): ?>

                <?php
                        $currentDate = new DateTime();
                        $startDate = new DateTime($tour['StartDate']);
                        $endDate = new DateTime($tour['EndDate']);
                        
                        $statusBadge = '';
                        $statusText = '';

                        if ($currentDate > $endDate) {
                            $statusBadge = 'bg-success text-white';
                            $statusText = 'ĐÃ HOÀN THÀNH';
                        } elseif ($currentDate >= $startDate && $currentDate <= $endDate) {
                            $statusBadge = 'bg-danger text-white';
                            $statusText = 'ĐANG DIỄN RA';
                        } else {
                            $statusBadge = 'bg-info text-white';
                            $statusText = 'SẮP KHỞI HÀNH';
                        }
                    ?>

                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card tour-card h-100 border-0 shadow-sm">

                        <div class="card-img-top position-relative">

                            <div class="ratio ratio-16x9 bg-light overflow-hidden rounded-top">
                                <?php if (!empty($tour['Image'])): ?>
                                <img src="<?= htmlspecialchars($tour['Image']) ?>" class="object-fit-cover"
                                    alt="<?= htmlspecialchars($tour['TourName']) ?>"
                                    onerror="this.onerror=null; this.src='https://via.placeholder.com/300x200?text=Loi+Anh';">
                                <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center text-muted h-100 w-100">
                                    <i class="bi bi-image fs-1"></i>
                                </div>
                                <?php endif; ?>
                            </div>

                            <span
                                class="position-absolute top-0 end-0 m-2 badge bg-danger shadow-sm border border-white z-2">
                                -10%
                            </span>

                            <span
                                class="position-absolute bottom-0 start-0 m-2 badge <?= $statusBadge ?> shadow-sm z-2">
                                <?= $statusText ?>
                            </span>
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title fw-bold text-dark mb-3 text-truncate"
                                title="<?= htmlspecialchars($tour['TourName']) ?>">
                                <?= htmlspecialchars($tour['TourName']) ?>
                            </h5>

                            <div class="tour-info small mb-3">
                                <div class="d-flex justify-content-between mb-2 pb-2 border-bottom border-light">
                                    <span class="text-muted"><i class="bi bi-building me-1"></i> Nhà cung cấp:</span>
                                    <span class="fw-medium text-end text-truncate" style="max-width: 150px;">
                                        <?= htmlspecialchars($tour['SupplierName'] ?? 'N/A') ?>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between mb-2 pb-2 border-bottom border-light">
                                    <span class="text-muted"><i class="bi bi-calendar-event me-1"></i> Khởi hành:</span>
                                    <span
                                        class="fw-medium text-end"><?= date('d/m/Y', strtotime($tour['StartDate'])) ?></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted"><i class="bi bi-calendar2-check me-1"></i> Kết thúc:</span>
                                    <span
                                        class="fw-medium text-end"><?= date('d/m/Y', strtotime($tour['EndDate'])) ?></span>
                                </div>
                            </div>

                            <div class="mt-auto pt-3 border-top">
                                <div class="d-flex justify-content-between align-items-end">

                                    <div class="d-flex gap-1">
                                        <a href="<?= BASE_URL ?>?act=detail&id=<?= $tour['TourID'] ?>"
                                            class="btn btn-sm btn-outline-primary rounded-pill" data-bs-toggle="tooltip"
                                            title="Xem chi tiết">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>?act=operate-tour&id=<?= $tour['TourID'] ?>"
                                            class="btn btn-sm btn-warning rounded-pill" data-bs-toggle="tooltip"
                                            title="Điều hành">
                                            <i class="bi bi-gear-fill"></i>
                                        </a>
                                        <a href="?act=tour-delete&id=<?= $tour['TourID'] ?>"
                                            class="btn btn-sm btn-outline-danger rounded-pill" data-bs-toggle="tooltip"
                                            title="Xóa Tour"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa tour này? Hành động này không thể hoàn tác!');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>

                                    <div class="text-end">
                                        <?php 
                                            $originalPrice = $tour['Price'];
                                            $discount = 10;
                                            $discountedPrice = $originalPrice * (1 - $discount/100);
                                        ?>
                                        <div class="d-flex align-items-center justify-content-end gap-1 mb-1">
                                            <small class="text-decoration-line-through text-muted"
                                                style="font-size: 0.8rem;">
                                                <?= number_format($originalPrice, 0, ',', '.') ?>đ
                                            </small>
                                            <span
                                                class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-1"
                                                style="font-size: 0.65rem;">
                                                -<?= $discount ?>%
                                            </span>
                                        </div>
                                        <div class="text-danger fw-bold fs-5" style="line-height: 1;">
                                            <?= number_format($discountedPrice, 0, ',', '.') ?>đ
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php endforeach; ?>
        <?php else: ?>
        <div class="text-center py-5">
            <div class="mb-3 text-muted"><i class="bi bi-inbox fs-1"></i></div>
            <h5 class="text-muted">Chưa có dữ liệu tour nào</h5>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
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
    padding: 30px;
    min-height: calc(100vh - var(--header-height));
}

.tour-card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.tour-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
}

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
<script>
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>