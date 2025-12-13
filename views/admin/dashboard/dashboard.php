<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php require_once __DIR__ . '/../navbar.php'; ?>

<div class="admin-container">
    <div class="sidebar-wrapper bg-white shadow-sm border-end">
        <?php require_once __DIR__ . '/../sidebar.php'; ?>
    </div>

    <div class="admin-content">

        <div class="d-flex justify-content-between align-items-center mb-4 pt-2">
            <div>
                <h2 class="fw-bold text-dark mb-1">Tổng quan</h2>
                <p class="text-muted mb-0">Chào mừng trở lại hệ thống quản lý Tour</p>
            </div>
            <div class="date-display px-3 py-2 bg-white rounded shadow-sm border">
                <i class="bi bi-calendar-event text-primary me-2"></i>
                <span class="fw-medium"><?= date('d/m/Y') ?></span>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card stat-card border-0 shadow-sm h-100 bg-primary-subtle text-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-2 fw-semibold opacity-75">Booking</h6>
                                <h2 class="mb-0 fw-bold"><?= $data['totalBookings'] ?? 0 ?></h2>
                            </div>
                            <div
                                class="stat-icon bg-white text-primary rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-journal-check fs-4"></i>
                            </div>
                        </div>
                        <div class="mt-3 small">
                            <span class="fw-bold"><i class="bi bi-arrow-up-short"></i> Mới</span>
                            <span class="opacity-75">trong tháng này</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card stat-card border-0 shadow-sm h-100 bg-success-subtle text-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-2 fw-semibold opacity-75">Khách hàng</h6>
                                <h2 class="mb-0 fw-bold"><?= $data['totalCustomers'] ?? 0 ?></h2>
                            </div>
                            <div
                                class="stat-icon bg-white text-success rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people fs-4"></i>
                            </div>
                        </div>
                        <div class="mt-3 small">
                            <span class="fw-bold">Total</span>
                            <span class="opacity-75">thành viên</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card stat-card border-0 shadow-sm h-100 bg-info-subtle text-info-emphasis">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-2 fw-semibold opacity-75">Tour du lịch</h6>
                                <h2 class="mb-0 fw-bold"><?= $data['totalTours'] ?? 0 ?></h2>
                            </div>
                            <div
                                class="stat-icon bg-white text-info rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-map fs-4"></i>
                            </div>
                        </div>
                        <div class="mt-3 small">
                            <span class="fw-bold"><?= $data['totalCategories'] ?? 0 ?></span>
                            <span class="opacity-75">danh mục</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card stat-card border-0 shadow-sm h-100 bg-warning-subtle text-warning-emphasis">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-2 fw-semibold opacity-75">Nhân sự</h6>
                                <h2 class="mb-0 fw-bold"><?= $data['totalEmployees'] ?? 0 ?></h2>
                            </div>
                            <div
                                class="stat-icon bg-white text-warning rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-person-badge fs-4"></i>
                            </div>
                        </div>
                        <div class="mt-3 small">
                            <span class="opacity-75">Đang làm việc</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 pt-3 pb-0">
                        <h5 class="card-title fw-bold text-dark"><i
                                class="bi bi-bar-chart-line text-primary me-2"></i>Thống kê doanh thu</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart" height="120"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 pt-3 pb-0">
                        <h5 class="card-title fw-bold text-dark"><i class="bi bi-pie-chart text-success me-2"></i>Trạng
                            thái Tour</h5>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <div style="width: 100%; max-width: 280px;">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title fw-bold mb-0 text-dark">Lịch đặt gần đây</h5>
                <a href="<?= BASE_URL ?>?act=booking-list" class="btn btn-sm btn-outline-primary rounded-pill px-3">Xem
                    tất cả</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th class="ps-4">Khách hàng</th>
                                <th>Tour đăng ký</th>
                                <th>Ngày đặt</th>
                                <th class="text-end">Tổng tiền</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center pe-4">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['recentBookings'])): ?>
                                <?php foreach ($data['recentBookings'] as $index => $b): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-initial rounded-circle bg-light text-primary fw-bold me-3 d-flex align-items-center justify-content-center"
                                                    style="width: 40px; height: 40px;">
                                                    <?= strtoupper(substr($b['CustomerName'] ?? 'U', 0, 1)) ?>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark"><?= htmlspecialchars($b['CustomerName']) ?>
                                                    </div>
                                                    <small class="text-muted">#<?= $b['BookingID'] ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if (!empty($b['Image'])): ?>
                                                    <img src="<?= $b['Image'] ?>" class="rounded me-2" width="40" height="40"
                                                        style="object-fit: cover;">
                                                <?php else: ?>
                                                    <div class="rounded me-2 bg-light d-flex align-items-center justify-content-center text-muted"
                                                        style="width: 40px; height: 40px;">
                                                        <i class="bi bi-image"></i>
                                                    </div>
                                                <?php endif; ?>

                                                <span class="text-dark fw-medium"><?= htmlspecialchars($b['TourName']) ?></span>
                                            </div>
                                        </td>
                                        <td class="text-muted">
                                            <i class="bi bi-clock me-1"></i><?= date('d/m/Y', strtotime($b['BookingDate'])) ?>
                                        </td>
                                        <td class="text-end fw-bold text-dark">
                                            <?= $b['TotalAmount'] !== null ? number_format($b['TotalAmount'], 0, ',', '.') . ' đ' : '-' ?>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            $statusClass = 'bg-secondary-subtle text-secondary';
                                            $icon = 'bi-circle';

                                            if ($b['Status'] === 'Đang xử lý') {
                                                $statusClass = 'bg-warning-subtle text-warning-emphasis';
                                                $icon = 'bi-hourglass-split';
                                            } elseif ($b['Status'] === 'Đã xác nhận') {
                                                $statusClass = 'bg-info-subtle text-info-emphasis';
                                                $icon = 'bi-check-circle';
                                            } elseif ($b['Status'] === 'Đã thanh toán') {
                                                $statusClass = 'bg-success-subtle text-success-emphasis';
                                                $icon = 'bi-cash-coin';
                                            } elseif ($b['Status'] === 'Đã hủy') {
                                                $statusClass = 'bg-danger-subtle text-danger-emphasis';
                                                $icon = 'bi-x-circle';
                                            }
                                            ?>
                                            <span class="badge rounded-pill <?= $statusClass ?> px-3 py-2">
                                                <i class="bi <?= $icon ?> me-1"></i> <?= htmlspecialchars($b['Status']) ?>
                                            </span>
                                        </td>
                                        <td class="text-center pe-4">
                                            <a href="<?= BASE_URL ?>?act=booking-detail&id=<?= $b['BookingID'] ?>"
                                                class="btn btn-sm btn-light text-primary border shadow-sm"
                                                data-bs-toggle="tooltip" title="Xem chi tiết">
                                                <i class="bi bi-arrow-right"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">Chưa có dữ liệu</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* --- QUAN TRỌNG: CẤU HÌNH LAYOUT --- */
    :root {
        --header-height: 70px;
        /* Chiều cao của Navbar */
        --sidebar-width: 260px;
        /* Chiều rộng Sidebar */
    }

    body {
        background-color: #f5f7fa;
        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        /* Đẩy toàn bộ nội dung xuống dưới Navbar */
        padding-top: var(--header-height);
    }

    /* Sidebar cố định bên trái, nhưng bắt đầu từ dưới Navbar */
    .sidebar-wrapper {
        width: var(--sidebar-width);
        position: fixed;
        top: var(--header-height);
        /* Bắt đầu sau Navbar */
        bottom: 0;
        left: 0;
        z-index: 100;
        overflow-y: auto;
        /* Thêm transition mượt mà */
        transition: all 0.3s;
    }

    /* Nội dung chính nằm bên phải Sidebar */
    .admin-content {
        margin-left: var(--sidebar-width);
        padding: 30px;
        transition: all 0.3s;
    }

    /* Cards Style */
    .stat-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border-radius: 12px;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    /* Table Style */
    .table thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        border-bottom: 1px solid #e9ecef;
        padding: 1rem 0.5rem;
    }

    .table tbody td {
        padding: 1rem 0.5rem;
    }

    .avatar-initial {
        font-size: 1.1rem;
    }

    /* Responsive cho Mobile */
    @media (max-width: 992px) {
        .sidebar-wrapper {
            margin-left: calc(var(--sidebar-width) * -1);
            /* Ẩn sidebar */
        }

        .admin-content {
            margin-left: 0;
            /* Full width content */
        }

        /* Khi nào cần hiện sidebar thì thêm class .show vào sidebar-wrapper */
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Khởi tạo tooltip
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Chart Demo (Dữ liệu mẫu)
        const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctxRevenue, {
            type: 'line',
            data: {
                labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6'],
                datasets: [{
                    label: 'Doanh thu (Triệu VNĐ)',
                    data: [120, 190, 300, 500, 200, 300],
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ctxStatus = document.getElementById('statusChart').getContext('2d');
        new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: ['Hoàn thành', 'Đang xử lý', 'Hủy'],
                datasets: [{
                    data: [65, 25, 10],
                    backgroundColor: ['#198754', '#ffc107', '#dc3545'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });
</script>