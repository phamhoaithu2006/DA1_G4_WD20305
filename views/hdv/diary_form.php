<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$hdvName = $_SESSION['hdv_name'] ?? 'HDV';
$tourId = $_GET['id'] ?? null;
$logId = $_GET['log_id'] ?? null;
$editMode = !empty($logId);
$log = $log ?? $existingLog ?? null;

$error = $_SESSION['hdv_error'] ?? null;
$success = $_SESSION['hdv_success'] ?? null;
unset($_SESSION['hdv_error'], $_SESSION['hdv_success']);
?>

<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?= $editMode ? 'Cập nhật' : 'Viết' ?> Nhật ký</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #4f46e5;
            /* Indigo chuyên nghiệp */
            --primary-hover: #4338ca;
            --bg-color: #f3f4f6;
            --card-bg: #ffffff;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --border-color: #e5e7eb;
        }

        body {
            background-color: var(--bg-color);
            font-family: 'Inter', sans-serif;
            padding-top: 70px;
            /* Cho Navbar */
            padding-bottom: 100px;
            /* Cho Button Bottom */
            color: var(--text-main);
        }

        /* Navbar mờ ảo (Glassmorphism) */
        .navbar-glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.01);
            height: 60px;
        }

        .page-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-main);
            letter-spacing: -0.025em;
        }

        /* Form Styling */
        .input-group-custom {
            background-color: var(--card-bg);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.25rem;
            border: 1px solid transparent;
            transition: all 0.2s ease;
        }

        .input-group-custom:focus-within {
            border-color: var(--primary-color);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.1);
        }

        .form-label-custom {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 0.75rem;
            display: block;
        }

        .form-control-clean {
            border: none;
            background-color: #f9fafb;
            border-radius: 12px;
            padding: 1rem;
            font-size: 0.95rem;
            width: 100%;
            color: var(--text-main);
            resize: none;
            transition: background 0.2s;
        }

        .form-control-clean:focus {
            outline: none;
            background-color: #fff;
            box-shadow: inset 0 0 0 2px var(--primary-color);
        }

        /* Upload Zone */
        .upload-zone {
            border: 2px dashed var(--border-color);
            border-radius: 16px;
            background-color: #f9fafb;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            overflow: hidden;
        }

        .upload-zone:hover,
        .upload-zone.dragover {
            border-color: var(--primary-color);
            background-color: #eef2ff;
        }

        .upload-icon {
            font-size: 2rem;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
            transition: color 0.2s;
        }

        .upload-zone:hover .upload-icon {
            color: var(--primary-color);
        }

        .preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: 10px;
            margin-top: 15px;
        }

        .preview-item {
            width: 100%;
            aspect-ratio: 1;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border: 2px solid #fff;
        }

        /* Incident Section */
        .incident-box {
            border: 1px solid #fee2e2;
            background-color: #fef2f2;
        }

        .incident-label {
            color: #dc2626;
        }

        .incident-input {
            background-color: #fff;
        }

        .incident-input:focus {
            box-shadow: inset 0 0 0 2px #dc2626;
        }

        /* Bottom Bar */
        .bottom-bar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1rem 1.5rem;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .btn-submit {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 12px;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
            transition: transform 0.1s;
        }

        .btn-submit:active {
            transform: scale(0.98);
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand fixed-top navbar-glass px-3">
        <div class="d-flex align-items-center w-100">
            <a href="?act=hdv-tour-detail&id=<?= $tourId ?>" class="text-dark me-3 p-2">
                <i class="bi bi-arrow-left fs-5"></i>
            </a>
            <div class="page-title flex-grow-1 text-center">
                <?= $editMode ? 'Chỉnh sửa ghi chép' : 'Nhật ký mới' ?>
            </div>
            <div style="width: 40px;"></div>
        </div>
    </nav>

    <div class="container" style="max-width: 600px;">

        <?php if ($error): ?>
            <div class="alert alert-danger rounded-4 border-0 shadow-sm mb-4 d-flex align-items-center">
                <i class="bi bi-exclamation-circle-fill fs-5 me-2"></i>
                <div><?= htmlspecialchars($error) ?></div>
            </div>
        <?php endif; ?>

        <form method="post" action="?act=hdv-diary-save&id=<?= $tourId ?><?= $editMode ? '&log_id=' . $logId : '' ?>"
            enctype="multipart/form-data">

            <div class="input-group-custom">
                <label class="form-label-custom">
                    <i class="bi bi-pencil-square me-1"></i> Nội dung ghi chép
                </label>
                <textarea class="form-control-clean" name="note" rows="8"
                    placeholder="Mô tả chi tiết hoạt động, cảm nhận của khách, địa điểm đã qua..."
                    required><?= htmlspecialchars($log['Note'] ?? '') ?></textarea>
            </div>

            <div class="input-group-custom">
                <label class="form-label-custom">
                    <i class="bi bi-images me-1"></i> Hình ảnh thực tế
                </label>

                <div class="upload-zone" onclick="document.getElementById('images').click()">
                    <i class="bi bi-cloud-arrow-up-fill upload-icon"></i>
                    <div class="fw-medium text-dark">Chạm để tải ảnh lên</div>
                    <div class="small text-muted mt-1">Hỗ trợ JPG, PNG (Max 5MB)</div>
                    <input type="file" name="images[]" id="images" accept="image/*" multiple hidden>
                </div>

                <div id="imagePreview" class="preview-grid">
                    <?php if ($editMode && !empty($log['Images'])):
                        $imgs = json_decode($log['Images'], true) ?? [];
                        foreach ($imgs as $imgPath): ?>
                            <img src="<?= htmlspecialchars($imgPath) ?>" class="preview-item">
                    <?php endforeach;
                    endif; ?>
                </div>
            </div>

            <div class="input-group-custom incident-box">
                <label class="form-label-custom incident-label">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Báo cáo sự cố (Nếu có)
                </label>
                <textarea class="form-control-clean incident-input" name="incident" rows="3"
                    placeholder="Mô tả vấn đề phát sinh: hỏng xe, khách ốm, thất lạc đồ..."><?= htmlspecialchars($log['Incident'] ?? '') ?></textarea>
            </div>

            <div class="bottom-bar">
                <button type="submit" class="btn-submit">
                    <?= $editMode ? 'CẬP NHẬT NHẬT KÝ' : 'HOÀN TẤT & LƯU' ?>
                </button>
            </div>

        </form>
    </div>

    <script>
        const imageInput = document.getElementById('images');
        const previewContainer = document.getElementById('imagePreview');

        imageInput.addEventListener('change', function(e) {
            // Nếu muốn xóa ảnh cũ khi chọn ảnh mới thì uncomment dòng dưới
            // previewContainer.innerHTML = ''; 

            const files = [...e.target.files];

            files.forEach(file => {
                if (file.type.startsWith("image/")) {
                    const reader = new FileReader();
                    reader.onload = evt => {
                        const img = document.createElement('img');
                        img.src = evt.target.result;
                        img.className = 'preview-item animate__animated animate__fadeIn';
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });

        // Hiệu ứng kéo thả (Drag & Drop)
        const dropZone = document.querySelector('.upload-zone');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropZone.classList.add('dragover');
        }

        function unhighlight(e) {
            dropZone.classList.remove('dragover');
        }

        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            imageInput.files = files;
            // Trigger change event thủ công
            const event = new Event('change');
            imageInput.dispatchEvent(event);
        }
    </script>

</body>

</html>