<<<<<<< HEAD
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/../../navbar.php'; ?>

<div class="d-flex admin-layout">

    <!-- Sidebar -->
    <div class="sidebar-wrapper bg-light border-end">
        <?php require_once __DIR__ . '/../../sidebar.php'; ?>
    </div>

    <!-- Content -->
    <div class="admin-content flex-grow-1 p-4">
        <h2 class="mb-4 text-primary">Danh sách khách của tour</h2>

        <a href="<?= BASE_URL ?>?act=createTourCustomer&tourID=<?= $tourID ?>" class="btn btn-success mb-3">
            <i class="bi bi-plus-lg me-1"></i> Thêm khách
        </a>

        <div class="table-responsive shadow-sm rounded bg-white p-3">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-dark">
                    <tr>
                        <th class="stt-col">STT</th>
                        <th>Họ tên</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        <th>Phòng</th>
                        <th>Ghi chú đặc biệt</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($customers)): ?>
                        <?php foreach ($customers as $index => $c): ?>
                            <tr>
                                <th class="stt-col"><?= $index + 1 ?></th>
                                <td><?= htmlspecialchars($c['FullName']) ?></td>
                                <td><?= htmlspecialchars($c['Phone']) ?></td>
                                <td><?= htmlspecialchars($c['Email']) ?></td>
                                <td><?= htmlspecialchars($c['RoomNumber']) ?></td>
                                <td><?= htmlspecialchars($c['Note']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">Chưa có khách nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
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

    /* Button thêm khách */
    .btn-success {
        font-size: 0.85rem;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
    }

    .btn-success i {
        margin-right: 4px;
    }

    /* Heading */
    h2 {
        font-weight: 700;
        color: #0d6efd;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
=======
<?php require_once __DIR__ . '/../../sidebar.php'; ?>
<div class="container mt-4">
    <h2 class="text-primary mb-3">Danh sách khách của tour</h2>
    <a href="<?= BASE_URL ?>?act=createTourCustomer&tourID=<?= $tourID ?>" class="btn btn-success mb-3">
        Thêm khách
    </a>

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Họ tên</th>
                <th>Điện thoại</th>
                <th>Email</th>
                <th>Phòng</th>
                <th>Ghi chú đặc biệt</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($customers as $index => $c): ?>
            <tr>
                <th><?= $index + 1 ?></th>
                <td><?= htmlspecialchars($c['FullName']) ?></td>
                <td><?= htmlspecialchars($c['Phone']) ?></td>
                <td><?= htmlspecialchars($c['Email']) ?></td>
                <td><?= htmlspecialchars($c['RoomNumber']) ?></td>
                <td><?= htmlspecialchars($c['Note']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
>>>>>>> 3ffeda95b17b161d1c7f83d77992cd563572f79d
