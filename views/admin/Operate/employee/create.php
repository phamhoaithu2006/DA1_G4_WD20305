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
                <h2 class="fw-bold text-dark mb-1">Thêm nhân sự mới</h2>
                <p class="text-muted mb-0">Tạo hồ sơ Hướng dẫn viên, Tài xế hoặc Điều hành viên</p>
            </div>
            <a href="index.php?act=employees" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Quay lại
            </a>
        </div>

        <form method="post" enctype="multipart/form-data">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <label for="avatarUpload" class="d-block cursor-pointer">
                                    <img src="https://via.placeholder.com/150" id="avatarPreview"
                                        class="rounded-circle shadow-sm border"
                                        style="width: 150px; height: 150px; object-fit: cover;">
                                    <div class="mt-2 text-primary small fw-bold"><i class="bi bi-camera"></i> Tải ảnh
                                        lên</div>
                                </label>
                                <input type="file" name="avatar" id="avatarUpload" class="d-none" accept="image/*"
                                    onchange="previewImage(this)">
                            </div>
                            <h6 class="text-muted">Ảnh đại diện</h6>
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
                                    placeholder="name@company.com">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control" required placeholder="09xxxxxxxx">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ngày sinh</label>
                                <input type="date" name="dob" class="form-control">
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
                                        placeholder="Nguyễn Văn A">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Vai trò <span class="text-danger">*</span></label>
                                    <select name="role" class="form-select">
                                        <option value="Hướng dẫn viên">Hướng dẫn viên (Tour guide)</option>
                                        <option value="Tài xế">Tài xế (Driver)</option>
                                        <option value="Nhân viên điều hành">Điều hành (Operator)</option>
                                        <option value="Quản lý">Quản lý (Manager)</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Phân loại/Chuyên môn</label>
                                    <select name="type" class="form-select">
                                        <option value="Nội địa">Chuyên Tour Nội địa</option>
                                        <option value="Quốc tế (Inbound)">Chuyên Tour Quốc tế (Inbound)</option>
                                        <option value="Quốc tế (Outbound)">Chuyên Tour Quốc tế (Outbound)</option>
                                        <option value="Chuyên khách đoàn">Chuyên Tour Khách đoàn</option>
                                        <option value="Freelancer">Cộng tác viên (Freelancer)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kinh nghiệm (Năm)</label>
                                    <input type="number" name="exp" class="form-control" value="0" min="0">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Ngôn ngữ thành thạo</label>
                                    <input type="text" name="langs" class="form-control"
                                        placeholder="VD: Tiếng Anh, Tiếng Trung, Tiếng Pháp">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Chứng chỉ/Bằng cấp</label>
                                    <textarea name="certs" class="form-control" rows="2"
                                        placeholder="VD: Thẻ Hướng dẫn viên Quốc tế số, chứng chỉ sơ cấp cứu..."></textarea>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Tình trạng sức khỏe/Lưu ý</label>
                                    <textarea name="health" class="form-control" rows="2"
                                        placeholder="Tốt hoặc các lưu ý đặc biệt (say xe, dị ứng...)"></textarea>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-end gap-2">
                                <button type="reset" class="btn btn-light">Làm mới</button>
                                <button type="submit" class="btn btn-primary px-4 fw-bold">
                                    <i class="bi bi-save me-1"></i> Lưu hồ sơ
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