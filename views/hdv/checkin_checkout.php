<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$hdvName = $_SESSION['hdv_name'] ?? 'HDV';
$tourId = $_GET['id'] ?? null;

$error = $_SESSION['hdv_error'] ?? null;
$success = $_SESSION['hdv_success'] ?? null;
unset($_SESSION['hdv_error'], $_SESSION['hdv_success']);
?>

<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Check-in / Check-out</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --danger-gradient: linear-gradient(135deg, #ff9a9e 0%, #fecfef 99%, #fecfef 100%);
            /* Soft Red */
            --danger-solid: #e11d48;
            --glass-bg: rgba(255, 255, 255, 0.95);
            --bg-color: #f3f4f6;
            --text-main: #1f2937;
        }

        body {
            background-color: var(--bg-color);
            background-image:
                radial-gradient(at 0% 0%, hsla(253, 16%, 7%, 1) 0, transparent 50%),
                radial-gradient(at 50% 100%, hsla(225, 39%, 30%, 1) 0, transparent 50%);
            background-repeat: no-repeat;
            background-size: 100% 400px;
            background-attachment: fixed;
            font-family: 'Plus Jakarta Sans', sans-serif;
            padding-top: 80px;
            color: var(--text-main);
            padding-bottom: 40px;
        }

        /* Navbar Glass */
        .navbar-glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            height: 65px;
        }

        /* Tabs Styling */
        .nav-pills-custom {
            background: #fff;
            padding: 6px;
            border-radius: 50px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            display: flex;
        }

        .nav-pills-custom .nav-link {
            flex: 1;
            border-radius: 50px;
            color: #64748b;
            font-weight: 600;
            padding: 10px;
            transition: all 0.3s;
        }

        .nav-pills-custom .nav-link.active {
            color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .nav-pills-custom .nav-link.active#tab-checkin {
            background: var(--primary-gradient);
        }

        .nav-pills-custom .nav-link.active#tab-checkout {
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
        }

        /* Card Form */
        .glass-card {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
            padding: 24px;
            border: none;
            overflow: hidden;
            position: relative;
        }

        .form-control-custom {
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            border-radius: 12px;
            padding: 14px;
            font-size: 1rem;
        }

        .form-control-custom:focus {
            background-color: #fff;
            outline: none;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            border-color: #6366f1;
        }

        /* Buttons */
        .btn-checkin {
            background: var(--primary-gradient);
            border: none;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-checkout {
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(225, 29, 72, 0.4);
        }

        .btn-action {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            color: white;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: transform 0.2s;
        }

        .btn-action:active {
            transform: scale(0.98);
        }

        /* Timeline Styling */
        .timeline-container {
            position: relative;
            padding-left: 20px;
        }

        .timeline-line {
            position: absolute;
            left: 9px;
            top: 10px;
            bottom: 30px;
            width: 2px;
            background: #e2e8f0;
        }

        .timeline-item {
            position: relative;
            padding-left: 30px;
            padding-bottom: 25px;
        }

        .timeline-dot {
            position: absolute;
            left: 0;
            top: 2px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 2;
        }

        .dot-in {
            background: #6366f1;
        }

        .dot-out {
            background: #e11d48;
        }

        .time-badge {
            font-size: 0.75rem;
            font-weight: 600;
            color: #94a3b8;
            margin-bottom: 4px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand fixed-top navbar-glass px-3">
        <div class="d-flex align-items-center w-100">
            <a href="?act=hdv-tour-detail&id=<?= $tourId ?>"
                class="btn btn-light rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center"
                style="width: 40px; height: 40px;">
                <i class="bi bi-arrow-left text-dark fs-5"></i>
            </a>
            <div class="flex-grow-1 text-center">
                <div class="fw-bold fs-6">Check-in/Check-out</div>
                <div class="small text-muted" style="font-size: 0.75rem;">Quản lý điểm đến</div>
            </div>
            <div style="width: 40px;"></div>
        </div>
    </nav>

    <div class="container" style="max-width: 600px;">

        <?php if ($error): ?>
            <div
                class="alert alert-danger rounded-4 border-0 shadow-sm mb-4 d-flex align-items-center animate__animated animate__shakeX">
                <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
                <div><?= htmlspecialchars($error) ?></div>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div
                class="alert alert-success rounded-4 border-0 shadow-sm mb-4 d-flex align-items-center animate__animated animate__fadeInDown">
                <i class="bi bi-check-circle-fill fs-5 me-2"></i>
                <div><?= htmlspecialchars($success) ?></div>
            </div>
        <?php endif; ?>

        <ul class="nav nav-pills nav-pills-custom" id="pills-tab" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link active w-100" id="tab-checkin" data-bs-toggle="pill"
                    data-bs-target="#pills-checkin" type="button">
                    <i class="bi bi-geo-alt-fill me-1"></i> Check-in
                </button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="tab-checkout" data-bs-toggle="pill" data-bs-target="#pills-checkout"
                    type="button">
                    <i class="bi bi-box-arrow-right me-1"></i> Check-out
                </button>
            </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">

            <div class="tab-pane fade show active animate__animated animate__fadeIn" id="pills-checkin">
                <div class="glass-card">
                    <form method="post" action="?act=hdv-checkin-save&id=<?= $tourId ?>">
                        <div class="text-center mb-4">
                            <div class="d-inline-flex p-3 rounded-circle bg-primary-subtle text-primary mb-2">
                                <i class="bi bi-geo-alt-fill fs-1"></i>
                            </div>
                            <h5 class="fw-bold text-primary">Đến điểm tham quan</h5>
                            <p class="text-muted small">Xác nhận đoàn đã đến địa điểm an toàn</p>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold small text-muted mb-1 text-uppercase">Vị trí hiện tại</label>
                            <input type="text" name="checkin_location" class="form-control form-control-custom"
                                placeholder="Nhập tên địa điểm..." required>
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold small text-muted mb-1 text-uppercase">Ghi chú (Tùy chọn)</label>
                            <textarea name="checkin_note" class="form-control form-control-custom" rows="2"
                                placeholder="VD: Đủ 20 khách, bắt đầu tham quan..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-action btn-checkin">
                            XÁC NHẬN ĐẾN ĐIỂM
                        </button>
                    </form>
                </div>
            </div>

            <div class="tab-pane fade animate__animated animate__fadeIn" id="pills-checkout">
                <div class="glass-card">
                    <form method="post" action="?act=hdv-checkout-save&id=<?= $tourId ?>">
                        <div class="text-center mb-4">
                            <div class="d-inline-flex p-3 rounded-circle bg-danger-subtle text-danger mb-2">
                                <i class="bi bi-box-arrow-right fs-1"></i>
                            </div>
                            <h5 class="fw-bold text-danger">Rời địa điểm</h5>
                            <p class="text-muted small">Xác nhận đoàn rời đi, kiểm tra hành lý</p>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold small text-muted mb-1 text-uppercase">Rời khỏi</label>
                            <input type="text" name="checkout_location" class="form-control form-control-custom"
                                placeholder="Nhập tên địa điểm..." required>
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold small text-muted mb-1 text-uppercase">Ghi chú sự cố</label>
                            <textarea name="checkout_note" class="form-control form-control-custom" rows="2"
                                placeholder="VD: Khách quên đồ, hỏng xe..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-action btn-checkout">
                            XÁC NHẬN RỜI ĐI
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <?php if (!empty($checkinHistory)): ?>
            <div class="mt-5">
                <h6 class="fw-bold text-secondary text-uppercase mb-4 ps-2 border-start border-4 border-primary">
                    Hoạt động gần đây
                </h6>

                <div class="glass-card p-0">
                    <div class="p-4 timeline-container">
                        <div class="timeline-line"></div>

                        <?php foreach ($checkinHistory as $row):
                            // Logic tách chuỗi cũ (giữ nguyên)
                            $locVal = $row['Location'] ?? null;
                            $noteVal = $row['Note'] ?? '';
                            if ($locVal === null && !empty($row['Note'])) {
                                $parts = explode('|', $row['Note']);
                                if (strpos($parts[0], 'Địa điểm:') === 0) {
                                    $locVal = trim(substr($parts[0], strlen('Địa điểm:')));
                                    $noteVal = isset($parts[1]) ? trim($parts[1]) : '';
                                }
                            }

                            $isCheckin = ($row['Type'] === 'checkin');
                            $icon = $isCheckin ? 'bi-geo-alt-fill' : 'bi-box-arrow-right';
                            $colorClass = $isCheckin ? 'text-primary' : 'text-danger';
                            $dotClass = $isCheckin ? 'dot-in' : 'dot-out';
                            $title = $isCheckin ? 'Đã đến' : 'Đã rời';
                        ?>

                            <div class="timeline-item">
                                <div class="timeline-dot <?= $dotClass ?>"></div>

                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div class="time-badge"><i
                                            class="bi bi-clock me-1"></i><?= date('H:i d/m', strtotime($row['CreatedAt'])) ?>
                                    </div>
                                </div>

                                <div class="fw-bold <?= $colorClass ?>" style="font-size: 1.05rem;">
                                    <?= $title ?>: <?= htmlspecialchars($locVal ?? '---') ?>
                                </div>

                                <?php if ($noteVal): ?>
                                    <div
                                        class="mt-2 bg-light p-2 rounded-3 text-secondary small d-inline-block border border-light-subtle">
                                        <i class="bi bi-chat-square-text me-1 opacity-50"></i> <?= htmlspecialchars($noteVal) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Optional: Auto focus input when tab changes
        const triggerTabList = document.querySelectorAll('#pills-tab button')
        triggerTabList.forEach(triggerEl => {
            const tabTrigger = new bootstrap.Tab(triggerEl)
            triggerEl.addEventListener('shown.bs.tab', event => {
                const targetId = event.target.getAttribute('data-bs-target');
                const input = document.querySelector(targetId + ' input[type="text"]');
                if (input) input.focus();
            })
        })
    </script>
</body>

</html>