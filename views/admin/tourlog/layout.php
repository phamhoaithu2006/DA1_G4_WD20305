<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Dashboard' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { min-height: 100vh; }
        .sidebar { width: 250px; background: #f8f9fa; min-height: 100vh; }
        .sidebar .list-group-item { border: none; }
        .sidebar .list-group-item.active { background: #0d6efd; color: white; }
        .main-content { flex: 1; padding: 20px; }
        @media (max-width: 768px) {
            .sidebar { position: absolute; z-index: 1000; transform: translateX(-100%); transition: 0.3s; }
            .sidebar.show { transform: translateX(0); }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Tour Dashboard</a>
            <button class="btn btn-outline-light d-lg-none" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="?page=logout" class="nav-link" onclick="return confirm('Bạn có chắc chắn muốn đăng xuất?');">
                            <i class="bi bi-box-arrow-right"></i> Đăng xuất
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar border-end p-3" id="sidebarMenu">
            <h5 class="text-secondary mb-3">Hệ thống</h5>
            <div class="list-group">
                <a href="?act=dashboard" class="list-group-item list-group-item-action"><i class="bi bi-bar-chart"></i> Dashboard</a>
                <a href="?act=category" class="list-group-item list-group-item-action"><i class="bi bi-globe-americas"></i> Tour</a>
                <a href="?act=booking-list" class="list-group-item list-group-item-action"><i class="bi bi-geo-alt"></i> Booking</a>

                <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" data-bs-target="#menuDieuHanhTour">
                    <span><i class="bi bi-people"></i> Điều hành tour</span>
                    <i class="bi bi-chevron-down"></i>
                </button>
                <div class="collapse" id="menuDieuHanhTour">
                    <a href="?act=employees" class="list-group-item ps-5">Nhân sự</a>
                    <a href="?act=assignments&tourID=1" class="list-group-item ps-5">Lịch trình</a>
                    <a href="?act=tourcustomers&tourID=1" class="list-group-item ps-5">Khách hàng tour</a>
                    <a href="?act=tourlog-list&tourID=1" class="list-group-item ps-5">Nhật ký tour</a>
                </div>

                <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" data-bs-target="#menuBaoCao">
                    <span><i class="bi bi-bar-chart"></i> Báo cáo vận hành</span>
                    <i class="bi bi-chevron-down"></i>
                </button>
                <div class="collapse" id="menuBaoCao">
                    <a href="?act=finance-list&tourID=1" class="list-group-item ps-5">Báo cáo tài chính tour</a>
                    <a href="?act=finance-create&tourID=1" class="list-group-item ps-5">Thêm báo cáo tài chính</a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <?php
                // Nội dung trang con inject vào đây
                if(isset($content)) echo $content;
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function(){
            document.getElementById('sidebarMenu').classList.toggle('show');
        });
    </script>
</body>
</html>
