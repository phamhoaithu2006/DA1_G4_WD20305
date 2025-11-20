<?php
// views/hdv/Diary/special_requests.php
// Trang cập nhật yêu cầu đặc biệt của khách

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$hdvName = $_SESSION['hdv_name'] ?? 'HDV';
$tourId = $_GET['id'] ?? null;
$error = $_SESSION['hdv_error'] ?? null;
$success = $_SESSION['hdv_success'] ?? null;
unset($_SESSION['hdv_error'], $_SESSION['hdv_success']);
?>

<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Yêu cầu đặc biệt của khách</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="?act=hdv-tour-detail&id=<?= $tourId ?>">HDV - <?= htmlspecialchars($hdvName) ?></a>
            <div class="d-flex">
                <a class="btn btn-outline-light btn-sm me-2" href="?act=hdv-tour">Danh sách tour</a>
                <a class="btn btn-outline-light btn-sm me-2" href="?act=hdv-logout">Đăng xuất</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-9">
                <div class="card shadow">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-heart"></i> Cập nhật yêu cầu đặc biệt của khách</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($error) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if ($success): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($success) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($customers)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Họ tên</th>
                                            <th>SĐT</th>
                                            <th>Phòng</th>
                                            <th>Yêu cầu đặc biệt</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($customers as $customer): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($customer['FullName']) ?></td>
                                                <td><?= htmlspecialchars($customer['Phone']) ?></td>
                                                <td><?= htmlspecialchars($customer['RoomNumber'] ?? '-') ?></td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?php if (!empty($customer['SpecialRequests'])): ?>
                                                            <?= nl2br(htmlspecialchars($customer['SpecialRequests'])) ?>
                                                        <?php else: ?>
                                                            <span class="text-muted">Chưa có</span>
                                                        <?php endif; ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal<?= $customer['CustomerID'] ?>">
                                                        <i class="bi bi-pencil"></i> Cập nhật
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Modal cập nhật yêu cầu -->
                                            <div class="modal fade" id="editModal<?= $customer['CustomerID'] ?>" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Cập nhật yêu cầu đặc biệt</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <form method="post" action="?act=hdv-special-request-save&id=<?= $tourId ?>">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="customer_id" value="<?= $customer['CustomerID'] ?>">

                                                                <div class="mb-3">
                                                                    <label class="form-label">Khách hàng</label>
                                                                    <input type="text" class="form-control" value="<?= htmlspecialchars($customer['FullName']) ?>" readonly>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Ăn chay</label>
                                                                    <select class="form-select" name="vegetarian">
                                                                        <option value="0" <?= ($customer['Vegetarian'] ?? 0) == 0 ? 'selected' : '' ?>>Không</option>
                                                                        <option value="1" <?= ($customer['Vegetarian'] ?? 0) == 1 ? 'selected' : '' ?>>Có</option>
                                                                    </select>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Bệnh lý/Sức khỏe</label>
                                                                    <textarea class="form-control" name="medical_condition" rows="3" placeholder="Nhập thông tin bệnh lý, tình trạng sức khỏe..."><?= htmlspecialchars($customer['MedicalCondition'] ?? '') ?></textarea>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Yêu cầu khác</label>
                                                                    <textarea class="form-control" name="other_requests" rows="3" placeholder="Các yêu cầu đặc biệt khác..."><?= htmlspecialchars($customer['OtherRequests'] ?? '') ?></textarea>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Ghi chú</label>
                                                                    <textarea class="form-control" name="note" rows="2"><?= htmlspecialchars($customer['Note'] ?? '') ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> Không có khách hàng trong tour này
                            </div>
                        <?php endif; ?>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>