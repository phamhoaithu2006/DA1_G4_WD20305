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
                <h2 class="fw-bold text-dark mb-1">Quản lý nhân sự</h2>
                <p class="text-muted mb-0">Danh sách Hướng dẫn viên, Tài xế và Nhân viên điều hành</p>
            </div>
            <a href="?act=createEmployee" class="btn btn-primary shadow-sm fw-bold">
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
                                <th class="py-3 text-secondary small text-uppercase fw-bold">Trạng thái/Tour</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold">Liên hệ</th>
                                <th class="pe-4 py-3 text-secondary small text-uppercase fw-bold text-end">Hành động
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($employees)): ?>
                                <?php foreach ($employees as $emp):
                                    // Logic Avatar chữ cái đầu
                                    $avatarChar = strtoupper(substr($emp['FullName'] ?? 'U', 0, 1));
                                    $avatarColor = 'bg-primary-subtle text-primary';
                                    if ($emp['Role'] == 'Tài xế') $avatarColor = 'bg-warning-subtle text-warning-emphasis';
                                    if ($emp['Role'] == 'Quản lý') $avatarColor = 'bg-danger-subtle text-danger';
                                ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle <?= $avatarColor ?> fw-bold d-flex align-items-center justify-content-center me-3"
                                                    style="width: 45px; height: 45px; font-size: 1.1rem;">
                                                    <?= $avatarChar ?>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark"><?= htmlspecialchars($emp['FullName']) ?>
                                                    </div>
                                                    <div class="text-muted small">ID: #<?= $emp['EmployeeID'] ?></div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <span
                                                class="badge bg-light text-dark border"><?= htmlspecialchars($emp['Role'] ?? 'Nhân viên') ?></span>
                                        </td>

                                        <td>
                                            <?php if (!empty($emp['TourName'])): ?>
                                                <div
                                                    class="d-flex align-items-center justify-content-between bg-light rounded p-2 border">
                                                    <div class="me-2">
                                                        <div class="d-flex align-items-center mb-1">
                                                            <span class="badge bg-success-subtle text-success me-2"
                                                                style="font-size: 0.65rem;">Đang dẫn</span>
                                                            <div class="fw-bold text-dark text-truncate" style="max-width: 180px;"
                                                                title="<?= htmlspecialchars($emp['TourName']) ?>">
                                                                <?= htmlspecialchars($emp['TourName']) ?>
                                                            </div>
                                                        </div>
                                                        <div class="text-muted small" style="font-size: 0.75rem;">
                                                            <i class="bi bi-calendar3 me-1"></i>
                                                            <?= date('d/m', strtotime($emp['StartDate'])) ?> -
                                                            <?= date('d/m', strtotime($emp['EndDate'])) ?>
                                                        </div>
                                                    </div>

                                                </div>
                                            <?php else: ?>
                                                <button class="btn btn-sm btn-outline-primary rounded-pill px-3 shadow-sm fw-bold"
                                                    data-bs-toggle="modal" data-bs-target="#assignTourModal"
                                                    onclick="setEmployeeForAssign('<?= $emp['EmployeeID'] ?>', '<?= htmlspecialchars($emp['FullName']) ?>')">
                                                    <i class="bi bi-plus-circle me-1"></i> Phân công
                                                </button>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <div class="d-flex flex-column small">
                                                <a href="tel:<?= $emp['Phone'] ?>"
                                                    class="text-decoration-none text-secondary mb-1">
                                                    <i
                                                        class="bi bi-telephone me-2 text-primary"></i><?= htmlspecialchars($emp['Phone']) ?>
                                                </a>
                                                <a href="mailto:<?= $emp['Email'] ?>"
                                                    class="text-decoration-none text-secondary">
                                                    <i
                                                        class="bi bi-envelope me-2 text-primary"></i><?= htmlspecialchars($emp['Email'] ?? '-') ?>
                                                </a>
                                            </div>
                                        </td>

                                        <td class="text-end pe-4">
                                            <div class="btn-group shadow-sm">
                                                <a href="?act=detailEmployee&id=<?= $emp['EmployeeID'] ?>"
                                                    class="btn btn-sm btn-white border text-primary" title="Xem chi tiết">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="?act=editEmployee&id=<?= $emp['EmployeeID'] ?>"
                                                    class="btn btn-sm btn-white border text-warning" title="Sửa">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <a href="?act=deleteEmployee&id=<?= $emp['EmployeeID'] ?>"
                                                    class="btn btn-sm btn-white border text-danger"
                                                    onclick="return confirm('Bạn chắc chắn muốn xóa nhân viên này?')"
                                                    title="Xóa">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-people display-4 opacity-25"></i>
                                        <p class="mt-3">Chưa có dữ liệu nhân sự</p>
                                    </td>
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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-primary text-white border-bottom-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-calendar-check me-2"></i>Phân công lịch trình</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <form action="?act=assign-staff" method="POST">
                <div class="modal-body p-4">
                    <input type="hidden" name="employee_id" id="modal_employee_id">

                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold text-uppercase">Nhân viên được chọn</label>
                        <input type="text" class="form-control bg-light fw-bold text-primary border-0"
                            id="modal_employee_name" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold text-uppercase">Chọn Tour sắp tới</label>
                        <select name="tour_id" class="form-select form-select-lg shadow-sm" required>
                            <option value="" selected disabled>-- Vui lòng chọn Tour --</option>
                            <?php if (!empty($tours)): ?>
                                <?php foreach ($tours as $t): ?>
                                    <option value="<?= $t['TourID'] ?>">
                                        [<?= date('d/m', strtotime($t['StartDate'])) ?>] <?= htmlspecialchars($t['TourName']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled>Không có tour nào sắp tới</option>
                            <?php endif; ?>
                        </select>
                        <div class="form-text mt-2"><i class="bi bi-info-circle"></i> Chỉ hiện các tour chưa khởi hành
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top-0 px-4 pb-4">
                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4 shadow-sm">
                        <i class="bi bi-check-lg me-1"></i> Xác nhận phân công
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Hàm JS để truyền dữ liệu vào Modal khi bấm nút
    function setEmployeeForAssign(id, name) {
        document.getElementById('modal_employee_id').value = id;
        document.getElementById('modal_employee_name').value = name;
    }
</script>