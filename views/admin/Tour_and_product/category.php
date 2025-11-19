<?php require_once __DIR__ . '/../sidebar.php'; ?>

<?php
// Nhóm tour theo Category
$grouped = [];
foreach ($tours as $tour) {
    $grouped[$tour['CategoryName']][] = $tour;
}
?>

<div class="container-fluid custom-container mt-4">
    <h2 class="mb-4 text-primary">Danh sách Tour Du Lịch</h2>

    <?php foreach ($grouped as $categoryName => $tourList): ?>
    <h4 class="mt-4 text-success"><?= htmlspecialchars($categoryName) ?></h4>
    <div class="row gx-3">
        <?php foreach ($tourList as $tour): ?>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= htmlspecialchars($tour['TourName']) ?></h5>
                    <p class="card-text mb-1">
                        <strong>Nhà cung cấp:</strong> <?= htmlspecialchars($tour['SupplierName'] ?? 'Không có') ?>
                    </p>
                    <p class="card-text mb-1">
                        <strong>Giá:</strong> <?= number_format($tour['Price'],0,',','.') ?> đ
                    </p>
                    <p class="card-text mb-1">
                        <strong>Khởi hành:</strong> <?= $tour['StartDate'] ?>
                    </p>
                    <p class="card-text mb-2">
                        <strong>Kết thúc:</strong> <?= $tour['EndDate'] ?>
                    </p>
                    <a href="<?= BASE_URL ?>?act=detail&id=<?= $tour['CategoryID'] ?>"
                        class="btn btn-primary mt-auto">Xem
                        chi tiết</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
</div>

<style>
.custom-container {
    padding-left: 30px;
    /* cách mép trái 150px */
    padding-right: 30px;
    /* cách mép phải 150px */
}
</style>