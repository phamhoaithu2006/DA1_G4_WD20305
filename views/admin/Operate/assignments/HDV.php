<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách Hướng dẫn viên</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body class="bg-light">

    <?php require_once __DIR__ . '/../../navbar.php'; ?>

    <div class="d-flex admin-layout">
        <div class="sidebar-wrapper bg-white shadow-sm border-end">
            <?php require_once __DIR__ . '/../../sidebar.php'; ?>
        </div>

        <div class="admin-content flex-grow-1 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-dark">Danh sách Hướng dẫn viên</h2>
                <a href="?act=createEmployee" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Thêm mới</a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Họ tên</th>
                                <th>Liên hệ</th>
                                <th>Tour đang phụ trách</th>
                                <th>Thời gian</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data)): ?>
                                <?php foreach ($data as $index => $hdv): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td class="fw-bold"><?= htmlspecialchars($hdv['FullName']) ?></td>
                                        <td>
                                            <div><i class="bi bi-telephone me-1"></i> <?= htmlspecialchars($hdv['Phone']) ?>
                                            </div>
                                            <div class="small text-muted"><?= htmlspecialchars($hdv['Email']) ?></div>
                                        </td>
                                        <td><?= isset($hdv['TourName']) ? htmlspecialchars($hdv['TourName']) : '<span class="text-muted">Đang rảnh</span>' ?>
                                        </td>
                                        <td class="small text-muted">
                                            <?php if (isset($hdv['StartDate'])): ?>
                                                <?= date('d/m', strtotime($hdv['StartDate'])) ?> -
                                                <?= date('d/m/Y', strtotime($hdv['EndDate'])) ?>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="?act=detailEmployee&id=<?= $hdv['EmployeeID'] ?? 0 ?>"
                                                class="btn btn-sm btn-outline-info">Chi tiết</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Chưa có dữ liệu Hướng dẫn viên</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>