<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/../../main.php'; ?>
<?php 
    $selectedTour = isset($_GET['tour_id']) ? $_GET['tour_id'] : '';
?>


<div class="d-flex admin-layout">

    <!-- Sidebar -->
    <div class="sidebar-wrapper">

    </div>

    <!-- Content -->
    <div class="admin-content container mt-4">

        <h2 class="page-title text-primary mb-4">Tạo booking mới</h2>

        <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="card shadow-sm booking-card">
            <div class="card-body p-4">

                <form method="post" action="<?= BASE_URL ?>?act=booking-create">

                    <!-- 2 cột -->
                    <div class="row g-4">

                        <!-- Cột trái -->
                        <div class="col-lg-6">

                            <h5 class="section-title"><i class="bi bi-person-check"></i> Khách hàng</h5>


                            <div class="mb-3">
                                <label class="form-label fw-semibold">Họ tên</label>
                                <input type="text" name="fullname" class="form-control form-control-lg-rounded">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control form-control-lg-rounded">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control form-control-lg-rounded">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Địa chỉ</label>
                                <input type="text" name="address" class="form-control form-control-lg-rounded">
                            </div>

                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Chọn tour</label>
                            <select name="tour_id" class="form-select form-control-lg-rounded" required>
                                <option value="">- Chọn tour -</option>

                                <?php foreach ($tours as $t): ?>
                                <option value="<?= $t['TourID'] ?>"
                                    <?= ($t['TourID'] == $selectedTour ? 'selected' : '') ?>>
                                    <?= htmlspecialchars($t['TourName']) ?>
                                    (<?= number_format($t['Price'], 0, ',', '.') ?> VNĐ)
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label class="form-label fw-semibold">Số người</label>
                            <input type="number" name="num_people" class="form-control form-control-lg-rounded"
                                value="1" min="1">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ghi chú</label>
                            <textarea name="note" class="form-control form-control-lg-rounded" rows="4"></textarea>
                        </div>

                    </div>

            </div>

            <input type="hidden" name="group_members" id="group_members">

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill fw-semibold">
                    <i class="bi bi-check-circle"></i> Tạo booking
                </button>
            </div>

            </form>

        </div>
    </div>

</div>
</div>


<style>
.admin-layout {
    display: flex;
    min-height: 100vh;
    background: #f5f7fa;
}

.sidebar-wrapper {
    width: 260px;
}

.admin-content {
    flex-grow: 1;
}

.page-title {
    font-weight: 700;
}

.booking-card {
    border-radius: 14px;
    background: #ffffff;
    border: none;
}

.form-control-lg-rounded,
.form-select.form-control-lg-rounded {
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 15px;
}

.section-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #0d6efd;
    margin-bottom: 15px;
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    transition: 0.25s ease;
}
</style>