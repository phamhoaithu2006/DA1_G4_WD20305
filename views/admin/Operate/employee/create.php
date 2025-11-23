<?php require_once __DIR__ . '/../../sidebar.php'; ?>
<div class="container mt-4">
<<<<<<< HEAD
    <h2 class="text-primary mb-3"><?= isset($employee) ? 'Sửa' : 'Thêm' ?> nhân sự</h2>
=======
    <h2 class="text-primary mb-3"><?= isset($employee)? 'Sửa' : 'Thêm' ?> nhân sự</h2>
>>>>>>> 3ffeda95b17b161d1c7f83d77992cd563572f79d
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Họ tên</label>
            <input type="text" name="name" class="form-control" value="<?= $employee['FullName'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Chức vụ</label>
            <input type="text" name="role" class="form-control" value="<?= $employee['Role'] ?? '' ?>">
        </div>
        <div class="mb-3">
<<<<<<< HEAD
            <label class="form-label">Số điện thoại</label>
=======
            <label class="form-label">Điện thoại</label>
>>>>>>> 3ffeda95b17b161d1c7f83d77992cd563572f79d
            <input type="text" name="phone" class="form-control" value="<?= $employee['Phone'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= $employee['Email'] ?? '' ?>">
        </div>
<<<<<<< HEAD
        <button type="submit" class="btn btn-success"><?= isset($employee) ? 'Cập nhật' : 'Thêm' ?></button>
=======
        <button type="submit" class="btn btn-success"><?= isset($employee)? 'Cập nhật' : 'Thêm' ?></button>
>>>>>>> 3ffeda95b17b161d1c7f83d77992cd563572f79d
        <a href="index.php?action=employees" class="btn btn-secondary">Quay lại</a>
    </form>
</div>