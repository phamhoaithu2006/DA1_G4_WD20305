<?php
// views/hdv/tour_detail.php
// $tours is an array of rows (from PDO)

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
</head>

<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="?act=hdv-tour">Hướng dẫn viên: <?= htmlspecialchars($hdvName) ?></a>
            <div>
                <a class="btn btn-outline-light btn-sm" href="?act=hdv-logout">Đăng xuất</a>
            </div>
        </div>
    </nav>

    <div class="container py-4">

        <!-- Back button -->
        <a href="?act=hdv-tour" class="btn btn-secondary btn-sm mb-3">&larr; Quay lại</a>

        <!-- Tour info card -->
        <div class="card shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-bottom rounded-top-4">
                <h5 class="card-title mb-0"><?= htmlspecialchars($tour['TourName'] ?? '---') ?></h5>
            </div>
            <div class="card-body">
                <p><strong>Loại:</strong> <?= htmlspecialchars($tour['CategoryName'] ?? '') ?></p>
                <p><strong>Nhà cung cấp:</strong> <?= htmlspecialchars($tour['SupplierName'] ?? '') ?></p>
                <p><strong>Giá:</strong> <?= number_format($tour['Price'] ?? 0) ?> VNĐ</p>
                <p><strong>Khởi hành:</strong> <?= htmlspecialchars($tour['StartDate'] ?? '') ?></p>
                <p><strong>Kết thúc:</strong> <?= htmlspecialchars($tour['EndDate'] ?? '') ?></p>
                <p><strong>Mô tả:</strong> <?= nl2br(htmlspecialchars($tour['Description'] ?? '')) ?></p>
            </div>
        </div>

        <!-- Feature boxes -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm rounded-4 border-primary">
                    <div class="card-body text-center">
                        <h6 class="text-primary fw-bold">Nhật ký tour</h6>
                        <p class="small text-muted">Thêm/Cập nhật nhật ký, sự cố, hình ảnh</p>
                        <a href="?act=hdv-diary-form&id=<?= $tour['TourID'] ?>" class="btn btn-primary btn-sm">
                            <i class="bi bi-journal-plus"></i> Thêm nhật ký
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm rounded-4 border-success">
                    <div class="card-body text-center">
                        <h6 class="text-success fw-bold">Check-in/Check-out</h6>
                        <p class="small text-muted">Xác nhận trạng thái đoàn tại các điểm đến</p>
                        <a href="?act=hdv-checkin-checkout&id=<?= $tour['TourID'] ?>" class="btn btn-success btn-sm">
                            <i class="bi bi-check-circle"></i> Quản lý check-in/check-out
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm rounded-4 border-info">
                    <div class="card-body text-center">
                        <h6 class="text-info fw-bold">Yêu cầu đặc biệt</h6>
                        <p class="small text-muted">Yêu cầu ăn chay, sức khỏe, hỗ trợ đặc biệt</p>
                        <a href="?act=hdv-special-requests&id=<?= $tour['TourID'] ?>" class="btn btn-info btn-sm text-white">
                            <i class="bi bi-heart"></i> Quản lý yêu cầu
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Two-column layout -->
        <div class="row g-4">

            <!-- Left: Danh sách khách -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-info text-white">Danh sách khách</div>
                        <div class="card-body p-0">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Họ tên</th>
                                        <th>SĐT</th>
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
                                            <td colspan="3" class="text-center">Không có khách</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right: Nhật ký -->
                <div class="col-lg-6">
                    <div class="card shadow-sm rounded-4 h-100">
                        <div class="card-header bg-warning rounded-top-4 d-flex justify-content-between align-items-center">
                            <strong>Lịch trình/Nhật ký</strong>
                            <a href="?act=hdv-diary-form&id=<?= $tour['TourID'] ?>" class="btn btn-sm btn-light">
                                <i class="bi bi-plus-circle"></i> Thêm
                            </a>
                        </div>

                        <div class="card-body p-0" style="max-height: 430px; overflow-y: auto;">
                            <?php if (!empty($logs)): ?>
                                <div class="list-group list-group-flush">
                                    <?php foreach ($logs as $l): ?>
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between">
                                                <small class="text-muted"><?= $l['LogDate'] ?></small>
                                                <a href="?act=hdv-diary-form&id=<?= $tour['TourID'] ?>&log_id=<?= $l['LogID'] ?>"
                                                    class="btn btn-sm btn-outline-secondary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            </div>

                                            <p class="mt-2 mb-1"><?= nl2br(htmlspecialchars($l['Note'])) ?></p>

                                            <?php if (!empty($l['Incident'])): ?>
                                                <div class="alert alert-warning py-1 px-2 small mb-2">
                                                    <strong>Sự cố:</strong> <?= nl2br(htmlspecialchars($l['Incident'])) ?>
                                                </div>
                                            <?php endif; ?>

                                            <?php if (!empty($l['Images'])):
                                                $images = json_decode($l['Images'], true);
                                                if (!empty($images)): ?>
                                                    <div class="d-flex flex-wrap gap-2 mt-2">
                                                        <?php foreach ($images as $img): ?>
                                                            <img src="<?= $img ?>" class="img-thumbnail"
                                                                style="width:65px; height:65px; object-fit:cover;"
                                                                onclick="window.open('<?= $img ?>', '_blank')">
                                                        <?php endforeach; ?>
                                                    </div>
                                            <?php endif;
                                            endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                            <?php else: ?>
                                <div class="text-center p-4 text-muted">
                                    <p>Chưa có nhật ký</p>
                                    <a href="?act=hdv-diary-form&id=<?= $tour['TourID'] ?>" class="btn btn-primary btn-sm">
                                        Thêm nhật ký
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>

            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>