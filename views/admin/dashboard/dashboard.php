<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/../navbar.php'; ?>

<div class="d-flex admin-layout">

    <!-- Sidebar -->
    <div class="sidebar-wrapper bg-light border-end">
        <?php require_once __DIR__ . '/../sidebar.php'; ?>
    </div>

    <!-- Content -->
    <div class="admin-content flex-grow-1 p-4">
        <!-- Dashboard Cards -->
        <h2 class="page-title">Dashboard</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="tour-card p-4">
                    <div class="card-title"><i class="bi bi-list-ul me-2"></i>Danh mục Tour</div>
                    <div class="info-line">Tổng số danh mục: <strong><?= $data['totalCategories'] ?></strong></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="tour-card p-4">
                    <div class="card-title"><i class="bi bi-map me-2"></i>Tour</div>
                    <div class="info-line">Tổng số tour: <strong><?= $data['totalTours'] ?></strong></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="tour-card p-4">
                    <div class="card-title"><i class="bi bi-people me-2"></i>Khách hàng</div>
                    <div class="info-line">Tổng số khách hàng: <strong><?= $data['totalCustomers'] ?></strong></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="tour-card p-4">
                    <div class="card-title"><i class="bi bi-book me-2"></i>Đơn đặt tour</div>
                    <div class="info-line">Tổng số booking: <strong><?= $data['totalBookings'] ?></strong></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="tour-card p-4">
                    <div class="card-title"><i class="bi bi-person-badge me-2"></i>Nhân viên</div>
                    <div class="info-line">Tổng số nhân viên: <strong><?= $data['totalEmployees'] ?></strong></div>
                </div>
            </div>
        </div>

        <!-- Recent Bookings Table -->
        <h3 class="mt-5 mb-3 text-primary">Lịch đặt gần đây</h3>
        <div class="table-responsive shadow-sm rounded bg-white p-3">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-dark">
                    <tr>
                        <th>#</th>
                        <th>Khách</th>
                        <th>Tour</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['recentBookings'])): ?>
                    <?php foreach ($data['recentBookings'] as $index => $b): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($b['CustomerName']) ?></td>
                        <td><?= htmlspecialchars($b['TourName']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($b['BookingDate'])) ?></td>
                        <td><?= $b['TotalAmount'] !== null ? number_format($b['TotalAmount'],0,',','.') . ' đ' : '-' ?>
                        </td>
                        <td>
                            <span class="badge 
                    <?= $b['Status'] === 'Đang xử lý' ? 'bg-warning text-dark' : '' ?>
                    <?= $b['Status'] === 'Đã xác nhận' ? 'bg-info text-white' : '' ?>
                    <?= $b['Status'] === 'Đã hủy' ? 'bg-danger' : '' ?>">
                                <?= htmlspecialchars($b['Status']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>?act=booking-detail&id=<?= $b['BookingID'] ?>"
                                class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> Chi tiết
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">Chưa có booking nào</td>
                    </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.admin-layout {
    display: flex;
    min-height: 100vh;
    background-color: #f5f7fa;
}

.sidebar-wrapper {
    width: 260px;
    background-color: #fff;
}

.admin-content {
    flex-grow: 1;
    padding: 25px 30px;
}

.page-title {
    font-size: 1.75rem;
    font-weight: 650;
    text-align: center;
    color: #0d6efd;
    margin-bottom: 30px;
}

.tour-card {
    border-radius: 16px;
    border: 1px solid #e4e4e4;
    background: #fff;
    transition: all .25s ease-in-out;
}

.tour-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
}

.card-title {
    font-size: 1.15rem;
    font-weight: 650;
    color: #222;
    margin-bottom: 12px;
}

.info-line {
    font-size: 0.95rem;
    margin-bottom: 6px;
    color: #333;
}

@media (max-width: 768px) {
    .col-md-4 {
        flex: 0 0 100%;
    }
}

/* Recent Bookings Table */
.table-responsive {
    border-radius: 14px;
    padding: 20px;
    background: #fff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

table.table-hover tbody tr {
    background: #ffffff;
    border-radius: 10px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
    margin-bottom: 10px;
    display: table-row;
}

table.table-hover tbody tr:hover {
    background: #e9f2ff;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
}

table.table-hover tbody td {
    vertical-align: middle;
    text-align: center;
}

table.table-hover thead th {
    font-weight: 600;
    text-align: center;
    background: #f1f5f9;
    border-bottom: none;
}

.badge {
    padding: 0.55em 0.8em;
    font-size: 0.85rem;
    border-radius: 8px;
}

.btn-sm {
    font-size: 0.8rem;
    padding: 0.35rem 0.6rem;
    border-radius: 6px;
}

.btn-sm i {
    margin-right: 4px;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>