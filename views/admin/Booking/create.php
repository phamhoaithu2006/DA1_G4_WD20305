<?php require_once __DIR__ . '/../sidebar.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4 text-primary">Tạo Booking mới</h2>

    <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="<?= BASE_URL ?>?act=booking-create">
        <div class="mb-3">
            <label for="customer_id" class="form-label">Khách hiện có (chọn nếu đã có)</label>
            <select name="customer_id" id="customer_id" class="form-select">
                <option value="">-- Khách mới --</option>
                <?php
                // Lấy khách từ DB
                $customers = connectDB()->query("SELECT CustomerID, FullName FROM Customer ORDER BY FullName")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($customers as $c): ?>
                <option value="<?= $c['CustomerID'] ?>"><?= htmlspecialchars($c['FullName']) ?></option>
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
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" />
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ</label>
            <input type="text" name="address" id="address" class="form-control" />
        </div>

        <div class="mb-3">
            <label for="tour_id" class="form-label">Chọn Tour</label>
            <select name="tour_id" id="tour_id" class="form-select" required>
                <option value="">-- Chọn Tour --</option>
                <?php foreach ($tours as $t): ?>
                <option value="<?= $t['TourID'] ?>" data-price="<?= $t['Price'] ?>">
                    <?= htmlspecialchars($t['TourName']) ?> (<?= number_format($t['Price'],0,',','.') ?> đ)
                </option>
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

        <button type="submit" class="btn btn-primary">Tạo Booking</button>
    </form>
</div>

<script>
// (Tuỳ chọn) JS để tính tổng tiền tạm thời hoặc thêm khách đoàn
</script>