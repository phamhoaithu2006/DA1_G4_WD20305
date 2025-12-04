<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/../../navbar.php'; ?>

<div class="d-flex admin-layout">
    <div class="sidebar-wrapper bg-white shadow-sm border-end">
        <?php require_once __DIR__ . '/../../sidebar.php'; ?>
    </div>

    <div class="admin-content flex-grow-1 p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Quản lý Nhân sự</h2>
                <p class="text-muted mb-0">Danh sách hướng dẫn viên, tài xế và nhân viên điều hành.</p>
            </div>
            <a href="<?= BASE_URL?>?act=createEmployee" class="btn btn-primary shadow-sm fw-bold">
                <i class="bi bi-person-plus-fill me-1"></i> Thêm nhân sự
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-secondary small text-uppercase fw-bold">Nhân viên</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold">Vai trò</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold">Trạng thái công việc</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold">Liên hệ</th>
                                <th class="pe-4 py-3 text-secondary small text-uppercase fw-bold text-end">Hành động
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($employees)): ?>
                            <?php foreach ($employees as $emp): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center me-3"
                                            style="width: 45px; height: 45px; font-size: 1.1rem;">
                                            <?= strtoupper(substr($emp['FullName'] ?? 'U', 0, 1)) ?>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark"><?= htmlspecialchars($emp['FullName']) ?>
                                            </div>
                                            <div class="text-muted small">ID: #<?= $emp['EmployeeID'] ?></div>
                                        </div>
                                    </div>
                                </td>

                                <td><?= htmlspecialchars($emp['Role'] ?? 'Nhân viên') ?></td>

                                <td>
                                    <?php if (!empty($emp['TourName'])): ?>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="d-flex align-items-center mb-1">
                                                <span class="badge bg-danger-subtle text-danger me-2"
                                                    style="font-size: 0.7rem;">
                                                    <i class="bi bi-flag-fill"></i> Bận
                                                </span>
                                                <div class="fw-bold text-dark text-truncate" style="max-width: 150px;"
                                                    title="<?= htmlspecialchars($emp['TourName']) ?>">
                                                    <?= htmlspecialchars($emp['TourName']) ?>
                                                </div>
                                            </div>
                                            <div class="text-muted small ps-1">
                                                <?= date('d/m', strtotime($emp['StartDate'])) ?> -
                                                <?= date('d/m', strtotime($emp['EndDate'])) ?>
                                            </div>
                                        </div>

                                        <button class="btn btn-sm btn-light text-primary border ms-2"
                                            data-bs-toggle="modal" data-bs-target="#assignTourModal"
                                            title="Đổi tour khác"
                                            onclick="setEmployeeForAssign('<?= $emp['EmployeeID'] ?>', '<?= htmlspecialchars($emp['FullName']) ?>')">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </div>

                                    <?php else: ?>
                                    <button class="btn btn-sm btn-outline-success rounded-pill px-3 shadow-sm"
                                        data-bs-toggle="modal" data-bs-target="#assignTourModal"
                                        onclick="setEmployeeForAssign('<?= $emp['EmployeeID'] ?>', '<?= htmlspecialchars($emp['FullName']) ?>')">
                                        <i class="bi bi-plus-circle me-1"></i> Phân công
                                    </button>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <div class="d-flex flex-column small">
                                        <span class="mb-1"><i
                                                class="bi bi-telephone me-2 text-primary"></i><?= htmlspecialchars($emp['Phone']) ?></span>
                                        <span><i
                                                class="bi bi-envelope me-2 text-primary"></i><?= htmlspecialchars($emp['Email'] ?? '-') ?></span>
                                    </div>
                                </td>

                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <a href="<?= BASE_URL ?>?act=detailEmployee&id=<?= $emp['EmployeeID'] ?>"
                                            class="btn btn-sm btn-light border text-primary"><i
                                                class="bi bi-eye"></i></a>
                                        <a href="<?= BASE_URL ?>?act=editEmployee&id=<?= $emp['EmployeeID'] ?>"
                                            class="btn btn-sm btn-light border text-warning"><i
                                                class="bi bi-pencil-square"></i></a>
                                        <a href="<?= BASE_URL ?>?act=deleteEmployee&id=<?= $emp['EmployeeID'] ?>"
                                            class="btn btn-sm btn-light border text-danger"
                                            onclick="return confirm('Xóa?')"><i class="bi bi-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">Chưa có dữ liệu nhân sự.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="assignTourModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Phân công Tour</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="?act=assign-employee" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="employee_id" id="modal_employee_id">

                    <div class="mb-3">
                        <label class="form-label">Nhân viên được chọn:</label>
                        <input type="text" class="form-control" id="modal_employee_name" readonly disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Chọn Tour cần gán:</label>
                        <select name="tour_id" class="form-select" required>
                            <option value="">-- Chọn Tour --</option>
                            <?php if(!empty($tours)): ?>
                            <?php foreach($tours as $t): ?>
                            <option value="<?= $t['TourID'] ?>">
                                <?= htmlspecialchars($t['TourName']) ?> (<?= date('d/m', strtotime($t['StartDate'])) ?>)
                            </option>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu phân công</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* CSS Chung cho Layout Admin */
:root {
    --header-height: 70px;
    --sidebar-width: 260px;
}

body {
    background-color: #f5f7fa;
    font-family: 'Segoe UI', sans-serif;
    padding-top: var(--header-height);
}

.sidebar-wrapper {
    width: var(--sidebar-width);
    position: fixed;
    top: var(--header-height);
    bottom: 0;
    left: 0;
    z-index: 100;
    overflow-y: auto;
}

.admin-content {
    margin-left: var(--sidebar-width);
    min-height: calc(100vh - var(--header-height));
}

@media (max-width: 992px) {
    .sidebar-wrapper {
        margin-left: calc(var(--sidebar-width) * -1);
    }

    .admin-content {
        margin-left: 0;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Hàm JS để truyền ID nhân viên vào Modal
function setEmployeeForAssign(id, name) {
    document.getElementById('modal_employee_id').value = id;
    document.getElementById('modal_employee_name').value = name;
}
</script>