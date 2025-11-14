<?php require_once __DIR__ . '/layout/sidebar.php'; ?>

<style>
.content-wrapper {
    margin-left: 250px;
    /* chiều rộng sidebar của bạn */
    padding: 20px;
}

.hero {
    background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),
        url('https://images.unsplash.com/photo-1523275335684-37898b6baf30');
    background-size: cover;
    background-position: center;
    height: 380px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-align: center;
    border-radius: 8px;
    margin-bottom: 40px;
}
</style>

<!-- Bọc nội dung -->
<div class="content-wrapper">

    <!-- Banner -->
    <div class="hero">
        <div>
            <h1 class="fw-bold">Chào mừng đến với Website của chúng tôi</h1>
            <p class="lead">Nền tảng hỗ trợ học tập và phát triển kỹ năng CNTT</p>
            <a href="#" class="btn btn-primary btn-lg mt-2">Bắt đầu ngay</a>
        </div>
    </div>

    <!-- Giới thiệu -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Giới thiệu</h2>
        <p class="text-center text-muted">
            Đây là trang chủ mẫu sử dụng Bootstrap 5. Giao diện đơn giản, hiện đại và dễ tùy biến.
        </p>
    </div>

    <!-- Các chức năng -->
    <div class="container my-4">
        <div class="row g-4">

            <div class="col-md-4">
                <div class="card shadow-sm text-center p-4">
                    <i class="bi bi-laptop fs-1 text-primary"></i>
                    <h5 class="mt-3">Quản lý sản phẩm</h5>
                    <p>Xem danh sách sản phẩm mới nhất và chi tiết từng mặt hàng.</p>
                    <a href="#" class="btn btn-outline-primary">Xem thêm</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm text-center p-4">
                    <i class="bi bi-people fs-1 text-primary"></i>
                    <h5 class="mt-3">Quản lý người dùng</h5>
                    <p>Theo dõi thông tin tài khoản và phân quyền chi tiết.</p>
                    <a href="#" class="btn btn-outline-primary">Xem thêm</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm text-center p-4">
                    <i class="bi bi-gear fs-1 text-primary"></i>
                    <h5 class="mt-3">Cài đặt hệ thống</h5>
                    <p>Cấu hình hệ thống và các chức năng nâng cao.</p>
                    <a href="#" class="btn btn-outline-primary">Xem thêm</a>
                </div>
            </div>

        </div>
    </div>

</div>