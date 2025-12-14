<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/../navbar.php'; ?>

<div class="d-flex admin-layout">
    <div class="sidebar-wrapper bg-white shadow-sm border-end">
        <?php require_once __DIR__ . '/../sidebar.php'; ?>
    </div>

    <div class="admin-content flex-grow-1 p-4">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Cập nhật nhật ký</h2>
                <p class="text-muted mb-0">Chỉnh sửa thông tin nhật ký của Tour #<?= $log['TourID'] ?></p>
            </div>

            <a href="<?= BASE_URL ?>?act=tourlog-list&tourID=<?= $log['TourID'] ?>" class="btn btn-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Quay lại
            </a>
        </div>

        <!-- Form Card -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">

                <form action="<?= BASE_URL ?>?act=tourlog-update&id=<?= $log['LogID'] ?>"
                    method="POST" enctype="multipart/form-data">


                    <input type="hidden" name="tour_id" value="<?= $log['TourID'] ?>">

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Nhân sự </label>
                        <select name="employee_id" class="form-select rounded-3" required>
                            <option value="">-- Chọn nhân sự --</option>
                            <?php
                            // GIẢ ĐỊNH: Biến $employees chứa danh sách nhân viên từ DB (bảng employee)
                            // Cấu trúc của mỗi phần tử trong $employees là: ['EmployeeID' => X, 'FullName' => Y, 'Role' => Z]
                            if (!empty($employees)) {
                                foreach ($employees as $employee) {
                                    // Hiển thị chỉ những người có vai trò là Hướng dẫn viên (nếu cần)
                                    // Dựa trên dữ liệu bạn cung cấp, Role có thể là 'Hướng dẫn viên'
                                    if ($employee['Role'] == 'Hướng dẫn viên' || $employee['Role'] == 'Admin') {
                                        echo "<option value='{$employee['EmployeeID']}'>{$employee['FullName']} ({$employee['Role']})</option>";
                                    }
                                }
                            } else {
                                echo "<option value='' disabled>Không tìm thấy nhân viên nào.</option>";
                            }
                            ?>
                        </select>
                    </div>


                    <!-- NOTE -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Ghi chú (Note):</label>
                        <textarea name="note" class="form-control rounded-3" rows="4" required><?= htmlspecialchars($log['Note']) ?></textarea>
                    </div>

                    <!-- INCIDENT -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Sự cố phát sinh (Nếu có):</label>
                        <textarea name="incident" class="form-control rounded-3" rows="2">
                            <?= htmlspecialchars($log['Incident'] ?? '') ?>
                        </textarea>
                    </div>

                    <!-- IMAGE -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Hình ảnh hiện tại:</label><br>

                        <?php if (!empty($log['Images'])): ?>
                            <img src="<?= $log['Images'] ?>" class="rounded shadow-sm mb-3"
                                style="width: 160px; height: 120px; object-fit: cover;">
                        <?php else: ?>
                            <p class="text-muted">Chưa có ảnh</p>
                        <?php endif; ?>

                        <label class="form-label fw-semibold">Chọn ảnh mới (Nếu muốn thay đổi):</label>
                        <input type="file" name="image" class="form-control rounded-3" accept="image/*">
                    </div>

                    <!-- BUTTON -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= BASE_URL ?>?act=tourlog-list&tourID=<?= $log['TourID'] ?>"
                            class="btn btn-light border shadow-sm">
                            <i class="bi bi-x-circle me-1"></i> Hủy
                        </a>

                        <button type="submit" class="btn btn-warning shadow-sm text-dark">
                            <i class="bi bi-save me-1"></i> Cập nhật
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>