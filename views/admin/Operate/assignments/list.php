<?php require_once __DIR__ . '/../../sidebar.php'; ?>
<div class="container mt-4">
    <h2 class="text-primary mb-3">Phân công nhân sự cho tour</h2>
    <a href="<?= BASE_URL ?>?act=createAssignment&tourID=<?= $tourID ?>" class="btn btn-success mb-3">Thêm nhân sự
        vào tour</a>
    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Họ tên nhân sự</th>
                <th>Vai trò</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($assignments as $index => $assign): ?>
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