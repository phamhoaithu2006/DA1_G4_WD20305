<?php
// views/hdv/tour_list.php
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
    <title>Tour được phân công</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Hướng dẫn viên: <?= htmlspecialchars($hdvName) ?></a>
            <div class="d-flex">
                <a class="btn btn-outline-light btn-sm me-2" href="?act=hdv-logout">Đăng xuất</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h4>Danh sách tour được phân công</h4>
        <div class="card mt-3">
            <div class="card-body">
                <table class="table table-hover table-bordered">
                    <thead class="table-secondary">
                        <tr>
                            <th>Tour</th>
                            <th>Bắt đầu</th>
                            <th>Kết thúc</th>
                            <th>Loại</th>
                            <th>Nhà cung cấp</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tours)): foreach ($tours as $row): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['TourName']) ?></td>
                                    <td><?= htmlspecialchars($row['StartDate']) ?></td>
                                    <td><?= htmlspecialchars($row['EndDate']) ?></td>
                                    <td><?= htmlspecialchars($row['CategoryName']) ?></td>
                                    <td><?= htmlspecialchars($row['SupplierName']) ?></td>
                                    <td>
                                        <a class="btn btn-sm btn-info" href="?act=hdv-tour-detail&id=<?= $row['TourID'] ?>">Xem chi tiết</a>
                                    </td>
                                </tr>
                            <?php endforeach;
                        else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Không có tour được phân công</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>