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
    <title>Tour được phân công</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            background: #f5f7fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            border-radius: 0 0 12px 12px;
        }

        .navbar .navbar-brand {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
        }

        .page-title {
            font-weight: 700;
            color: #1f2937;
            text-align: center;
            font-size: 25px;
            margin-bottom: 25px;

        }

        .tour-card {
            border-radius: 14px;
            border: none;
            overflow: hidden;
            background: #fff;
        }

        .tour-card .card-body {
            padding: 22px;
        }

        .table thead {
            background: #0dcaf0;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f7ff;
        }

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
            <div class="ms-auto">
                <a class="btn btn-light btn-sm" href="?act=hdv-logout">
                    Đăng xuất
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">

        <h3 class="page-title">Danh sách tour được phân công</h3>

        <div class="card shadow-soft tour-card">
            <div class="card-body">

                <table class="table table-hover table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Tour</th>
                            <th>Bắt đầu</th>
                            <th>Kết thúc</th>
                            <th>Loại</th>
                            <th>Nhà cung cấp</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($tours)): ?>
                            <?php foreach ($tours as $row): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['TourName']) ?></td>
                                    <td><?= htmlspecialchars($row['StartDate']) ?></td>
                                    <td><?= htmlspecialchars($row['EndDate']) ?></td>
                                    <td><?= htmlspecialchars($row['CategoryName']) ?></td>
                                    <td><?= htmlspecialchars($row['SupplierName']) ?></td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-info text-white"
                                            href="?act=hdv-tour-detail&id=<?= $row['TourID'] ?>">
                                            Xem chi tiết
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">
                                    Không có tour được phân công
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</body>

</html>