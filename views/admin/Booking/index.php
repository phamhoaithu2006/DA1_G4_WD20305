<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/../navbar.php'; ?>

<div class="d-flex admin-layout">
    <div class="sidebar-wrapper bg-white shadow-sm border-end">
        <?php require_once __DIR__ . '/../sidebar.php'; ?>
    </div>

    <div class="admin-content flex-grow-1 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Quản lý Booking</h2>
                <p class="text-muted mb-0">Danh sách các đơn đặt tour từ khách hàng</p>
            </div>
            <a href="?act=booking-create" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-lg me-1"></i> Tạo Booking mới
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-secondary text-uppercase small fw-bold">Mã đơn</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold">Khách hàng</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold" style="width: 25%;">Tour
                                    đăng ký</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold">Ngày đặt</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold text-end">Tổng tiền</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold text-center">Trạng thái</th>
                                <th class="pe-4 py-3 text-secondary text-uppercase small fw-bold text-center">Hành động
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($bookings)): ?>
                                <?php foreach ($bookings as $b):
                                    // 1. LOGIC TRẠNG THÁI (STATUS MAPPING) - Cấu hình màu sắc tại đây cho gọn
                                    $statusMap = [
                                        'Đang xử lý'    => ['class' => 'bg-warning-subtle text-warning-emphasis', 'icon' => 'bi-hourglass-split'],
                                        'Đã xác nhận'   => ['class' => 'bg-info-subtle text-info-emphasis', 'icon' => 'bi-check-circle'],
                                        'Đã thanh toán' => ['class' => 'bg-success-subtle text-success-emphasis', 'icon' => 'bi-cash-coin'],
                                        'Đã hủy'        => ['class' => 'bg-danger-subtle text-danger-emphasis', 'icon' => 'bi-x-circle'],
                                        'Hoàn tất'      => ['class' => 'bg-primary-subtle text-primary-emphasis', 'icon' => 'bi-flag-fill']
                                    ];

                                    // Lấy config trạng thái, nếu không có trong danh sách thì dùng default
                                    $currentStatus = $statusMap[$b['Status']] ?? ['class' => 'bg-secondary-subtle text-secondary', 'icon' => 'bi-circle'];

                                    // Xử lý avatar chữ cái đầu
                                    $firstLetter = strtoupper(substr($b['CustomerName'] ?? 'K', 0, 1));
                                ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-primary">#<?= $b['BookingID'] ?></td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center me-3 shadow-sm"
                                                    style="width: 40px; height: 40px; font-size: 0.9rem;">
                                                    <?= $firstLetter ?>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark"><?= htmlspecialchars($b['CustomerName']) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="text-dark fw-medium text-truncate" style="max-width: 250px;"
                                                title="<?= htmlspecialchars($b['TourName']) ?>">
                                                <?= htmlspecialchars($b['TourName']) ?>
                                            </div>
                                        </td>

                                        <td class="text-muted small">
                                            <i
                                                class="bi bi-clock me-1"></i><?= date('d/m/Y H:i', strtotime($b['BookingDate'])) ?>
                                        </td>

                                        <td class="text-end fw-bold text-dark">
                                            <?= $b['TotalAmount'] !== null ? number_format($b['TotalAmount'], 0, ',', '.') . ' ₫' : '-' ?>
                                        </td>

                                        <td class="text-center">
                                            <span
                                                class="badge rounded-pill <?= $currentStatus['class'] ?> px-3 py-2 border border-opacity-10">
                                                <i class="bi <?= $currentStatus['icon'] ?> me-1"></i>
                                                <?= htmlspecialchars($b['Status']) ?>
                                            </span>
                                        </td>

                                        <td class="text-center pe-4">
                                            <a href="<?= BASE_URL ?>?act=booking-detail&id=<?= $b['BookingID'] ?>"
                                                class="btn btn-sm btn-light border text-primary shadow-sm hover-elevate"
                                                data-bs-toggle="tooltip" title="Xem chi tiết đơn hàng">
                                                Xem chi tiết <i class="bi bi-arrow-right ms-1"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <div class="fs-1 text-light-emphasis mb-3"><i class="bi bi-inbox-fill"></i></div>
                                        <p class="mb-0 fs-5">Chưa có booking nào</p>
                                        <p class="small">Các đơn đặt tour mới sẽ xuất hiện tại đây</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-top-0 py-3"></div>
        </div>
    </div>
</div>

<style>
    .hover-elevate:hover {
        transform: translateY(-2px);
        transition: all 0.2s ease;
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
    }
</style>