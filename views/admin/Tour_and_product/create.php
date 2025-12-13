<?php 
// === GIỮ NGUYÊN LOGIC PHP CŨ ===
require_once __DIR__ . '/../navbar.php'; 
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Tour Mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
    :root {
        --header-height: 70px;
        --sidebar-width: 260px;
    }

    body {
        background-color: #f8f9fc;
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
        background: white;
        border-right: 1px solid #e3e6f0;
    }

    .admin-content {
        margin-left: var(--sidebar-width);
        padding: 1.5rem;
        min-height: calc(100vh - var(--header-height));
    }

    /* Form Styling */
    .form-label {
        font-weight: 600;
        color: #4e5d78;
        font-size: 0.9rem;
    }

    .form-control,
    .form-select {
        border-color: #e0e0e0;
        padding: 0.6rem 1rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    .image-upload-box {
        border: 2px dashed #d1d3e2;
        border-radius: 0.5rem;
        transition: all 0.3s;
        background: #f8f9fc;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .image-upload-box:hover {
        border-color: #4e73df;
        background: #fff;
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
</head>

<body>

    <div class="sidebar-wrapper">
        <?php require_once __DIR__ . '/../sidebar.php'; ?>
    </div>

    <div class="admin-content">
        <div class="container-fluid p-0">

            <form action="?act=tour-create" method="POST" enctype="multipart/form-data">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1 small">
                                <li class="breadcrumb-item"><a href="?act=category" class="text-decoration-none">Quản lý
                                        Tour</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Thêm mới</li>
                            </ol>
                        </nav>
                        <h4 class="fw-bold text-dark mb-0">Tạo Tour du lịch mới</h4>
                    </div>
                    <a href="?act=category" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-x-lg me-1"></i> Hủy bỏ
                    </a>
                </div>

                <?php if (isset($error)): ?>
                <div class="alert alert-danger shadow-sm border-0 mb-4">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $error ?>
                </div>
                <?php endif; ?>

                <div class="row g-4">

                    <div class="col-lg-8">

                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-white py-3">
                                <h6 class="m-0 fw-bold text-primary"><i class="bi bi-info-circle me-2"></i>Thông tin
                                    chung</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <label class="form-label">Tên Tour <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" required
                                        placeholder="Ví dụ: Khám phá Tây Bắc mùa lúa chín - 3N2Đ">
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Danh mục Tour <span
                                                class="text-danger">*</span></label>
                                        <select name="category_id" class="form-select" required>
                                            <option value="">-- Chọn danh mục --</option>
                                            <?php if(isset($categories) && is_array($categories)): ?>
                                            <?php foreach ($categories as $cat): ?>
                                            <option value="<?= $cat['CategoryID'] ?>">
                                                <?= htmlspecialchars($cat['CategoryName']) ?>
                                            </option>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nhà cung cấp</label>
                                        <select name="supplier_id" class="form-select">
                                            <option value="">-- Chọn đối tác --</option>
                                            <?php if(isset($suppliers) && is_array($suppliers)): ?>
                                            <?php foreach ($suppliers as $sup): ?>
                                            <option value="<?= $sup['SupplierID'] ?>">
                                                <?= htmlspecialchars($sup['SupplierName']) ?>
                                            </option>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-white py-3">
                                <h6 class="m-0 fw-bold text-primary"><i class="bi bi-calendar-check me-2"></i>Lịch trình
                                    & Giá</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Ngày khởi hành <span
                                                class="text-danger">*</span></label>
                                        <input type="date" name="start_date" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Ngày kết thúc <span
                                                class="text-danger">*</span></label>
                                        <input type="date" name="end_date" class="form-control" required>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Giá niêm yết <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" name="price" class="form-control" placeholder="0"
                                                required>
                                            <span class="input-group-text">VNĐ</span>
                                        </div>
                                        <div class="form-text text-muted">Giá này chưa bao gồm khuyến mãi (nếu có)
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white py-3">
                                <h6 class="m-0 fw-bold text-primary"><i class="bi bi-text-paragraph me-2"></i>Nội dung
                                    chi tiết</h6>
                            </div>
                            <div class="card-body">
                                <textarea name="description" class="form-control" rows="6"
                                    placeholder="Nhập lịch trình chi tiết, điểm tham quan, lưu ý..."></textarea>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-4">

                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-white py-3">
                                <h6 class="m-0 fw-bold text-success"><i class="bi bi-rocket-takeoff me-2"></i>Hành động
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary fw-bold">
                                        <i class="bi bi-save me-1"></i> Lưu & Công bố
                                    </button>
                                    <button type="reset" class="btn btn-light border">
                                        <i class="bi bi-arrow-counterclockwise me-1"></i> Làm mới
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white py-3">
                                <h6 class="m-0 fw-bold text-primary"><i class="bi bi-image me-2"></i>Ảnh đại diện</h6>
                            </div>
                            <div class="card-body text-center">

                                <div class="image-upload-box mb-3 d-flex align-items-center justify-content-center"
                                    style="height: 200px;" onclick="document.getElementById('imgInput').click();">
                                    <img id="imgPreview" src="#" alt="Preview"
                                        style="display: none; width: 100%; height: 100%; object-fit: cover;">
                                    <div id="placeholderText" class="text-muted">
                                        <i class="bi bi-cloud-arrow-up display-4"></i>
                                        <p class="mt-2 small">Nhấn để tải ảnh lên</p>
                                    </div>
                                </div>

                                <input type="file" name="image" class="form-control form-control-sm" id="imgInput"
                                    accept="image/*" style="display: none;">
                                <button type="button" class="btn btn-sm btn-outline-primary"
                                    onclick="document.getElementById('imgInput').click();">
                                    Chọn tệp ảnh
                                </button>
                                <p class="small text-muted mt-2 mb-0">Hỗ trợ JPG, PNG, GIF. Tối đa 5MB.</p>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Xử lý preview ảnh
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

</body>

</html>