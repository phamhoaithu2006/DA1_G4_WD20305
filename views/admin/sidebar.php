<div class="sidebar-content p-3 bg-white h-100 d-flex flex-column">

    <div class="sidebar-section mb-2">
        <small class="text-uppercase text-secondary fw-bold ms-3" style="font-size: 0.75rem;">Main Menu</small>
    </div>

    <div class="nav flex-column nav-pills custom-sidebar" id="v-pills-tab" role="tablist" aria-orientation="vertical">

        <a href="?act=dashboard"
            class="nav-link mb-2 text-dark d-flex align-items-center <?= ($_GET['act'] ?? '') == 'dashboard' ? 'active shadow-sm' : '' ?>">
            <span class="icon-wrapper"><i class="bi bi-grid-1x2-fill"></i></span>
            Dashboard
        </a>

        <a href="?act=category"
            class="nav-link mb-2 text-dark d-flex align-items-center <?= ($_GET['act'] ?? '') == 'category' ? 'active shadow-sm' : '' ?>">
            <span class="icon-wrapper"><i class="bi bi-globe-americas"></i></span>
            Quản lý Tour
        </a>

        <a href="?act=booking-list"
            class="nav-link mb-2 text-dark d-flex align-items-center <?= ($_GET['act'] ?? '') == 'booking-list' ? 'active shadow-sm' : '' ?>">
            <span class="icon-wrapper"><i class="bi bi-calendar-check-fill"></i></span>
            Booking
            <span class="badge bg-danger rounded-pill ms-auto">New</span>
        </a>

        <hr class="my-3 text-secondary opacity-25">
        <div class="sidebar-section mb-2">
            <small class="text-uppercase text-secondary fw-bold ms-3" style="font-size: 0.75rem;">Điều hành</small>
        </div>

        <a class="nav-link text-dark d-flex align-items-center justify-content-between" data-bs-toggle="collapse"
            href="#menuDieuHanhTour" role="button">
            <div class="d-flex align-items-center">
                <span class="icon-wrapper"><i class="bi bi-briefcase-fill"></i></span>
                Điều hành Tour
            </div>
            <i class="bi bi-chevron-down small text-muted"></i>
        </a>

        <div class="collapse show mt-1" id="menuDieuHanhTour">
            <div class="bg-light rounded p-2 mb-2">
                <a href="?act=employees" class="nav-link small text-secondary py-1 ps-4 hover-link">
                    <i class="bi bi-dot"></i> Nhân sự
                </a>
                <a href="?act=schedule" class="nav-link small text-secondary py-1 ps-4 hover-link">
                    <i class="bi bi-dot"></i> Lịch trình & Dịch vụ
                </a>
            </div>
        </div>

        <a class="nav-link text-dark d-flex align-items-center justify-content-between mt-1" data-bs-toggle="collapse"
            href="#menuBaoCao" role="button">
            <div class="d-flex align-items-center">
                <span class="icon-wrapper"><i class="bi bi-pie-chart-fill"></i></span>
                Báo cáo
            </div>
            <i class="bi bi-chevron-down small text-muted"></i>
        </a>
        <div class="collapse mt-1" id="menuBaoCao">
            <div class="bg-light rounded p-2 mb-2">
                <a href="#" class="nav-link small text-secondary py-1 ps-4 hover-link"><i class="bi bi-dot"></i> Tổng
                    hợp</a>
                <a href="#" class="nav-link small text-secondary py-1 ps-4 hover-link"><i class="bi bi-dot"></i> Hiệu
                    quả Tour</a>
            </div>
        </div>
    </div>

    <div class="mt-auto pt-3 border-top">
        <a href="?page=logout" onclick="return confirm('Bạn có chắc chắn muốn đăng xuất không?')"
            class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center">
            <i class="bi bi-box-arrow-left me-2"></i> Đăng xuất
        </a>
    </div>
</div>

<style>
/* Icon wrapper để căn chỉnh icon đẹp */
.icon-wrapper {
    width: 30px;
    display: inline-flex;
    justify-content: center;
    margin-right: 10px;
    font-size: 1.1rem;
    color: #6c757d;
    /* Màu mặc định */
}

/* Hiệu ứng Hover cho link */
.custom-sidebar .nav-link {
    border-radius: 8px;
    transition: all 0.2s ease;
    font-weight: 500;
}

.custom-sidebar .nav-link:hover {
    background-color: #f1f3f5;
    color: #0d6efd !important;
}

.custom-sidebar .nav-link:hover .icon-wrapper {
    color: #0d6efd;
}

/* Trạng thái Active */
.custom-sidebar .nav-link.active {
    background-color: #0d6efd !important;
    /* Màu xanh chủ đạo */
    color: white !important;
}

.custom-sidebar .nav-link.active .icon-wrapper {
    color: white;
}

/* Link con trong collapse */
.hover-link:hover {
    color: #0d6efd !important;
    background-color: transparent;
    font-weight: 600;
}
</style>