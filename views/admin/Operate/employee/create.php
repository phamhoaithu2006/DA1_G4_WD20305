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
                <h2 class="fw-bold text-dark mb-1">
                    <?= isset($employee) ? 'Cập nhật thông tin' : 'Thêm nhân sự mới' ?>
                </h2>
                <p class="text-muted mb-0">Vui lòng điền đầy đủ thông tin bên dưới.</p>
            </div>
            <a href="index.php?act=employees" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Quay lại danh sách
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold text-primary"><i class="bi bi-person-vcard me-2"></i>Thông tin cá nhân</h5>
                    </div>

                    <div class="card-body p-4">
                        <form method="post">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-medium text-secondary small text-uppercase">Họ và tên
                                        <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light border-end-0"><i
                                                class="bi bi-person"></i></span>
                                        <input type="text" name="name" class="form-control border-start-0 fs-6"
                                            value="<?= $employee['FullName'] ?? '' ?>" placeholder="Nhập họ tên đầy đủ"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium text-secondary small text-uppercase">Chức
                                        vụ</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light border-end-0"><i
                                                class="bi bi-briefcase"></i></span>
                                        <select name="role" class="form-select border-start-0 fs-6">
                                            <?php $curRole = $employee['Role'] ?? ''; ?>
                                            <option value="Hướng dẫn viên"
                                                <?= $curRole == 'Hướng dẫn viên' ? 'selected' : '' ?>>Hướng dẫn viên
                                            </option>
                                            <option value="Tài xế" <?= $curRole == 'Tài xế' ? 'selected' : '' ?>>Tài xế
                                            </option>
                                            <option value="Nhân viên điều hành"
                                                <?= $curRole == 'Nhân viên điều hành' ? 'selected' : '' ?>>Nhân viên
                                                điều hành</option>
                                            <option value="Quản lý" <?= $curRole == 'Quản lý' ? 'selected' : '' ?>>Quản
                                                lý</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium text-secondary small text-uppercase">Số điện
                                        thoại <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light border-end-0"><i
                                                class="bi bi-telephone"></i></span>
                                        <input type="text" name="phone" class="form-control border-start-0 fs-6"
                                            value="<?= $employee['Phone'] ?? '' ?>" placeholder="09xxxxxxxx" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label
                                        class="form-label fw-medium text-secondary small text-uppercase">Email</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light border-end-0"><i
                                                class="bi bi-envelope"></i></span>
                                        <input type="email" name="email" class="form-control border-start-0 fs-6"
                                            value="<?= $employee['Email'] ?? '' ?>" placeholder="example@email.com">
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4 text-muted opacity-25">

                            <div class="d-flex justify-content-end gap-2">
                                <a href="index.php?act=employees" class="btn btn-light fw-medium px-4">Hủy bỏ</a>
                                <button type="submit" class="btn btn-primary fw-bold px-4 py-2 shadow-sm">
                                    <i class="bi bi-check-lg me-1"></i>
                                    <?= isset($employee) ? 'Lưu thông tin' : 'Thêm mới' ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>