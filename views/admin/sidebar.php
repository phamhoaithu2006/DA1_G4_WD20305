<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/navbar.php'; ?>

<div class="d-flex">

    <!-- Sidebar -->
    <div style="width: 240px; background: #f8f9fa; min-height: 100vh;" class="p-3 border-end">
        <div class="list-group" style="margin-top: 20px;">
            <a href="<?= BASE_URL ?>?act=category" class="list-group-item list-group-item-action">Quản lý tour</a>
            <a href="#" class="list-group-item list-group-item-action">Quản lý booking</a>
            <a href="#" class="list-group-item list-group-item-action">Quản lý và điều hành tour</a>
            <a href="#" class="list-group-item list-group-item-action">Báo cáo vận hành tour</a>
        </div>

        <hr>
        <a href="?page=logout">
            <button class="btn btn-danger w-100 mt-3">
                <i class="bi bi-box-arrow-right"></i> Đăng xuất
            </button>
        </a>
    </div>


</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>