<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<!-- Navbar -->
<?php require_once __DIR__ . '/../../navbar.php'; ?>

<div class="d-flex admin-layout">

    <!-- Sidebar -->
    <div class="sidebar-wrapper bg-light border-end">
        <?php require_once __DIR__ . '/../../sidebar.php'; ?>
    </div>

    <!-- Content -->
    <div class="admin-content flex-grow-1 p-4">

        <h2 class="page-title mb-4">
            Thêm khách vào tour
        </h2>

        <!-- Form Card -->
        <div class="card shadow-sm form-card">
            <div class="card-body p-4">

                <form method="post">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Chọn khách</label>
                        <select name="customerID" class="form-select form-control-rounded" required>
                            <?php foreach ($allCustomers as $cust): ?>
                                <option value="<?= $cust['CustomerID'] ?>">
                                    <?= htmlspecialchars($cust['FullName'] ?? '') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Phòng khách sạn</label>
                        <input type="text" name="roomNumber" class="form-control form-control-rounded" placeholder="VD: 100A">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ghi chú đặc biệt</label>
                        <textarea
                            name="note"
                            class="form-control form-control-rounded"
                            rows="3"
                            placeholder="Ăn chay, bệnh lý, yêu cầu riêng, ..."></textarea>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-check-circle"></i> Thêm khách
                        </button>

                        <a href="<?= BASE_URL ?>?act=tourcustomers&tourID=<?= $tourID ?>"
                            class="btn btn-secondary px-4">
                            <i class="bi bi-arrow-left"></i> Quay lại
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

<style>
    .admin-layout {
        min-height: 100vh;
    }

    .page-title {
        font-weight: 700;
        color: #0d6efd;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-card {
        border-radius: 14px;
        border: none;
    }

    .form-control-rounded,
    .form-select.form-control-rounded {
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 15px;
    }

    .form-control-rounded:focus,
    .form-select.form-control-rounded:focus {
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    }

    /* Hover nhẹ cho card */
    .form-card:hover {
        transform: translateY(-2px);
        transition: 0.25s ease;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    }
</style>