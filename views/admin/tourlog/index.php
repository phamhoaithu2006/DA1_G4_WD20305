<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php
ob_start();
$tourID = isset($_GET['tourID']) ? intval($_GET['tourID']) : 0;
$encodedTourID = urlencode($tourID);
?>

<!-- Navbar -->
<?php require_once __DIR__ . '/../navbar.php'; ?>

<div class="d-flex admin-layout">

    <!-- Sidebar -->
    <div class="sidebar-wrapper bg-light border-end">
        <?php require_once __DIR__ . '/../sidebar.php'; ?>
    </div>

    <!-- Content -->
    <div class="admin-content flex-grow-1 p-4">
        <h3>Nhật ký Tour <span class="text-primary">#<?php echo htmlspecialchars($tourID); ?></span></h3>
        <a class="btn btn-success" href="index.php?act=tourlog-create&tourID=<?php echo $encodedTourID; ?>">
            <i class="bi bi-plus-circle"></i> Thêm nhật ký
        </a>

        <div class="table-responsive shadow-sm rounded bg-white p-3">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>LogID</th>
                        <th>Ngày</th>
                        <th>Người ghi</th>
                        <th>Nội dung</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($logs)): foreach ($logs as $l): ?>
                            <tr>
                                <td><?php echo $l['LogID']; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($l['LogDate'])); ?></td>
                                <td><?php echo htmlspecialchars($l['EmployeeName'] ?? ''); ?></td>
                                <td><?php echo nl2br(htmlspecialchars($l['Note'] ?? '')); ?></td>
                                <td>
                                    <a class="btn btn-sm btn-warning me-1" href="index.php?act=tourlog-edit&id=<?php echo $l['LogID']; ?>"><i class="bi bi-pencil-square"></i> Sửa</a>
                                    <a class="btn btn-sm btn-danger" href="index.php?act=tourlog-delete&id=<?php echo $l['LogID']; ?>&tourID=<?php echo $encodedTourID; ?>"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa nhật ký này?');"><i class="bi bi-trash"></i> Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach;
                    else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Chưa có nhật ký.</td>
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