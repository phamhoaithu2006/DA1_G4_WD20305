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
    <div class="container">
        <h3>Thêm báo cáo tài chính - TourID: <?php echo htmlspecialchars($_GET['tourId'] ?? ''); ?></h3>


        <form method="post" action="index.php?act=finance-store">


            <input type="hidden" name="TourID" value="<?php echo htmlspecialchars($_GET['tourId'] ?? 0); ?>">


            <div class="mb-3">
                <label class="form-label">Doanh thu</label>
                <input type="number" step="0.01" name="Revenue" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Chi phí</label>
                <input type="number" step="0.01" name="Expense" class="form-control">
            </div>


            <button class="btn btn-primary">Lưu</button>


            <a class="btn btn-secondary" href="index.php?act=finance-list&tourId=<?php echo urlencode($_GET['tourId'] ?? 0); ?>">Quay lại</a>


        </form>
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