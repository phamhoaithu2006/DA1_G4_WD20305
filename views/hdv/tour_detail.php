<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chi tiết Tour - Portal HDV</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(120deg, #84fab0 0%, #8fd3f4 100%);
            --danger-gradient: linear-gradient(135deg, #ff9a9e 0%, #fecfef 99%, #fecfef 100%);
            --glass-bg: rgba(255, 255, 255, 0.9);
            --text-main: #2d3748;
        }

        body {
            background-color: #f3f4f6;
            background-image:
                radial-gradient(at 0% 0%, hsla(253, 16%, 7%, 1) 0, transparent 50%),
                radial-gradient(at 50% 0%, hsla(225, 39%, 30%, 1) 0, transparent 50%),
                radial-gradient(at 100% 0%, hsla(339, 49%, 30%, 1) 0, transparent 50%);
            background-repeat: no-repeat;
            background-size: 100% 400px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            padding-top: 80px;
            /* Space for Navbar */
            min-height: 100vh;
        }

        /* Glass Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.85) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03);
        }

        /* Card Styling */
        .glass-card {
            background: #fff;
            border: none;
            border-radius: 24px;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        /* Modern Tabs */
        .nav-pills {
            background: rgba(255, 255, 255, 0.5);
            padding: 6px;
            border-radius: 50px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }

        .nav-pills .nav-item {
            flex: 1;
            text-align: center;
        }

        .nav-pills .nav-link {
            border-radius: 50px;
            color: #64748b;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.6rem 0.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-pills .nav-link.active {
            background: #fff;
            color: #4f46e5;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transform: scale(1.02);
        }

        /* Info Tab Styling */
        .price-text {
            background: var(--primary-gradient);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
        }

        .info-row {
            display: flex;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px dashed #e2e8f0;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .icon-box {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            background: #f1f5f9;
            color: #6366f1;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 1.1rem;
        }

        /* Customer List Styling */
        .customer-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--secondary-gradient);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 4px 10px rgba(132, 250, 176, 0.3);
        }

        /* Timeline / Logs Styling */
        .timeline-item {
            position: relative;
            padding-left: 30px;
            padding-bottom: 25px;
            border-left: 2px solid #e2e8f0;
        }

        .timeline-item:last-child {
            border-left: 2px solid transparent;
        }

        .timeline-dot {
            position: absolute;
            left: -9px;
            top: 0;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #fff;
            border: 4px solid #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.2);
        }

        /* Floating Action Button */
        .fab-container {
            position: fixed;
            bottom: 25px;
            right: 25px;
            z-index: 999;
        }

        .fab-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary-gradient);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
            font-size: 26px;
            border: none;
            transition: transform 0.2s;
        }

        .fab-btn:active {
            transform: scale(0.9);
        }

        /* Action Buttons Grid */
        .action-btn-lg {
            border: none;
            border-radius: 20px;
            padding: 20px;
            text-align: left;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s;
            height: 100%;
        }

        .action-btn-lg:hover {
            transform: translateY(-3px);
        }

        .action-btn-lg i {
            font-size: 2rem;
            margin-bottom: 10px;
            display: block;
        }

        .btn-diary {
            background: #e0e7ff;
            color: #4338ca;
        }

        .btn-request {
            background: #ffe4e6;
            color: #be123c;
        }

        .btn-checkin {
            background: #dcfce7;
            color: #16a34a;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand fixed-top px-3">
        <div class="d-flex align-items-center w-100">
            <a href="?act=hdv-tour" class="btn btn-light rounded-circle shadow-sm me-3"
                style="width: 40px; height: 40px; display:flex; align-items:center; justify-content:center;">
                <i class="bi bi-arrow-left text-dark"></i>
            </a>

            <div class="flex-grow-1" style="min-width: 0;">
                <div class="small text-muted text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">Chi
                    tiết hành trình</div>
                <div class="fw-bold text-dark text-truncate fs-6">
                    <?= htmlspecialchars($tour['TourName'] ?? 'Chi tiết Tour') ?>
                </div>
            </div>

            <div class="dropdown ms-2">
                <button class="btn btn-light rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown"
                    style="width: 40px; height: 40px;">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-2 p-2">
                    <li><a class="dropdown-item rounded-3 mb-1"
                            href="?act=hdv-checkin-checkout&id=<?= $tour['TourID'] ?>"><i
                                class="bi bi-qr-code-scan me-2 text-primary"></i>Check-in/Check-out</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item rounded-3 text-danger" href="?act=hdv-logout"><i
                                class="bi bi-box-arrow-right me-2"></i>Thoát</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        <?php $activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'info'; ?>


        <?php if (!empty($_SESSION['hdv_success'])): ?>
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <?= htmlspecialchars($_SESSION['hdv_success']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php unset($_SESSION['hdv_success']);
        endif; ?>

        <?php if (!empty($_SESSION['hdv_error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <?= htmlspecialchars($_SESSION['hdv_error']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php unset($_SESSION['hdv_error']);
        endif; ?>

        <ul class="nav nav-pills shadow-sm" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link w-100 <?php echo $activeTab === 'info' ? 'active' : ''; ?>" data-bs-toggle="pill" data-bs-target="#pills-info">
                    Thông tin
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link w-100 <?php echo $activeTab === 'customers' ? 'active' : ''; ?>" data-bs-toggle="pill" data-bs-target="#pills-customers">
                    Khách (<?= count($customers ?? []) ?>)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link w-100 <?php echo $activeTab === 'logs' ? 'active' : ''; ?>" data-bs-toggle="pill" data-bs-target="#pills-logs">
                    Nhật ký
                </button>
            </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">

            <div class="tab-pane fade show active" id="pills-info">
                <div class="glass-card p-4">
                    <div class="mb-3">
                        <h6 class="text-uppercase small text-muted">Thông tin Tour đã tham gia</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <span class="badge rounded-pill px-3 py-2" style="background: #e9d8fd; color: #553c9a;">
                            <?= htmlspecialchars($tour['CategoryName'] ?? 'Tour') ?>
                        </span>
                        <div class="fs-4 price-text">
                            <?= number_format($tour['Price'] ?? 0, 0, ',', '.') ?> <small>đ</small>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="info-row">
                            <div class="icon-box"><i class="bi bi-calendar-check"></i></div>
                            <div>
                                <div class="small text-muted">Khởi hành</div>
                                <div class="fw-bold text-dark"><?= htmlspecialchars($tour['StartDate'] ?? '') ?></div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="icon-box text-danger"><i class="bi bi-calendar-x"></i></div>
                            <div>
                                <div class="small text-muted">Kết thúc</div>
                                <div class="fw-bold text-dark"><?= htmlspecialchars($tour['EndDate'] ?? '') ?></div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="icon-box text-success"><i class="bi bi-buildings"></i></div>
                            <div>
                                <div class="small text-muted">Nhà cung cấp</div>
                                <div class="fw-bold text-dark"><?= htmlspecialchars($tour['SupplierName'] ?? '') ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="fw-bold text-dark mb-2"><i class="bi bi-text-paragraph me-2 text-primary"></i>Lịch trình
                        sơ lược</h6>
                    <div class="bg-light p-3 rounded-4 text-secondary small" style="line-height: 1.6;">
                        <?= nl2br(htmlspecialchars($tour['Description'] ?? 'Chưa có mô tả chi tiết.')) ?>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-lg-4 col-md-6 col-12">
                        <a href="?act=hdv-diary-form&id=<?= $tour['TourID'] ?>" class="d-block text-decoration-none">
                            <div class="action-btn-lg btn-diary shadow-sm">
                                <i class="bi bi-journal-plus"></i>
                                <span class="fw-bold d-block">Viết nhật ký</span>
                                <small class="opacity-75">Cập nhật tiến độ</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <a href="?act=hdv-special-requests&id=<?= $tour['TourID'] ?>"
                            class="d-block text-decoration-none">
                            <div class="action-btn-lg btn-request shadow-sm">
                                <i class="bi bi-heart-pulse"></i>
                                <span class="fw-bold d-block">Yêu cầu</span>
                                <small class="opacity-75">Sức khỏe & Ăn uống</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <a href="?act=hdv-checkin-checkout&id=<?= $tour['TourID'] ?>" class="d-block text-decoration-none">
                            <div class="action-btn-lg btn-checkin shadow-sm">
                                <i class="bi bi-geo-fill"></i>
                                <span class="fw-bold d-block">Check-in/Check-out</span>
                                <small class="opacity-75">Xác nhận đến và rời điểm</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>


            <div class="tab-pane fade" id="pills-customers">
                <div class="glass-card">
                    <div class="p-3 bg-light border-bottom d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-muted small text-uppercase">Danh sách thành viên</span>
                        <div class="d-flex align-items-center gap-2">
                            <a class="btn btn-sm btn-white border rounded-pill shadow-sm text-primary fw-bold ms-2"
                                href="?act=hdv-room&id=<?= $tour['TourID'] ?>">
                                <i class="bi bi-door-open me-1"></i> Phân phòng
                            </a>
                            <button class="btn btn-sm btn-white border rounded-pill shadow-sm text-primary fw-bold"
                                onclick="window.print()">
                                <i class="bi bi-printer me-1"></i> In
                            </button>
                        </div>
                    </div>

                    <?php if (isset($assignedRooms)): ?>
                        <form method="post" action="?act=hdv-room-save&id=<?= $tour['TourID'] ?>">
                            <div class="list-group list-group-flush">
                                <?php if (!empty($customers)): foreach ($customers as $c): ?>
                                        <div class="list-group-item p-3 border-bottom-0 border-top-0"
                                            style="border-bottom: 1px solid #f1f5f9 !important;">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="customer-avatar flex-shrink-0">
                                                    <?php
                                                    $parts = explode(' ', $c['FullName']);
                                                    echo substr(end($parts), 0, 1);
                                                    ?>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="fw-bold text-dark mb-1"><?= htmlspecialchars($c['FullName']) ?></div>
                                                    <div class="d-flex gap-2 align-items-center">
                                                        <a href="tel:<?= $c['Phone'] ?>"
                                                            class="badge bg-light text-secondary border text-decoration-none fw-normal me-3">
                                                            <i class="bi bi-telephone-fill me-1 text-success"></i>
                                                            <?= htmlspecialchars($c['Phone']) ?>
                                                        </a>
                                                        <input type="text" name="room[<?= $c['CustomerID'] ?>]" value="<?= htmlspecialchars($c['RoomNumber'] ?? '') ?>" class="form-control form-control-sm" style="max-width:120px;">
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <small class="d-block text-muted" style="font-size: 0.7rem;">Phòng</small>
                                                    <span class="fw-bold text-primary d-none"><?= htmlspecialchars($c['RoomNumber'] ?? '-') ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach;
                                else: ?>
                                    <div class="p-5 text-center text-muted">
                                        <i class="bi bi-people display-4 opacity-25"></i>
                                        <p class="mt-2">Chưa có dữ liệu khách hàng</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="p-3 text-end">
                                <button type="submit" class="btn btn-primary rounded-pill px-4">Lưu phân phòng</button>
                                <a href="?act=hdv-tour-detail&id=<?= $tour['TourID'] ?>" class="btn btn-secondary rounded-pill px-4 ms-2">Hủy</a>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php if (!empty($customers)): foreach ($customers as $c): ?>
                                    <div class="list-group-item p-3 border-bottom-0 border-top-0"
                                        style="border-bottom: 1px solid #f1f5f9 !important;">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="customer-avatar flex-shrink-0">
                                                <?php
                                                $parts = explode(' ', $c['FullName']);
                                                echo substr(end($parts), 0, 1);
                                                ?>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="fw-bold text-dark mb-1"><?= htmlspecialchars($c['FullName']) ?></div>
                                                <div class="d-flex gap-2">
                                                    <a href="tel:<?= $c['Phone'] ?>"
                                                        class="badge bg-light text-secondary border text-decoration-none fw-normal">
                                                        <i class="bi bi-telephone-fill me-1 text-success"></i>
                                                        <?= htmlspecialchars($c['Phone']) ?>
                                                    </a>
                                                </div>
                                            </div>
                                            <?php if (!empty($c['AttendanceChecked'])): ?>
                                                <span class="badge bg-success text-white fw-normal">Đã điểm danh</span>
                                                <form method="post" action="?act=hdv-customer-checkout&id=<?= urlencode($tour['TourID']) ?>">
                                                    <input type="hidden" name="customer_id" value="<?= htmlspecialchars($c['CustomerID']) ?>">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">Bỏ điểm danh</button>
                                                </form>
                                            <?php else: ?>
                                                <span class="badge bg-secondary text-white fw-normal">Chưa điểm danh</span>
                                                <form method="post" action="?act=hdv-customer-checkin&id=<?= urlencode($tour['TourID']) ?>">
                                                    <input type="hidden" name="customer_id" value="<?= htmlspecialchars($c['CustomerID']) ?>">
                                                    <button type="submit" class="btn btn-sm btn-success rounded-pill">Điểm danh</button>
                                                </form>
                                            <?php endif; ?>
                                            <div class="text-end">
                                                <small class="d-block text-muted" style="font-size: 0.7rem;">Phòng</small>
                                                <span class="fw-bold text-primary"><?= htmlspecialchars($c['RoomNumber'] ?? '-') ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;
                            else: ?>
                                <div class="p-5 text-center text-muted">
                                    <i class="bi bi-people display-4 opacity-25"></i>
                                    <p class="mt-2">Chưa có dữ liệu khách hàng</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="pills-logs">
        <div class="container">
            <div class="glass-card p-4">
                <h5 class="fw-bold mb-4">Nhật ký hành trình</h5>
                <?php if (!empty($logs)): ?>
                    <?php foreach ($logs as $l): ?>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <span class="fw-bold text-dark"><?= date('H:i', strtotime($l['LogDate'])) ?></span>
                                    <span class="text-muted small ms-1"><?= date('d/m', strtotime($l['LogDate'])) ?></span>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-link text-muted p-0" data-bs-toggle="dropdown"><i
                                            class="bi bi-three-dots"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                        <li><a class="dropdown-item"
                                                href="?act=hdv-diary-form&id=<?= $tour['TourID'] ?>&log_id=<?= $l['LogID'] ?>">Sửa</a>
                                        </li>
                                        <li><a class="dropdown-item text-danger"
                                                href="?act=hdv-diary-delete&id=<?= $tour['TourID'] ?>&log_id=<?= $l['LogID'] ?>"
                                                onclick="return confirm('Xóa?')">Xóa</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="bg-light rounded-3 p-3 mb-2">
                                <p class="mb-0 text-secondary" style="font-size: 0.95rem;">
                                    <?= nl2br(htmlspecialchars($l['Note'])) ?></p>
                            </div>

                            <?php if (!empty($l['Incident'])): ?>
                                <div class="alert alert-danger border-0 d-flex align-items-start gap-2 shadow-sm"
                                    style="background-color: #fff5f5; color: #c53030;">
                                    <i class="bi bi-exclamation-octagon-fill mt-1"></i>
                                    <div>
                                        <strong>Sự cố:</strong>
                                        <div class="small mt-1"><?= nl2br(htmlspecialchars($l['Incident'])) ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($l['Images'])):
                                $images = json_decode($l['Images'], true);
                                if (!empty($images)): ?>
                                    <div class="d-flex gap-2 overflow-auto mt-2">
                                        <?php foreach ($images as $img): ?>
                                            <a href="<?= $img ?>" target="_blank">
                                                <img src="<?= $img ?>" class="rounded-3 shadow-sm"
                                                    style="width: 70px; height: 70px; object-fit: cover; border: 2px solid white;">
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                            <?php endif;
                            endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-5">
                        <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                            <i class="bi bi-journal-album display-4 text-muted opacity-50"></i>
                        </div>
                        <p class="text-muted">Chưa có nhật ký nào được ghi lại.</p>
                        <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
                            <i class="bi bi-plus-lg me-1"></i> Tạo mới ngay
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="fab-container">
        <a href="?act=hdv-diary-form&id=<?= $tour['TourID'] ?>" class="fab-btn text-decoration-none"
            title="Viết nhật ký">
            <i class="bi bi-pencil-square"></i>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>