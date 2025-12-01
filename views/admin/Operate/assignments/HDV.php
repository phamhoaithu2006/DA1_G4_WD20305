<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách Hướng dẫn viên</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Danh sách Hướng dẫn viên</h2>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Họ tên</th>
                    <th>Điện thoại</th>
                    <th>Email</th>
                    <th>Tour phụ trách</th><!-- chưa làm-->
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Thông tin khách hàng</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($data)): ?>
                <?php foreach($data as $index => $hdv): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($hdv['FullName']) ?></td>
                    <td><?= htmlspecialchars($hdv['Phone']) ?></td>
                    <td><?= htmlspecialchars($hdv['Email']) ?></td>
                    <td><?= isset($hdv['TourName']) ? htmlspecialchars($hdv['TourName']) : '-' ?></td>
                    <td><?= isset($hdv['StartDate']) ? htmlspecialchars($hdv['StartDate']) : '-' ?></td>
                    <td><?= isset($hdv['EndDate']) ? htmlspecialchars($hdv['EndDate']) : '-' ?></td>
                    <td><a href="<?= BASE_URL ?>?act=ct-tour&tourID=<?= $tour['TourID'] ?>">Chi tiết</a></td>

                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">Chưa có dữ liệu HDV</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>