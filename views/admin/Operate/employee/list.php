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

        <h2 class="mb-4 text-primary">
            Danh sách nhân sự
        </h2>

        <div class="table-responsive shadow-sm rounded bg-white p-3">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-dark">
                    <tr>
                        <th scope="col" class="stt-col">STT</th>
                        <th scope="col">Họ tên</th>
                        <th scope="col">Chức vụ</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col">Email</th>
                        <th scope="col" style="width:150px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($employees as $index => $emp): ?>
                        <tr>
                            <th class="stt-col"><?= $index + 1 ?></th>
                            <td><?= htmlspecialchars($emp['FullName'] ?? '') ?></td>
                            <td><?= htmlspecialchars($emp['Role'] ?? '') ?></td>
                            <td><?= htmlspecialchars($emp['Phone'] ?? '') ?></td>
                            <td><?= htmlspecialchars($emp['Email'] ?? '') ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>?act=editEmployee&id=<?= $emp['EmployeeID'] ?>"
                                    class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="<?= BASE_URL ?>?act=assignments&id=<?= $emp['EmployeeID'] ?>"
                                    class="btn btn-sm btn-info text-white">
                                    <i class="bi bi-plus-circle"></i>
                                </a>
                                <a href="<?= BASE_URL ?>?act=deleteEmployee&id=<?= $emp['EmployeeID'] ?>"
                                    class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa nhân sự này?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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