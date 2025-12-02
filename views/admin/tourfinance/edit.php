<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sửa báo cáo tài chính</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
    <div class="container">
        <h3>Sửa báo cáo #<?php echo htmlspecialchars($row['FinanceID']); ?></h3>


        <form method="post" action="index.php?act=finance-update&id=<?php echo urlencode($row['FinanceID']); ?>">


            <input type="hidden" name="TourID" value="<?php echo htmlspecialchars($row['TourID']); ?>">


            <div class="mb-3">
                <label class="form-label">Doanh thu</label>
                <input type="number" step="0.01" name="Revenue" class="form-control" value="<?php echo htmlspecialchars($row['Revenue']); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Chi phí</label>
                <input type="number" step="0.01" name="Expense" class="form-control" value="<?php echo htmlspecialchars($row['Expense']); ?>">
            </div>


            <button type="submit" class="btn btn-primary">Cập nhật</button>


            <a class="btn btn-secondary" href="index.php?act=finance-list&tourId=<?php echo urlencode($row['TourID']); ?>">Quay lại</a>


        </form>
    </div>
</body>

</html>