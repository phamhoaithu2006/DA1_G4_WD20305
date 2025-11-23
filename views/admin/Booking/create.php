<<<<<<< HEAD
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/../sidebar.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4 text-primary">Tạo booking mới</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
=======
<?php require_once __DIR__ . '/../sidebar.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4 text-primary">Tạo Booking mới</h2>

    <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
>>>>>>> 3ffeda95b17b161d1c7f83d77992cd563572f79d
    <?php endif; ?>

    <form method="post" action="<?= BASE_URL ?>?act=booking-create">
        <div class="mb-3">
            <label for="customer_id" class="form-label">Khách hiện có (chọn nếu đã có)</label>
            <select name="customer_id" id="customer_id" class="form-select">
<<<<<<< HEAD
                <option value="">- Khách mới -</option>
=======
                <option value="">-- Khách mới --</option>
>>>>>>> 3ffeda95b17b161d1c7f83d77992cd563572f79d
                <?php
                // Lấy khách từ DB
                $customers = connectDB()->query("SELECT CustomerID, FullName FROM Customer ORDER BY FullName")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($customers as $c): ?>
<<<<<<< HEAD
                    <option value="<?= $c['CustomerID'] ?>"><?= htmlspecialchars($c['FullName']) ?></option>
=======
                <option value="<?= $c['CustomerID'] ?>"><?= htmlspecialchars($c['FullName']) ?></option>
>>>>>>> 3ffeda95b17b161d1c7f83d77992cd563572f79d
                <?php endforeach; ?>
            </select>
        </div>

        <h5 class="mt-4">Thông tin khách mới (nếu không chọn khách hiện có)</h5>
        <div class="mb-3">
            <label for="fullname" class="form-label">Họ tên</label>
            <input type="text" name="fullname" id="fullname" class="form-control" />
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" />
        </div>
        <div class="mb-3">
<<<<<<< HEAD
            <label for="phone" class="form-label">Số điện thoại</label>
=======
            <label for="phone" class="form-label">Phone</label>
>>>>>>> 3ffeda95b17b161d1c7f83d77992cd563572f79d
            <input type="text" name="phone" id="phone" class="form-control" />
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ</label>
            <input type="text" name="address" id="address" class="form-control" />
        </div>

        <div class="mb-3">
<<<<<<< HEAD
            <label for="tour_id" class="form-label">Chọn tour</label>
            <select name="tour_id" id="tour_id" class="form-select" required>
                <option value="">-- Chọn Tour --</option>
                <?php foreach ($tours as $t): ?>
                    <option value="<?= $t['TourID'] ?>" data-price="<?= $t['Price'] ?>">
                        <?= htmlspecialchars($t['TourName']) ?> (<?= number_format($t['Price'], 0, ',', '.') ?> đ)
                    </option>
=======
            <label for="tour_id" class="form-label">Chọn Tour</label>
            <select name="tour_id" id="tour_id" class="form-select" required>
                <option value="">-- Chọn Tour --</option>
                <?php foreach ($tours as $t): ?>
                <option value="<?= $t['TourID'] ?>" data-price="<?= $t['Price'] ?>">
                    <?= htmlspecialchars($t['TourName']) ?> (<?= number_format($t['Price'],0,',','.') ?> đ)
                </option>
>>>>>>> 3ffeda95b17b161d1c7f83d77992cd563572f79d
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="num_people" class="form-label">Số người</label>
            <input type="number" name="num_people" id="num_people" class="form-control" value="1" min="1" />
        </div>

        <div class="mb-3">
            <label for="note" class="form-label">Ghi chú</label>
            <textarea name="note" id="note" class="form-control" rows="3"></textarea>
        </div>

        <!-- Hidden input để gửi danh sách khách đoàn nếu dùng JS -->
        <input type="hidden" name="group_members" id="group_members" />

<<<<<<< HEAD
        <button type="submit" class="btn btn-primary">Tạo booking</button>
=======
        <button type="submit" class="btn btn-primary">Tạo Booking</button>
>>>>>>> 3ffeda95b17b161d1c7f83d77992cd563572f79d
    </form>
</div>

<script>
<<<<<<< HEAD
    // (Tuỳ chọn) JS để tính tổng tiền tạm thời hoặc thêm khách đoàn
=======
// (Tuỳ chọn) JS để tính tổng tiền tạm thời hoặc thêm khách đoàn
>>>>>>> 3ffeda95b17b161d1c7f83d77992cd563572f79d
</script>