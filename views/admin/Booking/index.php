<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<!-- Navbar -->
<?php require_once __DIR__ . '/../navbar.php'; ?>

<div class="d-flex admin-layout">

    <!-- Sidebar -->
    <div class="sidebar-wrapper bg-light border-end">
        <?php require_once __DIR__ . '/../sidebar.php'; ?>
    </div>

    <!-- Content -->
    <div class="admin-content flex-grow-1 p-4">
        <h2 class="mb-4 text-primary">Danh sách booking</h2>

        <div class="table-responsive shadow-sm rounded bg-white p-3">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-dark">
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
                    <?php if (!empty($bookings)): ?>
                    <?php foreach ($bookings as $b): ?>
                    <tr>
                        <td><?= $b['BookingID'] ?></td>
                        <td><?= htmlspecialchars($b['CustomerName']) ?></td>
                        <td><?= htmlspecialchars($b['TourName']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($b['BookingDate'])) ?></td>
                        <td><?= $b['TotalAmount'] !== null ? number_format($b['TotalAmount'], 0, ',', '.') . ' đ' : '-' ?>
                        </td>
                        <td>
                            <span class="badge 
                                    <?= $b['Status'] === 'Đang xử lý' ? 'bg-warning text-dark' : '' ?>
                                    <?= $b['Status'] === 'Đã xác nhận' ? 'bg-info text-white' : '' ?>
                                    <?= $b['Status'] === 'Đã hủy' ? 'bg-danger' : '' ?>
                                    <?= $b['Status'] === 'Đã thanh toán' ? 'bg-success text-white' : '' ?>
                                ">
                                <?= htmlspecialchars($b['Status']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>?act=booking-detail&id=<?= $b['BookingID'] ?>"
                                class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i>
                            </a>
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

    <style>
    /* STT column */
    .stt-col {
        text-align: center;
        font-weight: bold;
        width: 60px;
    }

    /* Table container */
    .table-responsive {
        border-radius: 14px;
        padding: 20px;
        background: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    /* Table body */
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

    /* Header */
    table.table-hover thead th {
        font-weight: 600;
        text-align: center;
        background: #f1f5f9;
        border-bottom: none;
    }

    /* Badge */
    .badge {
        padding: 0.55em 0.8em;
        font-size: 0.85rem;
        border-radius: 8px;
    }

    /* Button */
    .btn-sm {
        font-size: 0.8rem;
        padding: 0.35rem 0.6rem;
        border-radius: 6px;
    }

    .btn-sm i {
        margin-right: 4px;
    }

    /* Heading */
    h2 {
        font-weight: 700;
        color: #0d6efd;
    }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>