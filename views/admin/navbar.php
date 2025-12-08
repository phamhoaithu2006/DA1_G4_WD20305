<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm border-bottom fixed-top"
    style="height: 70px; z-index: 1030;">
    <div class="container-fluid px-4">
        <a class="navbar-brand me-4" href="<?= BASE_URL ?>?act=dashboard">
            <img src="https://insacmau.com/wp-content/uploads/2023/02/logo-fpt-polytechnic.png" alt="Logo FPT"
                height="40">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">

            <ul class="navbar-nav ms-auto align-items-center">

                <li class="nav-item dropdown me-3">
                    <a class="nav-link position-relative text-secondary" href="#" role="button"
                        data-bs-toggle="dropdown">
                        <i class="bi bi-bell fs-5"></i>
                        <span class="position-absolute top-10 start-90 translate-middle badge rounded-pill bg-danger"
                            style="font-size: 0.6rem;">
                            3+
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                        <li>
                            <h6 class="dropdown-header">Thông báo mới</h6>
                        </li>
                        <li><a class="dropdown-item small" href="#">Booking #205 vừa được tạo</a></li>
                        <li><a class="dropdown-item small" href="#">Tour Đà Nẵng sắp khởi hành</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center text-dark" href="#" role="button"
                        data-bs-toggle="dropdown">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                            style="width: 35px; height: 35px;">
                            A
                        </div>
                        <span class="fw-medium">Admin User</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Hồ sơ</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Cài đặt</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="?page=logout"
                                onclick="return confirm('Đăng xuất?')">
                                <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div style="height: 70px;"></div>