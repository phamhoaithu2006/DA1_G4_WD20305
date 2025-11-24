<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/navbar.php'; ?>

<div class="d-flex">

    <!-- Sidebar -->
    <div style="width: 260px; background: #f8f9fa; min-height: 100vh;" class="p-3 border-end shadow-sm">
        <h5 class="text-secondary mb-3">Hệ thống</h5>

        <div class="list-group">
            <a href="?act=dashboard" class="list-group-item list-group-item-action d-flex align-items-center">
                <span><i class="bi bi-bar-chart"> </i>Dashboard</span>
            </a>


            <a href="?act=category" class="list-group-item list-group-item-action d-flex align-items-center">
                <span><i class="bi bi-globe-americas"></i> Tour</span>
            </a>
            <a href="?act=booking-list" class="list-group-item list-group-item-action">
                <span><i class="bi bi-geo-alt"></i> Booking</span>
            </a>
            <!-- Quản lý & điều hành tour -->
            <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                data-bs-toggle="collapse" data-bs-target="#menuDieuHanhTour">
                <span><i class="bi bi-people"></i> Điều hành tour</span>
                <i class="bi bi-chevron-down"></i>
            </button>
            <div class="collapse" id="menuDieuHanhTour">
                <a href="?act=employees" class="list-group-item ps-5">Nhân sự</a>
                <a href="?act=assignments" class="list-group-item ps-5">Lịch trình</a>
                <a href="<?= BASE_URL ?>?act=tourcustomers" class="list-group-item ps-5">Khách hàng</a>
            </div>

            <!-- Báo cáo vận hành tour -->
            <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                data-bs-toggle="collapse" data-bs-target="#menuBaoCao">
                <span><i class="bi bi-bar-chart"></i> Báo cáo vận hành</span>
                <i class="bi bi-chevron-down"></i>
            </button>
            <div class="collapse" id="menuBaoCao">
                <a href="#" class="list-group-item ps-5">Báo cáo tổng hợp</a>
                <a href="#" class="list-group-item ps-5">Hiệu quả các tour</a>
            </div>
        </div>

        <hr>
        <a href="?page=logout" onclick="return confirm('Bạn có chắc chắn muốn đăng xuất không?')">
            <button class="btn btn-danger w-100 mt-3">
                <i class="bi bi-box-arrow-right"></i> Đăng xuất
            </button>
        </a>

    </div>


</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>