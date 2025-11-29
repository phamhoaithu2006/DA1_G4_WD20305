<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<!-- Navbar -->
<?php require_once __DIR__ . '/..//../navbar.php'; ?>

<div class="admin-layout">

    <!-- Sidebar -->
    <div class="sidebar-wrapper shadow-sm bg-white">
        <?php require_once __DIR__ . '/..//../sidebar.php'; ?>
    </div>

    <!-- Content -->
    <div class="admin-content">
        <div class="container-fluid mt-4">

            <!-- Page title -->
            <h2 class="page-title">Chi tiết tour du lịch</h2>

            <?php if (!empty($tour) && is_array($tour)): ?>
            <div class="row g-4">

                <!-- Thông tin cơ bản -->
                <div class="col-lg-5 col-md-12">
                    <div class="card shadow-sm p-4 tour-info-card">
                        <h4 class="card-title mb-3">
                            <i class="bi bi-info-circle"></i> Thông tin chi tiết
                        </h4>

                        <ul class="list-group list-group-flush tour-info-list">
                            <li class="list-group-item">
                                <i class="bi bi-tags text-primary"></i>
                                <strong>Danh mục:</strong> <?= htmlspecialchars($tour['CategoryName']) ?>
                            </li>

                            <li class="list-group-item">
                                <i class="bi bi-building text-success"></i>
                                <strong>Nhà cung cấp:</strong> <?= htmlspecialchars($tour['SupplierName']) ?>
                            </li>

                            <li class="list-group-item">
                                <i class="bi bi-cash-stack text-warning"></i>
                                <strong>Giá:</strong>
                                <?= number_format($tour['Price'], 0, ',', '.') ?> VNĐ
                            </li>

                            <li class="list-group-item">
                                <i class="bi bi-calendar-event text-info"></i>
                                <strong>Khởi hành:</strong> <?= htmlspecialchars($tour['StartDate']) ?>
                            </li>

                            <li class="list-group-item">
                                <i class="bi bi-calendar2-check text-primary"></i>
                                <strong>Kết thúc:</strong> <?= htmlspecialchars($tour['EndDate']) ?>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Mô tả -->
                <div class="col-lg-7 col-md-12">
                    <div class="card shadow-sm p-4 tour-desc-card">
                        <h4 class="card-title mb-3">
                            <i class="bi bi-journal-text"></i> Mô tả chi tiết
                        </h4>
                        <p class="card-text desc-text"><?= nl2br(htmlspecialchars($tour['Description'])) ?></p>
                    </div>
                </div>
                <!--Thông tin đoàn-->
                <div class="col-lg-7 col-md-12">
                    <div class="card shadow-sm p-4 tour-desc-card">
                        <h4 class="card-title mb-3">
                            <i class="bi bi-journal-text"></i> Thông tin đoàn
                        </h4>
                        <p class="card-text desc-text">
                            <!--Thông tin đoàn theo tour, hiển thị hưỡng dẫn viên-->

                        </p>
                    </div>
                </div>


            </div>
            <?php else: ?>
            <p class="text-center text-muted mt-5">Không có dữ liệu tour</p>
            <?php endif; ?>
        </div>
    </div>

</div>

<style>
/* Layout */
.admin-layout {
    display: flex;
    min-height: 100vh;
    background-color: #f3f6fa;
}

.sidebar-wrapper {
    width: 260px;
    border-right: 1px solid #e8e8e8;
}

.admin-content {
    flex-grow: 1;
    padding: 20px 30px;
}

/* Title page */
.page-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #0d6efd;
    margin-bottom: 25px;
    display: flex;
    text-align: center;
    align-items: center;
    gap: 8px;
}

/* Card */
.tour-info-card,
.tour-desc-card {
    border-radius: 14px;
    background-color: #ffffff;
    transition: 0.25s ease;
    border: 1px solid #e5e5e5;
}

.tour-info-card:hover,
.tour-desc-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
}

/* Card title */
.card-title {
    font-weight: 650;
    font-size: 1.25rem;
    color: #0d6efd;
}

/* Danh sách chi tiết */
.tour-info-list .list-group-item {
    padding: 12px 0;
    font-size: 1rem;
    color: #333;
    border: none;
}

.tour-info-list .list-group-item i {
    font-size: 1.1rem;
    margin-right: 6px;
}

/* Mô tả */
.desc-text {
    color: #444;
    line-height: 1.6;
    font-size: 1.02rem;
    white-space: pre-line;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>