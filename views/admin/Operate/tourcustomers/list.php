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