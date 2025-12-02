<?php
$tourIdValue = isset($_GET['tourId']) ? intval($_GET['tourId']) : 0;
$encodedTourId = urlencode($tourIdValue);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tài chính Tour</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body class="p-4">
    <div class="container admin-content"> 
        
        <h2 class="mb-4 text-primary">Tài chính Tour - TourID: <?php echo htmlspecialchars($tourIdValue); ?></h2>


        <a class="btn btn-primary mb-3"
            href="index.php?act=finance-create&tourId=<?php echo $encodedTourId; ?>">
            <i class="bi bi-plus-circle"></i> Thêm báo cáo
        </a>


        <div class="table-responsive shadow-sm rounded bg-white p-3">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Doanh thu</th>
                        <th scope="col">Chi phí</th>
                        <th scope="col">Lợi nhuận</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($rows)):
                        foreach ($rows as $r): ?>
                            <tr>
                                <td><?php echo $r['FinanceID']; ?></td>
                                <td><?php echo number_format($r['Revenue'], 0, ',', '.') . ' đ'; ?></td>
                                <td><?php echo number_format($r['Expense'], 0, ',', '.') . ' đ'; ?></td>
                                <td>
                                    <span class="<?php echo $r['Profit'] >= 0 ? 'text-success' : 'text-danger'; ?> fw-bold">
                                        <?php echo number_format($r['Profit'], 0, ',', '.') . ' đ'; ?>
                                    </span>
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-primary"
                                        href="index.php?act=finance-edit&id=<?php echo $r['FinanceID']; ?>" title="Sửa báo cáo"> 
                                        <i class="bi bi-pencil-square"></i> Sửa
                                    </a>


                                    <a class="btn btn-sm btn-danger"
                                        href="index.php?act=finance-delete&id=<?php echo $r['FinanceID']; ?>&tourId=<?php echo $encodedTourId; ?>"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa báo cáo này?');" title="Xóa báo cáo">
                                        <i class="bi bi-trash"></i> Xóa
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach;
                    else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">Chưa có báo cáo tài chính.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <style>
        /* Table container */
        .table-responsive {
            border-radius: 14px; /* Bo góc container */
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); /* Bóng đổ nhẹ */
            border: none;
        }

        /* Table header */
        table.table-hover thead th {
            font-weight: 600;
            text-align: center;
            background: #f1f5f9; /* Nền xám nhạt */
            border-bottom: none;
        }

        /* Table body row */
        table.table-hover tbody tr {
            background: #ffffff;
            border-radius: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03); /* Bóng đổ cho từng hàng */
            margin-bottom: 10px;
            display: table-row;
        }

        table.table-hover tbody tr:hover {
            background: #e9f2ff; /* Màu nền khi hover */
            transform: translateY(-2px); /* Hiệu ứng nâng nhẹ */
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08); /* Bóng đổ lớn hơn khi hover */
        }

        table.table-hover tbody td {
            vertical-align: middle;
            text-align: center; /* Căn giữa nội dung bảng */
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
            color: #0d6efd; /* Màu xanh dương chủ đạo */
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>