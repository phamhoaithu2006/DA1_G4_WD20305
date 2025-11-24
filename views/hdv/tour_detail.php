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
    <title>Chi tiết tour</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        /* Navbar HDV */
        .navbar {
            border-radius: 0 0 12px 12px;
        }

        /* Body nền nhẹ */
        body {
            background: #f5f7fa;
            font-family: 'Segoe UI', sans-serif;
        }

        /* Tour Info Card */
        .tour-info-card {
            border-radius: 14px;
            transition: 0.3s;
        }

        .tour-info-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .tour-info-card .card-header {
            border-top-left-radius: 14px;
            border-top-right-radius: 14px;
        }

        .tour-info-card .card-body p,
        .tour-info-card .card-body span {
            margin-bottom: 0.5rem;
        }

        .tour-info-card .text-primary {
            font-size: 1.1rem;
        }

        /* Feature Card (nhật ký, check-in, yêu cầu đặc biệt) */
        .feature-card {
            transition: 0.25s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15) !important;
        }

        /* Log item */
        .log-item {
            border-left: 4px solid #0d6efd;
            padding-left: 10px;
            margin-bottom: 12px;
            background: #fdfdfd;
            border-radius: 8px;
        }

        .log-item:hover {
            background: #f1f7ff;
        }

        /* Hình ảnh nhật ký */
        .img-thumbnail {
            border-radius: 10px;
        }

        /* Bảng */
        table thead {
            background: #0dcaf0;
            color: white;
        }

        table tbody tr:hover {
            background: #f1f1f1;
        }

        /* Nút info bootstrap tuỳ chỉnh */
        .btn-info {
            background: #0ea5e9;
            border: none;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 13px;
        }

        .btn-info:hover {
            background: #0284c7;
        }

        /* Shadow mềm cho các card */
        .shadow-soft {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="?act=hdv-tour">
                <i class="bi bi-person-badge"></i>
                Hướng dẫn viên: <?= htmlspecialchars($hdvName) ?>
            </a>
            <div>
                <a class="btn btn-light btn-sm" href="?act=hdv-logout">
                    Đăng xuất
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-4">

        <!-- Back button -->
        <a href="?act=hdv-tour" class="btn btn-outline-secondary btn-sm mb-3">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>

        <!-- Tour Info -->
        <div class="card shadow-sm tour-info-card mb-4 border-0">
            <div class="card-header bg-light border-bottom">
                <h4 class="mb-0 fw-bold"><?= htmlspecialchars($tour['TourName'] ?? '---') ?></h4>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <!-- Cột 1: Loại + Nhà cung cấp -->
                    <div class="col-sm-4">
                        <p class="mb-1"><strong>Loại:</strong> <?= htmlspecialchars($tour['CategoryName'] ?? '') ?></p>
                        <p class="mb-1"><strong>Nhà cung cấp:</strong> <?= htmlspecialchars($tour['SupplierName'] ?? '') ?></p>
                    </div>

                    <!-- Cột 2: Giá + Mô tả -->
                    <div class="col-sm-4">
                        <p class="mb-1"><strong>Giá:</strong> <?= number_format($tour['Price'] ?? 0) ?> VNĐ</span></p>
                        <p class="mb-1"><strong>Mô tả:</strong> <?= nl2br(htmlspecialchars($tour['Description'] ?? '')) ?></span></p>
                    </div>

                    <!-- Cột 3: Khởi hành + Kết thúc -->
                    <div class="col-sm-4">
                        <p class="mb-1"><strong>Khởi hành:</strong> <?= htmlspecialchars($tour['StartDate'] ?? '') ?></p>
                        <p class="mb-1"><strong>Kết thúc:</strong> <?= htmlspecialchars($tour['EndDate'] ?? '') ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feature boxes -->
        <div class="row g-4 mb-4">

            <div class="col-md-4">
                <div class="card feature-card shadow-sm border-primary text-center p-3">
                    <h6 class="text-primary fw-bold mb-1">Nhật ký tour</h6>
                    <p class="small text-muted">Thêm/Cập nhật lịch trình và sự cố</p>
                    <a href="?act=hdv-diary-form&id=<?= $tour['TourID'] ?>" class="btn btn-primary btn-sm">
                        <i class="bi bi-journal-plus"></i> Thêm nhật ký
                    </a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-card shadow-sm border-success text-center p-3">
                    <h6 class="text-success fw-bold mb-1">Check-in/Check-out</h6>
                    <p class="small text-muted">Quản lý trạng thái đoàn</p>
                    <a href="?act=hdv-checkin-checkout&id=<?= $tour['TourID'] ?>" class="btn btn-success btn-sm">
                        <i class="bi bi-check-circle"></i> Quản lý check-in/check-out
                    </a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-card shadow-sm border-info text-center p-3">
                    <h6 class="text-info fw-bold mb-1">Yêu cầu đặc biệt</h6>
                    <p class="small text-muted">Tình trạng sức khỏe và hỗ trợ riêng của khách</p>
                    <a href="?act=hdv-special-requests&id=<?= $tour['TourID'] ?>" class="btn btn-info btn-sm text-white">
                        <i class="bi bi-heart"></i> Quản lý yêu cầu
                    </a>
                </div>
            </div>

        </div>

        <!-- Two-column layout -->
        <div class="row g-4">

            <!-- Left: Customer list -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white fw-bold">
                        <i class="bi bi-people"></i> Danh sách khách
                    </div>
                    <div class="card-body p-0">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Họ tên</th>
                                    <th>Số điện thoại</th>
                                    <th>Phòng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($customers)): foreach ($customers as $c): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($c['FullName']) ?></td>
                                            <td><?= htmlspecialchars($c['Phone']) ?></td>
                                            <td><?= htmlspecialchars($c['RoomNumber']) ?></td>
                                        </tr>
                                    <?php endforeach;
                                else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-3 text-muted">
                                            Không có khách
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right: Tour Log -->
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-warning fw-bold d-flex justify-content-between">
                        <span><i class="bi bi-journal-text"></i> Lịch trình/Nhật ký</span>
                        <a href="?act=hdv-diary-form&id=<?= $tour['TourID'] ?>" class="btn btn-sm btn-light">
                            <i class="bi bi-plus-circle"></i> Thêm
                        </a>
                    </div>

                    <div class="card-body" style="max-height: 450px; overflow-y: auto;">
                        <?php if (!empty($logs)): ?>
                            <?php foreach ($logs as $l): ?>
                                <div class="log-item">
                                    <div class="d-flex justify-content-between">
                                        <small class="text-muted"><?= $l['LogDate'] ?></small>
                                        <div class="d-flex gap-1">
                                            <a href="?act=hdv-diary-form&id=<?= $tour['TourID'] ?>&log_id=<?= $l['LogID'] ?>"
                                                class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="?act=hdv-diary-delete&id=<?= $tour['TourID'] ?>&log_id=<?= $l['LogID'] ?>"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa nhật ký này?');">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <p class="mt-2 mb-2"><?= nl2br(htmlspecialchars($l['Note'])) ?></p>

                                    <?php if (!empty($l['Incident'])): ?>
                                        <div class="alert alert-warning py-1 px-2 small">
                                            <strong>Sự cố:</strong>
                                            <?= nl2br(htmlspecialchars($l['Incident'])) ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($l['Images'])):
                                        $images = json_decode($l['Images'], true);
                                        if (!empty($images)): ?>
                                            <div class="d-flex flex-wrap gap-2 mt-2">
                                                <?php foreach ($images as $img): ?>
                                                    <img src="<?= $img ?>" class="img-thumbnail"
                                                        onclick="window.open('<?= $img ?>', '_blank')"
                                                        style="width: 70px; height: 70px; object-fit: cover;">
                                                <?php endforeach; ?>
                                            </div>
                                    <?php endif;
                                    endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-center text-muted mt-4">Chưa có lịch trình/nhật ký</p>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>