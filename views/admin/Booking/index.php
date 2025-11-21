<?php require_once __DIR__ . '/../sidebar.php'; ?>

<div class="container-fluid mt-4">
    <h2 class="mb-4 text-primary">Danh sách Booking</h2>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Mã</th>
                    <th scope="col">Khách</th>
                    <th scope="col">Tour</th>
                    <th scope="col">Ngày đặt</th>
                    <th scope="col">Tổng tiền</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($bookings)): ?>
                <?php foreach ($bookings as $b): ?>
                <tr>
                    <td><?= $b['BookingID'] ?></td>
                    <td><?= htmlspecialchars($b['CustomerName']) ?></td>
                    <td><?= htmlspecialchars($b['TourName']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($b['BookingDate'])) ?></td>
                    <td>
                        <?= $b['TotalAmount'] !== null ? number_format($b['TotalAmount'], 0, ',', '.') . ' đ' : '-' ?>
                    </td>
                    <td>
                        <span class="badge 
                                <?= $b['Status'] === 'Đang xử lý' ? 'bg-warning text-dark' : '' ?>
                                <?= $b['Status'] === 'Đã xác nhận' ? 'bg-success' : '' ?>
                                <?= $b['Status'] === 'Đã hủy' ? 'bg-danger' : '' ?>
                            ">
                            <?= htmlspecialchars($b['Status']) ?>
                        </span>
                    </td>
                    <td>
                        <a href="<?= BASE_URL ?>?act=booking-detail&id=<?= $b['BookingID'] ?>"
                            class="btn btn-sm btn-primary">
                            Chi tiết
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">Chưa có booking nào</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>