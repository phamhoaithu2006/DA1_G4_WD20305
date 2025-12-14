<?php
// $customers lấy từ controller truyền sang
// $tour lấy từ controller truyền sang
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

        <a href="?act=hdv-tour-detail&id=<?= $tour['TourID'] ?>"
            class="btn-back mb-4 w-100 d-block text-decoration-none text-center text-dark">
            <i class="bi bi-arrow-left"></i> Quay lại chi tiết Tour
        </a>

        <h3 class="fw-bold mb-4">Danh sách khách hàng & Yêu cầu</h3>

        <div class="table-responsive">
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
                                <div class="avatar-circle position-relative">
                                    <?= $initial ?>
                                    <?php if (!empty($c['Vegetarian'])): ?>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle"
                                        title="Ăn chay">
                                        <span class="visually-hidden">Ăn chay</span>
                                    </span>
                                    <?php endif; ?>
                                </div>
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
                            <?php if (!empty($c['Vegetarian'])): ?>
                            <span class="badge bg-success-subtle text-success border border-success-subtle mb-1">Ăn
                                chay</span><br>
                            <?php endif; ?>

                            <?php if (!empty($c['MedicalCondition'])): ?>
                            <div class="small text-danger"><i
                                    class="bi bi-heart-pulse-fill me-1"></i><?= htmlspecialchars($c['MedicalCondition']) ?>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($c['OtherRequests'])): ?>
                            <div class="text-primary small"><?= htmlspecialchars($c['OtherRequests']) ?></div>
                            <?php endif; ?>

                            <?php if (empty($c['Vegetarian']) && empty($c['MedicalCondition']) && empty($c['OtherRequests'])): ?>
                            <span class="text-muted small">Không</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php if (!empty($c['SpecialRequests'])): ?>
                            <span
                                class="text-secondary small fst-italic"><?= htmlspecialchars($c['SpecialRequests']) ?></span>
                            <?php else: ?>
                            <span class="text-muted small">---</span>
                            <?php endif; ?>
                        </td>

                        <td class="pe-4 text-end">
                            <button class="btn-edit" data-bs-toggle="modal"
                                data-bs-target="#editModal<?= $c['CustomerID'] ?>">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                        </td>
                    </tr>

                    <div class="modal fade" id="editModal<?= $c['CustomerID'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">

                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold">Thông tin khách hàng</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <form method="POST" action="?act=hdv-special-request-save&id=<?= $tour['TourID'] ?>">
                                    <div class="modal-body">
                                        <input type="hidden" name="customer_id" value="<?= $c['CustomerID'] ?>">

                                        <div class="mb-3">
                                            <label class="form-label fw-bold small text-muted text-uppercase">Họ và
                                                tên</label>
                                            <input type="text" name="FullName" class="form-control"
                                                value="<?= htmlspecialchars($c['FullName'] ?? '') ?>" required>
                                        </div>

                                        <div class="row g-2 mb-3">
                                            <div class="col-6">
                                                <label class="form-label fw-bold small text-muted text-uppercase">Số
                                                    điện thoại</label>
                                                <input type="text" name="Phone" class="form-control"
                                                    value="<?= htmlspecialchars($c['Phone'] ?? '') ?>">
                                            </div>
                                            <div class="col-6">
                                                <label
                                                    class="form-label fw-bold small text-muted text-uppercase">Phòng</label>
                                                <input type="text" name="RoomNumber" class="form-control"
                                                    value="<?= htmlspecialchars($c['RoomNumber'] ?? '') ?>">
                                            </div>
                                        </div>

                                        <hr class="opacity-25 my-4">

                                        <div class="mb-3">
                                            <div
                                                class="form-check form-switch p-3 bg-light rounded-3 d-flex justify-content-between align-items-center">
                                                <label class="form-check-label fw-bold text-dark m-0"
                                                    for="veg<?= $c['CustomerID'] ?>">
                                                    <i class="bi bi-flower1 me-2 text-success"></i>Yêu cầu Ăn chay
                                                </label>
                                                <input class="form-check-input m-0" type="checkbox" role="switch"
                                                    id="veg<?= $c['CustomerID'] ?>" name="vegetarian" value="1"
                                                    <?= !empty($c['Vegetarian']) ? 'checked' : '' ?>>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold small text-muted text-uppercase">Tình trạng
                                                sức khỏe</label>
                                            <input type="text" name="medical_condition" class="form-control"
                                                placeholder="VD: Say xe, dị ứng hải sản..."
                                                value="<?= htmlspecialchars($c['MedicalCondition'] ?? '') ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold small text-muted text-uppercase">Yêu cầu
                                                khác</label>
                                            <textarea name="other_requests" class="form-control"
                                                rows="2"><?= htmlspecialchars($c['OtherRequests'] ?? '') ?></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold small text-muted text-uppercase">Ghi chú
                                                nội bộ (HDV)</label>
                                            <textarea name="note" class="form-control bg-light" rows="2"
                                                placeholder="Ghi chú riêng của HDV..."><?= htmlspecialchars($c['SpecialRequests'] ?? '') ?></textarea>
                                        </div>
                                    </div>

                                    <div class="modal-footer border-0 pt-0">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-primary px-4 fw-bold">Lưu thay đổi</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <div class="d-flex flex-column align-items-center">
                                <i class="bi bi-people display-4 opacity-25 mb-3"></i>
                                <p>Chưa có thông tin khách hàng nào.</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>