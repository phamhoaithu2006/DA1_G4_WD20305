<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<?php
$selectedTour = isset($_GET['tour_id']) ? $_GET['tour_id'] : '';
?>

<?php require_once __DIR__ . '/../navbar.php'; ?>

<div class="d-flex admin-layout">
    <div class="sidebar-wrapper bg-white shadow-sm border-end">
        <?php require_once __DIR__ . '/../sidebar.php'; ?>
    </div>

    <div class="admin-content flex-grow-1 p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Tạo Booking Mới</h2>
                <p class="text-muted mb-0">Nhập thông tin khách hàng và tour để tạo đơn đặt chỗ.</p>
            </div>
            <a href="?act=booking-list" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại danh sách
            </a>
        </div>

        <?php if (!empty($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <form method="post" action="<?= BASE_URL ?>?act=booking-create" class="needs-validation" novalidate>
            <div class="row g-4">

                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                            <h5 class="card-title fw-bold text-primary">
                                <span class="bg-primary-subtle text-primary rounded p-2 me-2">
                                    <i class="bi bi-person-vcard"></i>
                                </span>
                                Thông tin Khách hàng
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="form-floating mb-3">
                                <input type="text" name="fullname" class="form-control" id="fullname"
                                    placeholder="Nguyễn Văn A" required>
                                <label for="fullname">Họ và tên khách hàng</label>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" name="email" class="form-control" id="email"
                                            placeholder="name@example.com" required>
                                        <label for="email">Địa chỉ Email</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="phone" class="form-control" id="phone"
                                            placeholder="0901234567" required>
                                        <label for="phone">Số điện thoại</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" name="address" class="form-control" id="address"
                                    placeholder="Địa chỉ">
                                <label for="address">Địa chỉ liên hệ</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm h-100 bg-light-subtle">
                        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                            <h5 class="card-title fw-bold text-success">
                                <span class="bg-success-subtle text-success rounded p-2 me-2">
                                    <i class="bi bi-airplane"></i>
                                </span>
                                Thông tin Tour
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <label class="form-label fw-medium text-secondary small text-uppercase">Chọn Tour du
                                    lịch</label>
                                <select name="tour_id" class="form-select form-select-lg shadow-sm border-0" required>
                                    <option value="" selected disabled>-- Vui lòng chọn tour --</option>
                                    <?php foreach ($tours as $t): ?>
                                    <option value="<?= $t['TourID'] ?>"
                                        <?= ($t['TourID'] == $selectedTour ? 'selected' : '') ?>>
                                        <?= htmlspecialchars($t['TourName']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="form-text mt-2"><i class="bi bi-info-circle"></i> Giá tour sẽ được cập nhật
                                    tự động khi lưu.</div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium text-secondary small text-uppercase">Số lượng
                                    khách</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-white border-0"><i class="bi bi-people"></i></span>
                                    <input type="number" name="num_people" class="form-control border-0 shadow-sm"
                                        value="1" min="1" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium text-secondary small text-uppercase">Ghi chú
                                    thêm</label>
                                <textarea name="note" class="form-control border-0 shadow-sm" rows="4"
                                    placeholder="Yêu cầu đặc biệt (ăn chay, phòng đơn, v.v...)"></textarea>
                            </div>
                        </div>

                        <div class="card-footer bg-transparent border-0 p-4 pt-0">
                            <input type="hidden" name="group_members" id="group_members">
                            <button type="submit"
                                class="btn btn-primary w-100 py-3 fw-bold shadow text-uppercase letter-spacing-1">
                                <i class="bi bi-check2-circle me-2"></i> Xác nhận Booking
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<style>
/* Layout */
:root {
    --header-height: 70px;
    --sidebar-width: 260px;
}

body {
    background-color: #f5f7fa;
    font-family: 'Segoe UI', sans-serif;
    padding-top: var(--header-height);
}

.sidebar-wrapper {
    width: var(--sidebar-width);
    position: fixed;
    top: var(--header-height);
    bottom: 0;
    left: 0;
    z-index: 100;
    overflow-y: auto;
}

.admin-content {
    margin-left: var(--sidebar-width);
    min-height: calc(100vh - var(--header-height));
}

/* Form Styles */
.form-floating>.form-control:focus~label,
.form-floating>.form-control:not(:placeholder-shown)~label {
    color: #0d6efd;
    font-weight: 600;
}

.form-control:focus,
.form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
}

.letter-spacing-1 {
    letter-spacing: 1px;
}

/* Responsive */
@media (max-width: 992px) {
    .sidebar-wrapper {
        margin-left: calc(var(--sidebar-width) * -1);
    }

    .admin-content {
        margin-left: 0;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>