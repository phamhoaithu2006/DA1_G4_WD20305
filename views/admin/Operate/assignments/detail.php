<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/../../navbar.php'; ?>

<div class="d-flex admin-layout">
    <div class="sidebar-wrapper bg-white shadow-sm border-end">
        <?php require_once __DIR__ . '/../../sidebar.php'; ?>
    </div>

    <div class="admin-content flex-grow-1 p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="?act=category" class="text-decoration-none">Tour</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Chi tiết Tour</li>
                </ol>
            </nav>
            <a href="?act=category" class="btn btn-outline-secondary btn-sm shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Quay lại
            </a>
        </div>

        <?php if (!empty($tour) && is_array($tour)): ?>

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                        <div class="position-relative">
                            <?php if (!empty($tour['Image'])): ?>
                                <img src="<?= htmlspecialchars($tour['Image']) ?>" class="w-100 object-fit-cover"
                                    style="height: 250px;" alt="<?= htmlspecialchars($tour['TourName']) ?>"
                                    onerror="this.onerror=null; this.src='https://via.placeholder.com/400x250?text=Tour+Image';">
                            <?php else: ?>
                                <div class="bg-light d-flex align-items-center justify-content-center text-muted"
                                    style="height: 250px;">
                                    <div class="text-center">
                                        <i class="bi bi-image display-4 d-block mb-2"></i>
                                        <span>Chưa có hình ảnh</span>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <span class="position-absolute top-0 end-0 m-3 badge bg-primary shadow-sm">
                                <?= htmlspecialchars($tour['CategoryName']) ?>
                            </span>
                        </div>

                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-3"><?= htmlspecialchars($tour['TourName']) ?></h5>

                            <hr class="text-muted opacity-25 my-3">

                            <div class="vstack gap-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-secondary small text-uppercase fw-bold"><i
                                            class="bi bi-cash-stack me-2 text-success"></i>Giá Tour</span>
                                    <span
                                        class="fw-bold text-success fs-5"><?= number_format($tour['Price'], 0, ',', '.') ?>
                                        đ</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-secondary small text-uppercase fw-bold"><i
                                            class="bi bi-building me-2 text-primary"></i>Nhà cung cấp</span>
                                    <span class="fw-medium text-dark"><?= htmlspecialchars($tour['SupplierName']) ?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-secondary small text-uppercase fw-bold"><i
                                            class="bi bi-calendar-event me-2 text-warning"></i>Khởi hành</span>
                                    <span
                                        class="fw-medium text-dark"><?= date('d/m/Y', strtotime($tour['StartDate'])) ?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-secondary small text-uppercase fw-bold"><i
                                            class="bi bi-calendar-check me-2 text-danger"></i>Kết thúc</span>
                                    <span
                                        class="fw-medium text-dark"><?= date('d/m/Y', strtotime($tour['EndDate'])) ?></span>
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-top d-grid gap-2">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                            <h5 class="fw-bold text-dark d-flex align-items-center">
                                <i class="bi bi-text-paragraph text-info me-2"></i> Mô tả chi tiết
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="bg-light p-4 rounded-3 text-secondary lh-lg"
                                style="min-height: 300px; white-space: pre-line;">
                                <?= ($tour['Description']) ? htmlspecialchars($tour['Description']) : '<span class="text-muted fst-italic">Chưa có mô tả chi tiết cho tour này.</span>' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <div class="text-center py-5">
                <div class="mb-3 text-muted display-1"><i class="bi bi-exclamation-circle"></i></div>
                <h4 class="text-muted">Không tìm thấy thông tin Tour</h4>
                <a href="?act=category" class="btn btn-primary mt-3">Quay lại danh sách</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    /* Cấu hình chung */
    :root {
        --header-height: 70px;
        --sidebar-width: 260px;
    }

    body {
        background-color: #f5f7fa;
        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        padding-top: var(--header-height);
    }

    /* Sidebar cố định */
    .sidebar-wrapper {
        width: var(--sidebar-width);
        position: fixed;
        top: var(--header-height);
        bottom: 0;
        left: 0;
        z-index: 100;
        overflow-y: auto;
    }

    /* Nội dung chính */
    .admin-content {
        margin-left: var(--sidebar-width);
        min-height: calc(100vh - var(--header-height));
    }

    /* Responsive Mobile */
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