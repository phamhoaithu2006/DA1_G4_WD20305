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

        <h2 class="mb-3 text-primary">Danh sách nhân sự</h2>

        <div class="table-responsive shadow-sm rounded bg-white p-3">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-dark">
                    <tr>
                        <th>STT</th>
                        <th>Họ tên</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        <th>Tour phụ trách</th>
                        <th>Bắt đầu</th>
                        <th>Kết thúc</th>
                        <th>Thông tin</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($data)): ?>
                        <?php foreach ($data as $index => $hdv): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($hdv['FullName'] ?? '') ?></td>
                                <td><?= htmlspecialchars($hdv['Phone'] ?? '') ?></td>
                                <td><?= htmlspecialchars($hdv['Email'] ?? '') ?></td>
                                <td><?= htmlspecialchars($hdv['TourName'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($hdv['StartDate'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($hdv['EndDate'] ?? '-') ?></td>
                                <td>
                                    <a href="<?= BASE_URL ?>?act=ct-tour&tourID=<?= $tour['TourID'] ?>"
                                        class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">Chưa có dữ liệu HDV</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>


<style>
    /* KHÔNG CHO XUỐNG DÒNG – GIỮ 1 DÒNG */
    table.table-hover tbody td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 220px;
    }

    /* FRAME BẢNG */
    .table-responsive {
        border-radius: 14px;
        padding: 20px;
        background: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    /* HEADER */
    table.table-hover thead th {
        font-weight: 600;
        text-align: center;
        background: #f1f5f9;
        border-bottom: none;
        white-space: nowrap;
    }

    /* DÒNG */
    table.table-hover tbody tr {
        background: #ffffff;
        transition: all 0.25s ease;
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

    .btn-sm {
        padding: 5px 10px;
        border-radius: 8px;
    }

    h2 {
        font-weight: 700;
        color: #0d6efd;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>