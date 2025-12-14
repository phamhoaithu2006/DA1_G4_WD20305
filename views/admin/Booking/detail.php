<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/../navbar.php'; ?>

<div class="d-flex admin-layout">
    <div class="sidebar-wrapper bg-white shadow-sm border-end">
        <?php require_once __DIR__ . '/../sidebar.php'; ?>
    </div>

    <div class="admin-content flex-grow-1 p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="?act=booking-list" class="text-decoration-none">Booking</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Chi tiết #<?= $booking['BookingID'] ?></li>
                </ol>
            </nav>
            <a href="?act=booking-list" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                        <h5 class="fw-bold text-dark"><i class="bi bi-ticket-perforated text-primary me-2"></i>Thông tin
                            đơn hàng</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="text-muted small text-uppercase fw-bold">Khách hàng</label>
                                <div class="fs-5 fw-bold text-dark"><?= htmlspecialchars($booking['CustomerName']) ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small text-uppercase fw-bold">Ngày đặt</label>
                                <div class="fs-5 text-dark"><?= date('d/m/Y H:i', strtotime($booking['BookingDate'])) ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="text-muted small text-uppercase fw-bold">Tour đăng ký</label>
                                <div class="fs-5 text-primary fw-medium"><?= htmlspecialchars($booking['TourName']) ?>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 text-muted opacity-25">

                        <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded-3">
                            <span class="fw-bold text-secondary">Tổng thanh toán:</span>
                            <span class="fs-4 fw-bold text-success">
                                <?= $booking['TotalAmount'] !== null ? number_format($booking['TotalAmount'], 0, ',', '.') . ' VNĐ' : '-' ?>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                        <h5 class="fw-bold text-dark"><i class="bi bi-people text-info me-2"></i>Danh sách đoàn khách
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <?php if (!empty($tourCustomers)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">STT</th>
                                        <th>Họ và tên</th>
                                        <th>Phòng</th>
                                        <th class="pe-4">Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tourCustomers as $index => $tc): ?>
                                    <tr>
                                        <td class="ps-4 text-muted"><?= $index + 1 ?></td>
                                        <td class="fw-medium"><?= htmlspecialchars($tc['FullName']) ?></td>
                                        <td><span
                                                class="badge bg-light text-dark border"><?= htmlspecialchars($tc['RoomNumber'] ?? 'Chưa xếp') ?></span>
                                        </td>
                                        <td class="pe-4 text-muted small"><?= htmlspecialchars($tc['Note'] ?? '-') ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <div class="text-center py-4 text-muted">Chưa có thông tin thành viên đoàn</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <?php $isPaid = $booking['Status'] === 'Đã thanh toán'; ?>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                        <h5 class="fw-bold text-dark">Xử lý đơn hàng</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="post" action="index.php?act=booking-update-status">
                            <input type="hidden" name="booking_id" value="<?= $booking['BookingID'] ?>" />

                            <div class="mb-3">
                                <label class="form-label fw-medium">Trạng thái hiện tại</label>
                                <select name="status" class="form-select form-select-lg shadow-sm"
                                    <?= $isPaid ? 'disabled' : '' ?>>
                                    <?php
                                    $statuses = ['Đang xử lý', 'Đã xác nhận', 'Đã thanh toán', 'Đã hủy'];
                                    foreach ($statuses as $s): ?>
                                    <option value="<?= $s ?>" <?= $s == $booking['Status'] ? 'selected' : '' ?>>
                                        <?= $s ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <?php if ($isPaid): ?>
                            <div class="alert alert-success d-flex align-items-center small" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <div>Đơn hàng đã hoàn tất thanh toán.</div>
                            </div>
                            <?php else: ?>
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                                <i class="bi bi-arrow-repeat me-1"></i> Cập nhật trạng thái
                            </button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>