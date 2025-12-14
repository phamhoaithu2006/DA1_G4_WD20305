<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/../../navbar.php'; ?>

<div class="d-flex admin-layout" style="min-height: 100vh;">
    <div class="sidebar-wrapper bg-white shadow-sm border-end" style="width: 280px; flex-shrink: 0;">
        <?php require_once __DIR__ . '/../../sidebar.php'; ?>
    </div>

    <div class="admin-content flex-grow-1 p-4 bg-light">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Cập nhật hồ sơ nhân sự</h2>
                <p class="text-muted mb-0">Chỉnh sửa thông tin Hướng dẫn viên, Tài xế hoặc Điều hành viên</p>
            </div>
            <a href="index.php?act=employees" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Quay lại
            </a>
        </div>

        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $employee['EmployeeID'] ?? '' ?>">

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <label for="avatarUpload" class="d-block cursor-pointer">
                                    <?php
                                    // Kiểm tra nếu có ảnh cũ thì hiển thị, không thì hiện placeholder
                                    $currentAvatar = !empty($employee['Avatar']) ? $employee['Avatar'] : 'https://via.placeholder.com/150';
                                    ?>
                                    <img src="<?= $currentAvatar ?>" id="avatarPreview"
                                        class="rounded-circle shadow-sm border"
                                        style="width: 150px; height: 150px; object-fit: cover;">

                                    <div class="mt-2 text-primary small fw-bold">
                                        <i class="bi bi-camera"></i> Thay đổi ảnh
                                    </div>
                                </label>
                                <input type="file" name="avatar" id="avatarUpload" class="d-none" accept="image/*"
                                    onchange="previewImage(this)">
                                <input type="hidden" name="old_avatar" value="<?= $employee['Avatar'] ?? '' ?>">
                            </div>
                            <h6 class="text-muted"><?= htmlspecialchars($employee['FullName'] ?? 'Nhân sự') ?></h6>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h6 class="fw-bold text-primary"><i class="bi bi-shield-lock me-2"></i>Thông tin liên hệ
                            </h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" required
                                    value="<?= htmlspecialchars($employee['Email'] ?? '') ?>"
                                    placeholder="name@company.com">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control" required
                                    value="<?= htmlspecialchars($employee['Phone'] ?? '') ?>" placeholder="09xxxxxxxx">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ngày sinh</label>
                                <input type="date" name="dob" class="form-control"
                                    value="<?= $employee['DateOfBirth'] ?? '' ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h5 class="fw-bold text-dark"><i class="bi bi-person-badge me-2"></i>Hồ sơ chuyên môn</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Họ và tên <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" required
                                        value="<?= htmlspecialchars($employee['FullName'] ?? '') ?>"
                                        placeholder="Nguyễn Văn A">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Vai trò <span class="text-danger">*</span></label>
                                    <select name="role" class="form-select">
                                        <?php
                                        $roles = ['Hướng dẫn viên', 'Tài xế', 'Nhân viên điều hành', 'Quản lý'];
                                        $currentRole = $employee['Role'] ?? '';
                                        foreach ($roles as $role):
                                        ?>
                                            <option value="<?= $role ?>" <?= $currentRole == $role ? 'selected' : '' ?>>
                                                <?= $role ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Phân loại/Chuyên môn</label>
                                    <select name="type" class="form-select">
                                        <?php
                                        $types = [
                                            'Nội địa' => 'Chuyên Tour Nội địa',
                                            'Quốc tế (Inbound)' => 'Chuyên Tour Quốc tế (Inbound)',
                                            'Quốc tế (Outbound)' => 'Chuyên Tour Quốc tế (Outbound)',
                                            'Chuyên khách đoàn' => 'Chuyên Tour Khách đoàn',
                                            'Freelancer' => 'Cộng tác viên (Freelancer)'
                                        ];
                                        $currentType = $employee['Type'] ?? '';
                                        foreach ($types as $value => $label):
                                        ?>
                                            <option value="<?= $value ?>" <?= $currentType == $value ? 'selected' : '' ?>>
                                                <?= $label ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kinh nghiệm (Năm)</label>
                                    <input type="number" name="exp" class="form-control" min="0"
                                        value="<?= $employee['ExperienceYears'] ?? 0 ?>">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Ngôn ngữ thành thạo</label>
                                    <input type="text" name="langs" class="form-control"
                                        value="<?= htmlspecialchars($employee['Languages'] ?? '') ?>"
                                        placeholder="VD: Tiếng Anh, Tiếng Trung, Tiếng Pháp">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Chứng chỉ / Bằng cấp</label>
                                    <textarea name="certs" class="form-control" rows="2"
                                        placeholder="VD: Thẻ Hướng dẫn viên Quốc tế số..."><?= htmlspecialchars($employee['Certificates'] ?? '') ?></textarea>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Tình trạng sức khỏe / Lưu ý</label>
                                    <textarea name="health" class="form-control" rows="2"
                                        placeholder="Tốt hoặc các lưu ý đặc biệt..."><?= htmlspecialchars($employee['HealthStatus'] ?? '') ?></textarea>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-end gap-2">
                                <button type="reset" class="btn btn-light">Khôi phục</button>
                                <button type="submit" name="btn_update" class="btn btn-primary px-4 fw-bold">
                                    <i class="bi bi-check-circle me-1"></i> Cập nhật hồ sơ
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>