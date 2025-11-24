<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/../../navbar.php'; ?>

<div class="d-flex admin-layout">

    <!-- Sidebar -->
    <div class="sidebar-wrapper">
        <?php require_once __DIR__ . '/../../sidebar.php'; ?>
    </div>

    <!-- Content -->
    <div class="admin-content flex-grow-1 p-4">

        <h2 class="text-primary mb-4">
            <i class="bi bi-person-badge"></i> Chi tiết nhân sự
        </h2>

        <div class="shadow-sm rounded bg-white p-4">

            <div class="mb-3">
                <label class="fw-bold">Họ tên:</label>
                <div><?= htmlspecialchars($employee['FullName']) ?></div>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Chức vụ:</label>
                <div><?= htmlspecialchars($employee['Role']) ?></div>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Số điện thoại:</label>
                <div><?= htmlspecialchars($employee['Phone']) ?></div>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Email:</label>
                <div><?= htmlspecialchars($employee['Email'] ?? 'Không có dữ liệu') ?></div>
            </div>

            <a href="<?= BASE_URL ?>?act=employees" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>

        </div>
    </div>
</div>