<?php require_once __DIR__ . '/../sidebar.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4 text-primary">Chi tiết Booking #<?= htmlspecialchars($booking['BookingID']) ?></h2>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Khách đặt:</strong> <?= htmlspecialchars($booking['CustomerName']) ?></p>
            <p><strong>Tour:</strong> <?= htmlspecialchars($booking['TourName']) ?></p>
            <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($booking['BookingDate'])) ?></p>
            <p><strong>Tổng tiền:</strong>
                <?= $booking['TotalAmount'] !== null ? number_format($booking['TotalAmount'],0,',','.') . ' đ' : '-' ?>
            </p>
            <p><strong>Trạng thái:</strong>
                <span class="badge 
                    <?= $booking['Status'] === 'Đang xử lý' ? 'bg-warning text-dark' : '' ?>
                    <?= $booking['Status'] === 'Xác nhận' ? 'bg-info text-white' : '' ?>
                    <?= $booking['Status'] === 'Đã thanh toán' ? 'bg-success' : '' ?>
                    <?= $booking['Status'] === 'Đã hủy' ? 'bg-danger' : '' ?>
                ">
                    <?= htmlspecialchars($booking['Status']) ?>
                </span>
            </p>
        </div>
    </div>

    <h4>Cập nhật trạng thái</h4>
    <form method="post" action="index.php?act=booking-update-status" class="mb-4 row g-3 align-items-center">
        <input type="hidden" name="booking_id" value="<?= $booking['BookingID'] ?>" />
        <div class="col-auto">
            <select name="status" class="form-select">
                <?php
                $statuses = ['Đang xử lý','Xác nhận','Đã thanh toán','Đã hủy'];
                foreach ($statuses as $s): ?>
                <option value="<?= $s ?>" <?= $s == $booking['Status'] ? 'selected' : '' ?>><?= $s ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-success">Cập nhật</button>
        </div>
    </form>

    <h4>Danh sách khách trong tour</h4>
    <?php if (!empty($tourCustomers)): ?>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
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
    <p>Không có dữ liệu khách đoàn.</p>
    <?php endif; ?>
</div>