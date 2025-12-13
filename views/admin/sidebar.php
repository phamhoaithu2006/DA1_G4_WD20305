<div class="sidebar-wrapper d-flex flex-column flex-shrink-0 bg-white border-end">
    <div class="sidebar-menu flex-grow-1 overflow-auto custom-scrollbar px-3 py-3">
        <ul class="nav nav-pills flex-column gap-1">

            <li class="nav-item">
                <a href="?act=dashboard" class="nav-link <?= ($_GET['act'] ?? '') == 'dashboard' ? 'active' : '' ?>">
                    <i class="bi bi-grid"></i>
                    <span>Tổng quan</span>
                </a>
            </li>

            <li class="nav-header mt-3 mb-1 text-uppercase">Kinh doanh</li>
            <li>
                <a href="?act=category" class="nav-link <?= ($_GET['act'] ?? '') == 'category' ? 'active' : '' ?>">
                    <i class="bi bi-map"></i>
                    <span>Quản lý Tour</span>
                </a>
            </li>
            <li>
                <a href="?act=booking-list"
                    class="nav-link d-flex justify-content-between align-items-center <?= ($_GET['act'] ?? '') == 'booking-list' ? 'active' : '' ?>">
                    <span><i class="bi bi-receipt"></i> Booking</span>
                    <span class="badge bg-danger-subtle text-danger rounded-pill fw-normal"
                        style="font-size: 0.65rem;">Mới</span>
                </a>
            </li>

            <li class="nav-header mt-3 mb-1 text-uppercase">Vận hành</li>
            <li>
                <a href="?act=schedule" class="nav-link <?= ($_GET['act'] ?? '') == 'schedule' ? 'active' : '' ?>">
                    <i class="bi bi-calendar4-week"></i>
                    <span>Lịch trình tổng</span>
                </a>
            </li>
            <li>
                <a href="?act=employees" class="nav-link <?= ($_GET['act'] ?? '') == 'employees' ? 'active' : '' ?>">
                    <i class="bi bi-people"></i>
                    <span>Nhân sự</span>
                </a>
            </li>

            <li>
                <a href="?act=tourlog-list&tourID=1"
                    class="nav-link <?= ($_GET['act'] ?? '') == 'tourlog-list' ? 'active' : '' ?>">
                    <i class="bi bi-journal-text"></i>
                    <span>Nhật kí Tour</span>
                </a>
            </li>

            <li class="nav-header mt-3 mb-1 text-uppercase">Chất lượng</li>
            <li>
                <a href="?act=report-list"
                    class="nav-link <?= ($_GET['act'] ?? '') == 'report-list' ? 'active' : '' ?>">
                    <i class="bi bi-star"></i>
                    <span>Phản hồi & Đánh giá</span>
                </a>
            </li>

            <li class="nav-header mt-3 mb-1 text-uppercase">Tổng kết</li>
            <li>
                <a href="?act=finance-report"
                    class="nav-link <?= ($_GET['act'] ?? '') == 'finance-report' ? 'active' : '' ?>">
                    <i class="bi bi-currency-dollar"></i>
                    <span>Tổng hợp lợi nhuận</span>
                </a>
            </li>
            <li>
                <a href="?act=tour-performance"
                    class="nav-link <?= ($_GET['act'] ?? '') == 'tour-performance' ? 'active' : '' ?>">
                    <i class="bi bi-activity"></i>
                    <span>Hiệu quả</span>
                </a>
            </li>
            <li>
                <a href="?act=finance-compare"
                    class="nav-link <?= ($_GET['act'] ?? '') == 'finance-compare' ? 'active' : '' ?>">
                    <i class="bi bi-graph-up-arrow"></i>
                    <span>So sánh hiệu quả Tour</span>
                </a>
            </li>



        </ul>
    </div>

    <div class="sidebar-footer p-3 border-top bg-light">
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle user-dropdown"
                id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://ui-avatars.com/api/?name=Admin&background=f8f9fa&color=333" width="36" height="36"
                    class="rounded-circle border me-2 shadow-sm">
                <div class="d-flex flex-column" style="line-height: 1.2;">
                    <strong class="small">Administrator</strong>
                    <small class="text-muted" style="font-size: 0.7rem;">Quản lý</small>
                </div>
            </a>
            <ul class="dropdown-menu shadow border-0 small" aria-labelledby="dropdownUser">
                <li><a class="dropdown-item" href="#">Hồ sơ cá nhân</a></li>
                <li><a class="dropdown-item" href="#">Cài đặt</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item text-danger" href="?page=logout" onclick="return confirm('Đăng xuất?')">Đăng
                        xuất</a></li>
            </ul>
        </div>
    </div>
</div>

<style>
    /* 1. CỐ ĐỊNH SIDEBAR (FIXED LAYOUT) */
    .sidebar-wrapper {
        width: 260px;
        /* Chiều rộng cố định */
        height: 100vh;
        /* Chiều cao bằng 100% màn hình */
        position: fixed;
        /* Ghim chặt vào vị trí */
        top: 0;
        /* Sát mép trên */
        left: 0;
        /* Sát mép trái */
        z-index: 1000;
        /* Nổi lên trên các thành phần khác */
        overflow: hidden;
        /* Ẩn thanh cuộn ngoài */
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    /* 2. STYLE CHO CÁC THÀNH PHẦN */
    .brand-icon {
        width: 36px;
        height: 36px;
        background: #212529;
        color: #fff;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .tracking-tight {
        letter-spacing: -0.5px;
    }

    /* Menu Link */
    .nav-link {
        color: #64748b;
        font-weight: 500;
        font-size: 0.9rem;
        padding: 0.7rem 1rem;
        border-radius: 8px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
    }

    .nav-link i {
        font-size: 1.1rem;
        width: 24px;
        margin-right: 10px;
        text-align: center;
        transition: color 0.2s;
    }

    /* Hover */
    .nav-link:hover {
        background-color: #f8f9fa;
        color: #0f172a;
    }

    .nav-link:hover i {
        color: #0d6efd;
    }

    /* Active */
    .nav-link.active {
        background-color: #f1f5f9 !important;
        /* Xanh rất nhạt */
        color: #0d6efd !important;
        /* Xanh dương đậm */
        font-weight: 600;
    }

    .admin-content {
        margin-left: 260px !important;
        /* Bằng width của Sidebar */
        width: calc(100% - 260px) !important;
        min-height: 100vh;
        transition: all 0.3s;
        /* Hiệu ứng mượt nếu sau này làm nút ẩn hiện menu */
    }

    /* Responsive: Trên Mobile thì ẩn Sidebar hoặc đẩy lại về 0 */
    @media (max-width: 992px) {
        .sidebar-wrapper {
            margin-left: -260px;
            /* Ẩn sidebar sang trái */
        }

        .admin-content {
            margin-left: 0 !important;
            /* Trả nội dung về full màn hình */
            width: 100% !important;
        }

        /* Khi bật menu trên mobile (cần thêm JS toggle class .active) */
        .sidebar-wrapper.active {
            margin-left: 0;
        }
    }

    .nav-link.active i {
        color: #0d6efd !important;
    }

    /* Header nhỏ */
    .nav-header {
        font-size: 0.7rem;
        font-weight: 700;
        color: #94a3b8;
        padding-left: 1rem;
        letter-spacing: 0.5px;
    }

    /* 3. SCROLLBAR TÙY CHỈNH (Chỉ cuộn phần menu giữa) */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
</style>