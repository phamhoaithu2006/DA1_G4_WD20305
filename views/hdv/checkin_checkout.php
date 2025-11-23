<?php
// views/hdv/Diary/checkin_checkout.php
// Trang xác nhận check-in/check-out đoàn của HDV

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Lấy dữ liệu từ phiên và URL
$hdvName  = $_SESSION['hdv_name'] ?? 'HDV';
$tourId   = $_GET['id'] ?? null;

// Thông báo
$error    = $_SESSION['hdv_error'] ?? null;
$success  = $_SESSION['hdv_success'] ?? null;
unset($_SESSION['hdv_error'], $_SESSION['hdv_success']); // Xóa sau khi dùng
?>

<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Check-in/Check-out đoàn</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="?act=hdv-tour">Hướng dẫn viên: <?= htmlspecialchars($hdvName) ?></a>
            <div class="d-flex">
                <a class="btn btn-outline-light btn-sm me-2" href="?act=hdv-tour">Danh sách tour</a>
                <a class="btn btn-outline-light btn-sm" href="?act=hdv-logout">Đăng xuất</a>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">

                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-check-circle"></i>
                            Xác nhận check-in/check-out đoàn
                        </h5>
                    </div>

                    <div class="card-body">

                        <!-- Thông báo -->
                        <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <?= htmlspecialchars($error) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if ($success): ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <?= htmlspecialchars($success) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <div class="row g-3">

                            <!-- Check-in -->
                            <div class="col-md-6">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-white">
                                        <h6 class="mb-0">
                                            <i class="bi bi-box-arrow-in-right"></i> Check-in
                                        </h6>
                                    </div>

                                    <div class="card-body">
                                        <p class="text-muted small">Xác nhận đoàn đã đến điểm</p>

                                        <form method="post" action="?act=hdv-checkin-save&id=<?= $tourId ?>">
                                            <div class="mb-3">
                                                <label class="form-label">Địa điểm</label>
                                                <input type="text" name="checkin_location" class="form-control" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Ghi chú</label>
                                                <textarea name="checkin_note" class="form-control" rows="3"></textarea>
                                            </div>

                                            <button class="btn btn-primary w-100">
                                                <i class="bi bi-check-circle"></i> Xác nhận check-in
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Check-out -->
                            <div class="col-md-6">
                                <div class="card border-danger">
                                    <div class="card-header bg-danger text-white">
                                        <h6 class="mb-0">
                                            <i class="bi bi-box-arrow-right"></i> Check-out
                                        </h6>
                                    </div>

                                    <div class="card-body">
                                        <p class="text-muted small">Xác nhận đoàn đã rời điểm</p>

                                        <form method="post" action="?act=hdv-checkout-save&id=<?= $tourId ?>">
                                            <div class="mb-3">
                                                <label class="form-label">Địa điểm</label>
                                                <input type="text" name="checkout_location" class="form-control" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Ghi chú</label>
                                                <textarea name="checkout_note" class="form-control" rows="3"></textarea>
                                            </div>

                                            <button class="btn btn-danger w-100">
                                                <i class="bi bi-x-circle"></i> Xác nhận check-out
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Lịch sử -->
                        <?php if (!empty($checkinHistory)): ?>
                            <div class="mt-4">
                                <h6 class="mb-3">Lịch sử check-in/check-out</h6>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Thời gian</th>
                                                <th>Loại</th>
                                                <th>Địa điểm</th>
                                                <th>Ghi chú</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($checkinHistory as $row): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($row['CreatedAt']) ?></td>
                                                    <td>
                                                        <?php if ($row['Type'] === 'checkin'): ?>
                                                            <span class="badge bg-primary">Check-in</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger">Check-out</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <?php
                                                    $locVal = isset($row['Location']) ? $row['Location'] : null;
                                                    if ($locVal === null && !empty($row['Note'])) {
                                                        $firstPart = explode('|', $row['Note'])[0];
                                                        if (strpos($firstPart, 'Địa điểm:') === 0) {
                                                            $locVal = trim(substr($firstPart, strlen('Địa điểm:')));
                                                        }
                                                    }
                                                    $noteVal = isset($row['Note']) ? $row['Note'] : '';
                                                    if (strpos($noteVal, 'Địa điểm:') === 0) {
                                                        $parts = explode('|', $noteVal, 2);
                                                        $noteVal = isset($parts[1]) ? trim($parts[1]) : '';
                                                    }
                                                    ?>
                                                    <td><?= htmlspecialchars($locVal ?? '') ?></td>
                                                    <td><?= htmlspecialchars($noteVal) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Back -->
                        <div class="mt-3">
                            <a href="?act=hdv-tour-detail&id=<?= $tourId ?>" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Quay lại
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>