<?php
// $customers = danh sách khách từ controller
// $tourID = ID tour hiện tại
?>

<div class="container mt-4">
    <h3>Danh sách khách hàng Tour #<?= $tourID ?></h3>

    <a href="?act=tourcustomer-create&tourID=<?= $tourID ?>" class="btn btn-success mb-3">Thêm khách mới</a>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Ghi chú</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($customers as $index => $c): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= $c['FullName'] ?></td>
                <td><?= $c['Email'] ?></td>
                <td><?= $c['Phone'] ?></td>
                <td><?= $c['Note'] ?></td>
                <td>
                    <a href="?act=tourcustomer-delete&id=<?= $c['ID'] ?>&tourID=<?= $tourID ?>"
                        class="btn btn-danger btn-sm" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>