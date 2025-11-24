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
        <h2 class="text-primary mb-3">Phân công nhân sự cho tour</h2>
        <a href="<?= BASE_URL ?>?act=createAssignment&tourID=<?= $tourID ?>" class="btn btn-success mb-3">Thêm nhân sự
            vào tour</a>
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Họ tên nhân sự</th>
                    <th>Vai trò</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($assignments as $index => $assign): ?>
                    <tr>
                        <th><?= $index + 1 ?></th>
                        <td><?= htmlspecialchars($assign['FullName']) ?></td>
                        <td><?= htmlspecialchars($assign['Role']) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>?act=deleteAssignment&id=<?= $assign['AssignmentID'] ?>&tourID=<?= $tourID ?>"
                                class="btn btn-sm btn-danger" onclick="return confirm('Xóa phân công này?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>