<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thêm báo cáo tài chính</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
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
</body>

</html>