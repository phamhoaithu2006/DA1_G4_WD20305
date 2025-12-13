<?php
// $tourID = ID tour
// $allEmployees = danh sách tất cả nhân viên để chọn
?>

<div class="container mt-4">
    <h3>Thêm nhân sự vào Tour #<?= $tourID ?></h3>

    <form action="?act=tourassignment-add" method="post" class="row g-3">
        <input type="hidden" name="tourID" value="<?= $tourID ?>">

        <div class="col-md-6">
            <label>Chọn nhân viên:</label>
            <select name="employeeID" class="form-select" required>
                <option value="">-- Chọn nhân viên --</option>
                <?php foreach ($allEmployees as $e): ?>
                    <option value="<?= $e['EmployeeID'] ?>"><?= $e['FullName'] ?> (<?= $e['Role'] ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-6">
            <label>Vai trò trong tour:</label>
            <input type="text" name="role" class="form-control" placeholder="HDV, Tài xế, ...">
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Thêm nhân sự</button>
            <a href="?act=tourassignment-list&tourID=<?= $tourID ?>" class="btn btn-secondary">Quay lại</a>
        </div>
    </form>
</div>