<?php require_once __DIR__ . '/../../sidebar.php'; ?>

<div class="container mt-4">
    <h2 class="text-primary mb-3">Danh sách nhân sự</h2>
    <!-- <a href="<?= BASE_URL ?>?act=createEmployee" class="btn btn-success mb-3">Thêm nhân sự</a> -->

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Họ tên</th>
                <th scope="col">Chức vụ</th>
                <th scope="col">Điện thoại</th>
                <th scope="col">Email</th>
                <th scope="col" style="width:150px;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($employees as $index => $emp): ?>
            <tr>
                <th scope="row"><?= $index + 1 ?></th>
                <td><?= htmlspecialchars($emp['FullName'] ?? '') ?></td>
                <td><?= htmlspecialchars($emp['Role'] ?? '') ?></td>
                <td><?= htmlspecialchars($emp['Phone'] ?? '') ?></td>
                <td><?= htmlspecialchars($emp['Email'] ?? '') ?></td>

                <td>
                    <a href="<?= BASE_URL ?>?act=editEmployee&id=<?= $emp['EmployeeID'] ?>"
                        class="btn btn-sm btn-warning">Sửa</a>
                    <a href="<?= BASE_URL ?>?act=assignments&id=<?= $emp['EmployeeID'] ?>"
                        class="btn btn-sm btn-info">Chi tiết</a>
                    <a href="<?= BASE_URL ?>?act=deleteEmployee&id=<?= $emp['EmployeeID'] ?>"
                        class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>