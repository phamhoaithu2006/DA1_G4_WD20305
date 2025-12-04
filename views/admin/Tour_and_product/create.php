<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/../navbar.php'; ?>

<div class="d-flex admin-layout">
    <div class="sidebar-wrapper bg-white shadow-sm border-end">
        <?php require_once __DIR__ . '/../sidebar.php'; ?>
    </div>

    <div class="admin-content flex-grow-1 p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark mb-0">Thêm Tour Mới</h2>
            <a href="?act=category" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại danh sách
            </a>
        </div>

        <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <form action="?act=tour-create" method="POST" enctype="multipart/form-data">
                    <div class="row g-4">

                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tên Tour <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required
                                    placeholder="Ví dụ: Tour Hà Nội - Sapa 3N2Đ">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Danh mục</label>
                                    <select name="category_id" class="form-select" required>
                                        <option value="">-- Chọn danh mục --</option>
                                        <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['CategoryID'] ?>">
                                            <?= htmlspecialchars($cat['CategoryName']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Nhà cung cấp</label>
                                    <select name="supplier_id" class="form-select">
                                        <option value="">-- Chọn nhà cung cấp --</option>
                                        <?php foreach ($suppliers as $sup): ?>
                                        <option value="<?= $sup['SupplierID'] ?>">
                                            <?= htmlspecialchars($sup['SupplierName']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Giá Tour (VNĐ)</label>
                                    <input type="number" name="price" class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Ngày khởi hành</label>
                                    <input type="date" name="start_date" class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Ngày kết thúc</label>
                                    <input type="date" name="end_date" class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Mô tả chi tiết</label>
                                <textarea name="description" class="form-control" rows="5"
                                    placeholder="Nhập lịch trình tóm tắt, điểm nổi bật..."></textarea>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card bg-light border-0">
                                <div class="card-body text-center">
                                    <h6 class="fw-bold mb-3">Hình ảnh đại diện</h6>

                                    <div class="image-preview mb-3 d-flex align-items-center justify-content-center bg-white border rounded"
                                        style="height: 200px; overflow: hidden;">
                                        <img id="imgPreview" src="#" alt="Preview"
                                            style="display: none; width: 100%; height: 100%; object-fit: cover;">
                                        <span id="placeholderText" class="text-muted"><i
                                                class="bi bi-image fs-1"></i></span>
                                    </div>

                                    <input type="file" name="image" class="form-control" id="imgInput" accept="image/*">
                                    <div class="form-text mt-2">Định dạng: JPG, PNG, GIF. Dung lượng tối đa 5MB.</div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-light border px-4">Làm mới</button>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">Lưu Tour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('imgInput').onchange = function(evt) {
    var tgt = evt.target || window.event.srcElement,
        files = tgt.files;

    if (FileReader && files && files.length) {
        var fr = new FileReader();
        fr.onload = function() {
            document.getElementById('imgPreview').src = fr.result;
            document.getElementById('imgPreview').style.display = 'block';
            document.getElementById('placeholderText').style.display = 'none';
        }
        fr.readAsDataURL(files[0]);
    }
}
</script>

<style>
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