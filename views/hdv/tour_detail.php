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
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="?act=hdv-tour">HDV - <?= htmlspecialchars($hdvName) ?></a>
            <div class="d-flex">
                <a class="btn btn-outline-light btn-sm me-2" href="?act=hdv-logout">Đăng xuất</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <a href="?act=hdv-tour" class="btn btn-secondary btn-sm mb-3">&larr; Quay lại</a>

        <div class="card">
            <div class="card-header">
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
                                        <td colspan="3" class="text-center">Không có khách.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-warning">Lịch trình/Nhật ký</div>
                    <div class="card-body p-0">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Ngày/Giờ</th>
                                    <th>Ghi chú</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($logs)): foreach ($logs as $l): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($l['LogDate']) ?></td>
                                            <td><?= htmlspecialchars($l['Note']) ?></td>
                                        </tr>
                                    <?php endforeach;
                                else: ?>
                                    <tr>
                                        <td colspan="2" class="text-center">Chưa có nhật ký</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

</html>