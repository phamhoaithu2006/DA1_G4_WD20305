<?php
// views/hdv/Diary/diary_form.php
// Form thêm/cập nhật nhật ký tour

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Thông tin HDV và tour
$hdvName  = $_SESSION['hdv_name'] ?? 'HDV';
$tourId   = $_GET['id'] ?? null;

// Log id để biết đang sửa hay thêm
$logId    = $_GET['log_id'] ?? null;
$editMode = !empty($logId);

// Ưu tiên lấy dữ liệu log từ controller
$log = $log ?? $existingLog ?? null;

// Thông báo
$error   = $_SESSION['hdv_error'] ?? null;
$success = $_SESSION['hdv_success'] ?? null;
unset($_SESSION['hdv_error'], $_SESSION['hdv_success']);

?>

<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $editMode ? 'Cập nhật' : 'Thêm mới' ?> nhật ký tour</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .image-preview {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #ddd;
            margin: 4px;
        }
    </style>
</head>

<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand navbar-dark bg-primary">
        <div class="container-fluid">

            <a class="navbar-brand" href="?act=hdv-tour-detail&id=<?= $tourId ?>">
                HDV - <?= htmlspecialchars($hdvName) ?>
            </a>

            <div class="d-flex">
                <a class="btn btn-outline-light btn-sm me-2" href="?act=hdv-tour">Danh sách tour</a>
                <a class="btn btn-outline-light btn-sm" href="?act=hdv-logout">Đăng xuất</a>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">

                <div class="card shadow">

                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><?= $editMode ? 'Cập nhật nhật ký' : 'Thêm nhật ký mới' ?></h5>
                    </div>

                    <div class="card-body">

                        <!-- Thông báo -->
                        <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <?= htmlspecialchars($error) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if ($success): ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <?= htmlspecialchars($success) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Form -->
                        <form
                            method="post"
                            action="?act=hdv-diary-save&id=<?= $tourId ?><?= $editMode ? '&log_id=' . $logId : '' ?>"
                            enctype="multipart/form-data">

                            <!-- Ghi chú -->
                            <div class="mb-3">
                                <label class="form-label">Ghi chú/Sự kiện <span class="text-danger">*</span></label>
                                <textarea
                                    class="form-control"
                                    name="note"
                                    rows="6"
                                    required><?= htmlspecialchars($log['Note'] ?? '') ?></textarea>
                                <small class="text-muted">Ghi lại hoạt động hoặc sự cố xảy ra trong tour</small>
                            </div>

                            <!-- Hình ảnh -->
                            <div class="mb-3">
                                <label class="form-label">Hình ảnh (tùy chọn)</label>
                                <input
                                    type="file"
                                    class="form-control"
                                    name="images[]"
                                    id="images"
                                    accept="image/*"
                                    multiple>
                                <small class="text-muted">Có thể chọn nhiều hình</small>

                                <?php if ($editMode && !empty($log['Images'])): ?>
                                    <div class="mt-3">
                                        <small class="text-muted">Hình hiện tại:</small>
                                        <div class="d-flex flex-wrap">
                                            <?php
                                            $imgs = json_decode($log['Images'], true) ?? [];
                                            foreach ($imgs as $imgPath): ?>
                                                <img src="<?= htmlspecialchars($imgPath) ?>" class="image-preview">
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Preview ảnh mới -->
                                <div id="imagePreview" class="mt-3 d-flex flex-wrap"></div>
                            </div>

                            <!-- Sự cố -->
                            <div class="mb-3">
                                <label class="form-label">Sự cố (nếu có)</label>
                                <textarea
                                    class="form-control"
                                    name="incident"
                                    rows="3"><?= htmlspecialchars($log['Incident'] ?? '') ?></textarea>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex justify-content-end gap-2">
                                <a href="?act=hdv-tour-detail&id=<?= $tourId ?>" class="btn btn-secondary">Hủy</a>
                                <button type="submit" class="btn btn-primary">
                                    <?= $editMode ? 'Cập nhật' : 'Lưu nhật ký' ?>
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Preview ảnh mới chọn -->
    <script>
        document.getElementById('images').addEventListener('change', function(e) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';

            [...e.target.files].forEach(file => {
                if (file.type.startsWith("image/")) {
                    const reader = new FileReader();
                    reader.onload = evt => {
                        const img = document.createElement('img');
                        img.src = evt.target.result;
                        img.className = 'image-preview';
                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>

</body>

</html>