<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/../navbar.php'; ?>

<div class="d-flex admin-layout">

    <!-- Sidebar -->
    <div class="sidebar-wrapper">
        <?php require_once __DIR__ . '/../sidebar.php'; ?>
    </div>

    <!-- Content -->
    <div class="admin-content flex-grow-1 p-4">

        <div class="container-fluid">

            <h2 class="mb-4 text-primary fw-bold">
                Chi tiết booking số: <?= htmlspecialchars($booking['BookingID']) ?>
            </h2>

            <!-- Card thông tin booking -->
            <div class="card shadow-sm rounded-4 mb-4">
                <div class="card-body">
                    <p><strong>Khách đặt:</strong> <?= htmlspecialchars($booking['CustomerName']) ?></p>
                    <p><strong>Tour:</strong> <?= htmlspecialchars($booking['TourName']) ?></p>
                    <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($booking['BookingDate'])) ?></p>
                    <p>
                        <strong>Tổng tiền:</strong>
                        <?= $booking['TotalAmount'] !== null ? number_format($booking['TotalAmount'], 0, ',', '.') . ' VNĐ' : '-' ?>
                    </p>
                    <p>
                        <strong>Trạng thái:</strong>
                        <span class="badge 
                            <?= $booking['Status'] === 'Đang xử lý' ? 'bg-warning text-dark' : '' ?>
                            <?= $booking['Status'] === 'Đã xác nhận' ? 'bg-info text-white' : '' ?>
                            <?= $booking['Status'] === 'Đã thanh toán' ? 'bg-success' : '' ?>
                            <?= $booking['Status'] === 'Đã hủy' ? 'bg-danger' : '' ?>
                        ">
                            <?= htmlspecialchars($booking['Status']) ?>
                        </span>
                    </p>
                </div>
            </div>

            <!-- Cập nhật trạng thái -->
            <div class="card shadow-sm rounded-4 p-4 mb-4">
                <h4 class="fw-bold mb-3"><i class="bi bi-arrow-repeat"></i> Cập nhật trạng thái</h4>
                <form method="post" action="index.php?act=booking-update-status" class="row g-3 align-items-center">
                    <input type="hidden" name="booking_id" value="<?= $booking['BookingID'] ?>" />
                    <div class="col-md-4">
                        <select name="status" class="form-select shadow-sm">
                            <?php
                            $statuses = ['Đang xử lý', 'Đã xác nhận', 'Đã thanh toán', 'Đã hủy'];
                            foreach ($statuses as $s): ?>
                                <option value="<?= $s ?>" <?= $s == $booking['Status'] ? 'selected' : '' ?>><?= $s ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-check-circle"></i> Cập nhật
                        </button>
                    </div>
                </form>
            </div>

            <!-- Danh sách khách -->
            <div class="card shadow-sm rounded-4 p-4">
                <h4 class="fw-bold mb-3"><i class="bi bi-people"></i> Danh sách khách trong tour</h4>

                <?php if (!empty($tourCustomers)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>STT</th>
                                    <th>Họ và tên</th>
                                    <th>Phòng</th>
                                    <th>Ghi chú</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tourCustomers as $index => $tc): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= htmlspecialchars($tc['FullName']) ?></td>
                                        <td><?= htmlspecialchars($tc['RoomNumber'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($tc['Note'] ?? '-') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Không có dữ liệu khách đoàn</p>
                <?php endif; ?>

            </div>

        </div>
    </div>
</div>

<style>
    .admin-layout {
        min-height: 100vh;
        background-color: #f8f9fa;
    }

    .sidebar-wrapper {
        width: 260px;
        min-height: 100vh;
        background: #fff;
        border-right: 1px solid #ddd;
    }

    .admin-content {
        background-color: #f8f9fa;
    }

    .card {
        border: none;
    }

    .card-body p {
        font-size: 1rem;
        margin-bottom: 8px;
    }

    table thead {
        font-weight: bold;
    }
</style>