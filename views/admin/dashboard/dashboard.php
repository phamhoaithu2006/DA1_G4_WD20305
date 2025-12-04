<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/../navbar.php'; ?>

<div class="admin-layout">

    <!-- Sidebar -->
    <aside class="sidebar-wrapper">
        <?php require_once __DIR__ . '/../sidebar.php'; ?>
    </aside>

    <!-- Main Content -->
    <main class="admin-content">

        <!-- Page Title -->
        <h2 class="page-title">Tổng quan hệ thống</h2>

        <!-- Dashboard Cards -->
        <div class="row g-2 mb-2">

            <div class="col-md-6">
                <div class="tour-card p-4 d-flex align-items-center">
                    <div class="icon-box bg-primary bg-opacity-10 text-primary">
                        <i class="bi-map"></i>
                    </div>
                    <div>
                        <div class="card-title">Danh mục tour</div>
                        <div class="info-line">Tổng: <b><?= $data['totalCategories'] ?></b></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="tour-card p-4 d-flex align-items-center">
                    <div class="icon-box bg-info bg-opacity-10 text-info">
                        <i class="bi-card-list"></i>
                    </div>
                    <div>
                        <div class="card-title">Đơn booking</div>
                        <div class="info-line">Tổng: <b><?= $data['totalBookings'] ?></b></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="tour-card p-4 d-flex align-items-center">
                    <div class="icon-box bg-warning bg-opacity-10 text-warning">
                        <i class="bi-person-badge"></i>
                    </div>
                    <div>
                        <div class="card-title">Khách hàng</div>
                        <div class="info-line">Tổng: <b><?= $data['totalCustomers'] ?></b></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="tour-card p-4 d-flex align-items-center">
                    <div class="icon-box bg-danger bg-opacity-10 text-danger">
                        <i class="bi-person-vcard"></i>
                    </div>
                    <div>
                        <div class="card-title">Nhân viên</div>
                        <div class="info-line">Tổng: <b><?= $data['totalEmployees'] ?></b></div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Recent Bookings Table -->
        <h3 class="recent-title mt-5 mb-3 text-primary text-center fw-bold">Lịch đặt gần đây</h3>

        <div class="table-responsive shadow-sm rounded bg-white p-3">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-dark">
                    <tr>
                        <th>STT</th>
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
                                <td><?= $b['TotalAmount'] !== null ? number_format($b['TotalAmount'], 0, ',', '.') . ' đ' : '-' ?></td>

                                <td>
                                    <span class="badge 
                                <?= $b['Status'] === 'Đang xử lý' ? 'bg-warning text-dark' : '' ?>
                                <?= $b['Status'] === 'Đã xác nhận' ? 'bg-info text-white' : '' ?>
                                <?= $b['Status'] === 'Đã hủy' ? 'bg-danger' : '' ?>
                                <?= $b['Status'] === 'Đã thanh toán' ? 'bg-success text-white' : '' ?>">
                                        <?= htmlspecialchars($b['Status']) ?>
                                    </span>
                                </td>

                                <td>
                                    <a href="<?= BASE_URL ?>?act=booking-detail&id=<?= $b['BookingID'] ?>" class="btn btn-sm btn-primary">
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

    </main>
</div>

<!-- CSS -->
<style>
    body {
        background: #eef1f5;
    }

    .admin-layout {
        display: flex;
        min-height: 100vh;
    }

    .sidebar-wrapper {
        width: 260px;
        background: #ffffff;
        border-right: 1px solid #e3e7ef;
        box-shadow: 3px 0 12px rgba(0, 0, 0, 0.06);
        position: sticky;
        top: 0;
        height: 100vh;
    }

    .admin-content {
        flex-grow: 1;
        padding: 40px;
    }

    .page-title {
        text-align: center;
        font-size: 2.2rem;
        font-weight: 800;
        color: #0d47a1;
        margin-bottom: 45px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .tour-card {
        border-radius: 20px;
        background: #ffffff;
        border: 1px solid #dde3ec;
        display: flex;
        padding: 25px;
        gap: 18px;
        align-items: center;
        transition: 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
    }

    .tour-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 18px 30px rgba(0, 0, 0, 0.12);
    }

    .icon-box {
        width: 60px;
        height: 60px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1e293b;
    }

    .info-line {
        font-size: 1rem;
        color: #64748b;
        margin-top: 4px;
    }

    .table-responsive {
        border-radius: 14px;
        padding: 20px;
        background: #ffffff;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
    }

    table.table-hover thead th {
        background: #eaf0f7;
        color: #1e293b;
        font-weight: 700;
        padding: 14px;
        border-bottom: 2px solid #dbe3ee;
    }

    table.table-hover tbody tr {
        transition: 0.25s ease;
    }

    table.table-hover tbody tr:hover {
        background: #edf6ff;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    }

    table.table-hover tbody td {
        vertical-align: middle;
        padding: 14px;
        font-size: 0.95rem;
        color: #334155;
    }

    .badge {
        padding: 0.55em 0.9em;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .btn-sm {
        font-size: 0.8rem;
        padding: 0.40rem 0.7rem;
        border-radius: 6px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>