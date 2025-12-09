<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$hdv_error = $_SESSION['hdv_error'] ?? null;
$hdv_success = $_SESSION['hdv_success'] ?? null;
unset($_SESSION['hdv_error'], $_SESSION['hdv_success']);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách khách hàng</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-soft: #eef2ff;
            --danger-soft: #fdecea;
            --radius: 16px;
            --muted: #6b7280;
        }

        body {
            background: #f5f6fa;
            font-family: "Inter", sans-serif;
        }

        .btn-back {
            background: white;
            border: 1px solid #ddd;
            padding: 10px 18px;
            border-radius: 12px;
            transition: 0.25s;
            font-weight: 500;
        }

        .btn-back:hover {
            background: var(--primary-soft);
            color: var(--primary);
        }

        .table {
            border-collapse: separate;
            border-spacing: 0 14px;
        }

        tbody tr {
            background: #fff;
            border-radius: var(--radius);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            transition: 0.25s;
        }

        tbody tr:hover {
            background: #f0f1ff !important;
        }

        tbody tr td:first-child {
            border-top-left-radius: var(--radius);
            border-bottom-left-radius: var(--radius);
        }

        tbody tr td:last-child {
            border-top-right-radius: var(--radius);
            border-bottom-right-radius: var(--radius);
        }

        thead th {
            font-weight: 600;
            color: var(--muted);
        }

        .avatar-circle {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: var(--primary);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 600;
            margin-right: 14px;
            font-size: 18px;
        }

        .badge-room {
            background: var(--primary-soft);
            color: var(--primary);
            padding: 8px 16px;
            border-radius: 14px;
            font-weight: 600;
        }

        .btn-edit {
            width: 40px;
            height: 40px;
            background: #f0f2f7;
            border-radius: 50%;
            border: none;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            transition: 0.2s;
        }

        .btn-edit:hover {
            background: var(--primary-soft);
            color: var(--primary);
            transform: scale(1.05);
        }

        .modal-content {
            border-radius: 16px;
        }
    </style>
</head>

<body>

    <div class="container py-4">

        <a class="btn-back mb-4 w-100 d-inline-block text-decoration-none" href="?act=hdv-tour-detail&id=<?= urlencode($tourId ?? '') ?>">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>

        <h3 class="fw-bold mb-4">Danh sách khách hàng</h3>

        <?php if (!empty($hdv_success)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($hdv_success) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (!empty($hdv_error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($hdv_error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <table class="table align-middle">
            <thead>
                <tr>
                    <th class="ps-4">Khách hàng</th>
                    <th class="text-center">Phòng</th>
                    <th>Yêu cầu khác</th>
                    <th>Ghi chú</th>
                    <th class="pe-4 text-end">Sửa</th>
                </tr>
            </thead>

            <tbody>

                <?php if (!empty($customers)): ?>
                    <?php foreach ($customers as $c): ?>

                        <?php
                        $name = $c['FullName'] ?? '';
                        $parts = explode(' ', trim($name));
                        $initial = $parts && $parts[0] !== '' ? strtoupper(substr(end($parts), 0, 1)) : "?";
                        ?>

                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle"><?= $initial ?></div>
                                    <div>
                                        <div class="fw-bold"><?= htmlspecialchars($c['FullName'] ?? '') ?></div>
                                        <div class="text-muted small"><?= htmlspecialchars($c['Phone'] ?? '') ?></div>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center">
                                <span class="badge-room">
                                    <?= htmlspecialchars($c['RoomNumber'] ?? '--') ?>
                                </span>
                            </td>

                            <td>
                                <?php if (!empty($c['OtherRequests'])): ?>
                                    <span class="text-primary small"><?= htmlspecialchars($c['OtherRequests']) ?></span>
                                <?php else: ?>
                                    <span class="text-muted small">Không</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if (!empty($c['SpecialRequests'])): ?>
                                    <span class="text-secondary small fst-italic"><?= htmlspecialchars($c['SpecialRequests']) ?></span>
                                <?php else: ?>
                                    <span class="text-muted small">Không</span>
                                <?php endif; ?>
                            </td>

                            <td class="pe-4 text-end">
                                <button class="btn-edit" data-bs-toggle="modal"
                                    data-bs-target="#editModal<?= $c['CustomerID'] ?>">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="editModal<?= $c['CustomerID'] ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Chỉnh sửa khách hàng</h5>
                                        <button class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form method="POST" action="?act=hdv-special-request-save&id=<?= urlencode($tourId ?? '') ?>">
                                        <div class="modal-body">

                                            <input type="hidden" name="customer_id" value="<?= $c['CustomerID'] ?>">

                                            <label class="form-label mt-2">Họ tên</label>
                                            <input type="text" name="FullName" class="form-control"
                                                value="<?= htmlspecialchars($c['FullName'] ?? '') ?>">

                                            <label class="form-label mt-3">Số điện thoại</label>
                                            <input type="text" name="Phone" class="form-control"
                                                value="<?= htmlspecialchars($c['Phone'] ?? '') ?>">

                                            <label class="form-label mt-3">Phòng</label>
                                            <input type="text" name="RoomNumber" class="form-control"
                                                value="<?= htmlspecialchars($c['RoomNumber'] ?? '') ?>">

                                            <label class="form-label mt-3">Yêu cầu khác</label>
                                            <textarea name="other_requests" class="form-control"><?= htmlspecialchars($c['OtherRequests'] ?? '') ?></textarea>

                                            <label class="form-label mt-3">Ghi chú</label>
                                            <textarea name="note" class="form-control"><?= htmlspecialchars($c['SpecialRequests'] ?? '') ?></textarea>

                                            <input type="hidden" name="medical_condition" value="<?= htmlspecialchars($c['MedicalCondition'] ?? '') ?>">
                                            <input type="hidden" name="vegetarian" value="<?= (int)($c['Vegetarian'] ?? 0) ?>">

                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                            <button class="btn btn-primary">Lưu</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php else: ?>

                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            Không có khách hàng nào.
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>
        </table>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
