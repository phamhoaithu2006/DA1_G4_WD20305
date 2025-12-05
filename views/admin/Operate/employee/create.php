<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/../../navbar.php'; ?>

<div class="d-flex admin-layout">

    <!-- Sidebar -->
    <div class="sidebar-wrapper">
        <?php require_once __DIR__ . '/../../sidebar.php'; ?>
    </div>

    <!-- Content -->
    <div class="admin-content flex-grow-1 p-4">
        <div class="container mt-4">
            <h2 class="text-primary mb-3"><?= isset($employee) ? 'Sửa' : 'Thêm' ?> nhân sự</h2>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Họ tên</label>
                    <input type="text" name="name" class="form-control" value="<?= $employee['FullName'] ?? '' ?>"
                        required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Chức vụ</label>
                    <input type="text" name="role" class="form-control" value="<?= $employee['Role'] ?? '' ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" value="<?= $employee['Phone'] ?? '' ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= $employee['Email'] ?? '' ?>">
                </div>
                <button type="submit" class="btn btn-success"><?= isset($employee) ? 'Cập nhật' : 'Thêm' ?></button>
                <a href="index.php?action=employees" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>

        <style>
        /* STT column */
        .stt-col {
            text-align: center;
            font-weight: 600;
            width: 60px;
        }

        /* Bảng tổng thể */
        .table-responsive {
            border-radius: 12px;
            padding: 25px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        table.table-hover {
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        table.table-hover thead tr {
            border-radius: 12px;
        }

        table.table-hover thead th {
            background-color: #f1f5f9;
            color: #212529;
            font-weight: 600;
            border-bottom: none;
            text-align: center;
        }

        table.table-hover tbody tr {
            background: #ffffff;
            border-radius: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
        }

        table.table-hover tbody tr:hover {
            background: #e1f0ff;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
        }

        table.table-hover tbody td {
            vertical-align: middle;
            text-align: center;
        }

        table.table-hover tbody td:first-child,
        table.table-hover thead th:first-child {
            text-align: center;
        }

        /* Buttons style */
        .btn-sm {
            font-size: 0.8rem;
            padding: 0.35rem 0.6rem;
            border-radius: 6px;
        }

        .btn-warning i {
            margin-right: 2px;
        }

        .btn-info i {
            margin-right: 2px;
        }

        .btn-danger i {
            margin-right: 2px;
        }

        /* Heading */
        h2 {
            font-weight: 700;
            color: #0d6efd;
            display: flex;
            align-items: center;
        }

        h2 i {
            margin-right: 8px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .table-responsive {
                padding: 15px;
            }

            .stt-col {
                width: 40px;
            }
        }
        </style>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>