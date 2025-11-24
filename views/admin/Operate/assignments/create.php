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
    <div class="admin-content flex-grow-1 p-4">
        <h2 class="text-primary mb-3">Thêm nhân sự vào tour</h2>
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Chọn nhân sự</label>
                <select name="employeeID" class="form-select" required>
                    <?php foreach ($allEmployees as $emp): ?>
                        <option value="<?= $emp['EmployeeID'] ?>"><?= htmlspecialchars($emp['FullName']) ?> -
                            <?= htmlspecialchars($emp['Role']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Vai trò trong tour</label>
                <input type="text" name="role" class="form-control" placeholder="HDV, Lái xe, ...">
            </div>
            <button type="submit" class="btn btn-success">Thêm</button>
            <a href="index.php?action=assignments&tourID=<?= $_GET['tourID'] ?>" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>