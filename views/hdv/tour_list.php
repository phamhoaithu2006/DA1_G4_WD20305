<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$hdvName = $_SESSION['hdv_name'] ?? 'HDV';
?>

<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HDV Portal</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(120deg, #84fab0 0%, #8fd3f4 100%);
            --glass-bg: rgba(255, 255, 255, 0.95);
            --glass-border: 1px solid rgba(255, 255, 255, 0.18);
            --text-main: #2d3748;
            --text-muted: #718096;
        }

        body {
            background-color: #f3f4f6;
            /* Tạo nền màu mè nhẹ nhàng phía sau */
            background-image:
                radial-gradient(at 0% 0%, hsla(253, 16%, 7%, 1) 0, transparent 50%),
                radial-gradient(at 50% 0%, hsla(225, 39%, 30%, 1) 0, transparent 50%),
                radial-gradient(at 100% 0%, hsla(339, 49%, 30%, 1) 0, transparent 50%);
            background-repeat: no-repeat;
            background-size: 100% 500px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            color: var(--text-main);
        }

        /* Navbar Glassmorphism */
        .navbar {
            background: rgba(255, 255, 255, 0.85) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03);
        }

        .brand-gradient {
            color: #6f42c1;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        /* Welcome Card */
        .hero-card {
            background: #fff;
            border-radius: 24px;
            border: none;
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            position: relative;
        }

        .hero-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 6px;
            height: 100%;
            background: var(--primary-gradient);
        }

        /* Table Styling */
        .card-table {
            background: #fff;
            border-radius: 24px;
            border: none;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.03);
            overflow: hidden;
        }

        .table thead th {
            background-color: #f8fafc;
            color: #64748b;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .table tbody td {
            padding: 1.25rem 1.5rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.2s;
        }

        .table tbody tr:hover td {
            background-color: #f8fafc;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Elements */
        .date-box {
            background: #f1f5f9;
            border-radius: 12px;
            padding: 8px 12px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #475569;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .badge-custom {
            padding: 8px 12px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .badge-purple {
            background: #e9d8fd;
            color: #553c9a;
        }

        .badge-cyan {
            background: #c4f1f9;
            color: #006097;
        }

        .btn-action {
            background: var(--primary-gradient);
            border: none;
            color: white;
            border-radius: 50px;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            transition: all 0.3s ease;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
            color: white;
        }

        .avatar-circle {
            width: 42px;
            height: 42px;
            background: linear-gradient(45deg, #ff9a9e 0%, #fad0c4 99%, #fad0c4 100%);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: bold;
            font-size: 1.1rem;
            border: 2px solid white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="?act=hdv-tour">
                <i class="bi bi-airplane-engines-fill text-primary fs-4"></i>
                <span class="brand-gradient fs-4">HDV Portal</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex align-items-center gap-4">
                    <div class="d-none d-lg-block">
                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2">
                            <i class="bi bi-clock me-1 text-primary"></i> <?= date('d/m/Y') ?>
                        </span>
                    </div>

                    <div class="dropdown">
                        <div class="d-flex align-items-center gap-3 cursor-pointer" data-bs-toggle="dropdown"
                            style="cursor: pointer;">
                            <div class="text-end d-none d-md-block">
                                <div class="fw-bold text-dark mb-0" style="line-height: 1.2;">
                                    <?= htmlspecialchars($hdvName) ?></div>
                                <small class="text-muted" style="font-size: 0.75rem;">Verified Guide</small>
                            </div>
                            <div class="avatar-circle">
                                <?= substr($hdvName, 0, 1) ?>
                            </div>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 mt-2 p-2">
                            <li><a class="dropdown-item rounded-3 mb-1" href="#"><i class="bi bi-person me-2"></i>Hồ
                                    sơ</a></li>
                            <li><a class="dropdown-item rounded-3 mb-1" href="#"><i class="bi bi-gear me-2"></i>Cài
                                    đặt</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item rounded-3 text-danger" href="?page=logout" onclick="return confirm('Đăng xuất?')"><i
                                        class="bi bi-box-arrow-right me-2"></i>Đăng xuất</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 100px; padding-bottom: 50px;">

        <div class="row mb-5">
            <div class="col-12">
                <div class="hero-card p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <h2 class="fw-bold mb-1 text-dark">Xin chào, <?= htmlspecialchars($hdvName) ?>! 👋</h2>
                        <p class="text-muted mb-0">Chúc bạn có những chuyến đi thượng lộ bình an và đầy niềm vui!</p>
                    </div>
                    <div class="d-flex gap-3">
                        <div class="text-center px-4 py-2 bg-light rounded-4">
                            <div class="h4 fw-bold text-primary mb-0"><?= count($tours) ?></div>
                            <small class="text-muted fw-bold" style="font-size: 0.7rem;">TOUR SẮP TỚI</small>
                        </div>
                        <div class="text-center px-4 py-2 bg-light rounded-4">
                            <div class="h4 fw-bold text-success mb-0">0</div>
                            <small class="text-muted fw-bold" style="font-size: 0.7rem;">TOUR ĐANG CHẠY</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-end mb-3">
                    <h4 class="fw-bold text-white mb-0 text-shadow">Lịch trình công tác</h4>
                    <button class="btn btn-sm btn-light rounded-pill px-3 fw-bold text-primary shadow-sm">
                        <i class="bi bi-filter me-1"></i> Lọc dữ liệu
                    </button>
                </div>

                <div class="card-table">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Thông tin Tour</th>
                                    <th>Thời gian</th>
                                    <th>Phân loại</th>
                                    <th>Đối tác</th>
                                    <th class="text-end">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($tours)): ?>
                                    <?php foreach ($tours as $index => $row): ?>
                                        <?php
                                        $badgeClass = ($index % 2 == 0) ? 'badge-purple' : 'badge-cyan';
                                        $iconClass = ($index % 2 == 0) ? 'bi-stars' : 'bi-compass';
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="rounded-3 d-flex align-items-center justify-content-center bg-light text-primary flex-shrink-0"
                                                        style="width: 50px; height: 50px;">
                                                        <i class="bi <?= $iconClass ?> fs-4"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark" style="max-width: 300px;">
                                                            <?= htmlspecialchars($row['TourName']) ?></div>
                                                        <div class="small text-muted font-monospace mt-1">ID:
                                                            #<?= $row['TourID'] ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column gap-1">
                                                    <div
                                                        class="date-box text-success bg-success-subtle border border-success-subtle">
                                                        <i class="bi bi-calendar-check-fill"></i>
                                                        <?= date('d/m/Y', strtotime($row['StartDate'])) ?>
                                                    </div>
                                                    <div
                                                        class="date-box text-danger bg-danger-subtle border border-danger-subtle">
                                                        <i class="bi bi-calendar-x-fill"></i>
                                                        <?= date('d/m/Y', strtotime($row['EndDate'])) ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge-custom <?= $badgeClass ?>">
                                                    <?= htmlspecialchars($row['CategoryName']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center text-muted fw-medium">
                                                    <i class="bi bi-building-fill me-2 opacity-50"></i>
                                                    <?= htmlspecialchars($row['SupplierName']) ?>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <a href="?act=hdv-tour-detail&id=<?= $row['TourID'] ?>"
                                                    class="btn-action d-inline-block text-decoration-none">
                                                    Chi tiết <i class="bi bi-arrow-right-short fs-5 align-middle"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center justify-content-center">
                                                <div class="bg-light rounded-circle p-4 mb-3">
                                                    <i class="bi bi-calendar2-week display-4 text-muted opacity-50"></i>
                                                </div>
                                                <h5 class="text-muted fw-bold">Chưa có lịch trình</h5>
                                                <p class="text-muted small mb-0">Hiện tại bạn đang rảnh, hãy nghỉ ngơi nhé!
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>