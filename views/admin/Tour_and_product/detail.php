<?php require_once __DIR__ . '/../sidebar.php'; ?>
<div class="container-fluid custom-container mt-4">
    <h2 class="mb-4 text-primary">Chi tiết Tour Du Lịch</h2>

    <?php if (!empty($tour) && is_array($tour)): ?>
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($tour['TourName']) ?></h5>
            <p class="card-text mb-1">
                <strong>Danh mục:</strong> <?= htmlspecialchars($tour['CategoryName']) ?>
            </p>
            <p class="card-text mb-1">
                <strong>Nhà cung cấp:</strong> <?= htmlspecialchars($tour['SupplierName']) ?>
            </p>
            <p class="card-text mb-1">
                <strong>Giá:</strong> <?= number_format($tour['Price'], 0, ',', '.') ?> đ
            </p>
            <p class="card-text mb-1">
                <strong>Khởi hành:</strong> <?= htmlspecialchars($tour['StartDate']) ?>
            </p>
            <p class="card-text mb-2">
                <strong>Kết thúc:</strong> <?= htmlspecialchars($tour['EndDate']) ?>
            </p>
            <p class="card-text">
                <strong>Mô tả:</strong> <?= htmlspecialchars($tour['Description']) ?>
            </p>
        </div>
    </div>
    <?php else: ?>
    <p>Không có dữ liệu tour.</p>
    <?php endif; ?>
</div>